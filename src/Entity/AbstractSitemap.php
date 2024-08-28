<?php

namespace Lampa\Entity;

use Lampa\Exceptions\InvalidInitialUrlValueException;
use Lampa\Exceptions\InsufficientPermissionsWriteException;
use Lampa\Url;

/**
 * Abstract class for generating sitemaps.
 *
 * This class provides methods for managing URLs and saving the sitemap to a file.
 * It also includes an abstract method for generating the sitemap content.
 */
abstract class AbstractSitemap
{
    private array $urls;

    private string $path;

    public static array $allowedKeysUrl = [
        'url',
        'lastMod',
        'priority',
        'frequency'
    ];

    /**
     * Generates the sitemap content.
     *
     * @return bool Returns true if the sitemap generation is successful, false otherwise.
     */
    abstract function generate(): bool;

    /**
     * Constructor.
     *
     * Initializes the sitemap with the given URLs and path.
     *
     * @param array $urls An array of URLs to be included in the sitemap.
     * @param string $path The path where the sitemap file will be saved.
     */
    public function __construct(array $urls, string $path)
    {
        $this->setUrls($urls);
        $this->setPath($path);
    }

    /**
     * Sets the URLs for the sitemap.
     *
     * @param array $urls An array of URLs to be included in the sitemap.
     * @return self Returns the current instance for method chaining.
     */
    public function setUrls(array $urls): self
    {
        array_map(function ($url) {
            $this->addUrl($url);
        }, $urls);

        return $this;
    }

    /**
     * Adds a URL to the sitemap.
     *
     * @param array|Url $url The URL to be added. If an array is provided, it should contain the keys 'url', 'lastMod', 'priority', and 'frequency'.
     * @return self Returns the current instance for method chaining.
     * @throws InvalidInitialUrlValueException If the provided URL array contains keys other than 'url', 'lastMod', 'priority', and 'frequency'.
     */
    public function addUrl(array|Url $url): self
    {
        if (is_array($url) && $elements = array_diff(array_keys($url), self::$allowedKeysUrl)) {
            throw new InvalidInitialUrlValueException($elements);
        }

        $this->urls[] = ($url instanceof Url)
            ? $url
            : Url::make(
                url: $url['url'],
                lastMod: $url['lastMod'],
                priority: $url['priority'],
                frequency: $url['frequency']
            );

        return $this;
    }

    /**
     * Retrieves the URLs for the sitemap.
     *
     * @return array Returns an array of URLs included in the sitemap.
     */
    protected function getUrls(): array
    {
        return $this->urls;
    }

    /**
     * Sets the path for the sitemap file.
     *
     * @param string $path The path where the sitemap file will be saved.
     * @return self Returns the current instance for method chaining.
     * @throws InsufficientPermissionsWriteException If the provided path is not writable.
     */
    public function setPath(string $path): self
    {
        if (!file_exists($path) && !touch($path) && !is_writable($path)) {
            throw new InsufficientPermissionsWriteException();
        }

        $this->path = $path;

        return $this;
    }

    /**
     * Retrieves the path for the sitemap file.
     *
     * @return string Returns the path where the sitemap file is saved.
     */
    protected function getPath(): string
    {
        return $this->path;
    }

    /**
     * Saves the sitemap content to a file.
     *
     * @param string $file The sitemap content to be saved.
     * @return bool Returns true if the sitemap content is successfully saved to the file, false otherwise.
     */
    protected function saveFile($file): bool
    {
        return file_put_contents($this->path, $file);
    }
}