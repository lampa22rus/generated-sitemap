<?php

namespace Lampa;

use DateTime;
use http\Exception\InvalidArgumentException;
use Lampa\Enums\ValidFrequenciesEnum;
use Lampa\Exceptions\InvalidInitialArgument;

class Url
{
    protected string $url;
    protected string $lastMod;

    protected float $priority;
    protected string $frequency;

    /**
     * Constructor for the Url class.
     *
     * Initializes a new instance of the Url class with the provided parameters.
     *
     * @param string $url The URL of the page. Must be a valid URL.
     * @param string|DateTime $lastMod The last modification date of the page. Can be a string in a recognized format or a DateTime object.
     * @param float $priority The priority of the page for search engines. Must be a float between 0.0 and 1.0. Default is 1.0.
     * @param string|ValidFrequenciesEnum $frequency The change frequency of the page for search engines. Must be a string from the ValidFrequenciesEnum or a corresponding enum value. Default is ValidFrequenciesEnum::WEEKLY.
     * @throws InvalidInitialArgument
     */
    public function __construct(
        string $url,
        string|DateTime $lastMod,
        float $priority = 1,
        string|ValidFrequenciesEnum $frequency = ValidFrequenciesEnum::WEEKLY
    ) {
        $this->setUrl($url);
        $this->setLastMod($lastMod);
        $this->setPriority($priority);
        $this->setFrequency($frequency);
    }

    /**
     * Creates a new instance of the Url class.
     *
     * This method is a static factory method that allows for easy instantiation of the Url class.
     * It takes the same parameters as the constructor and returns a new instance of the Url class.
     *
     * @param string $url The URL of the page. Must be a valid URL.
     * @param string|DateTime $lastMod The last modification date of the page. Can be a string in a recognized format or a DateTime object.
     * @param float $priority The priority of the page for search engines. Must be a float between 0.0 and 1.0. Default is 1.0.
     * @param string|ValidFrequenciesEnum $frequency The change frequency of the page for search engines. Must be a string from the ValidFrequenciesEnum or a corresponding enum value. Default is ValidFrequenciesEnum::WEEKLY.
     * @return self A new instance of the Url class.
     * @throws InvalidInitialArgument If any of the provided parameters are invalid.
     */
    public static function make(
        string $url,
        string|DateTime $lastMod,
        float $priority = 1,
        string|ValidFrequenciesEnum $frequency = ValidFrequenciesEnum::WEEKLY
    ): self {
        return new self($url, $lastMod, $priority, $frequency);
    }

    /**
     * Sets the URL for the page.
     *
     * This method validates the provided URL and sets it as the URL for the page.
     * If the URL is not valid, it throws an InvalidInitialArgument exception.
     *
     * @param string $url The URL of the page. Must be a valid URL.
     * @return self The current instance of the Url class.
     * @throws InvalidInitialArgument If the provided URL is not valid.
     */
    public function setUrl(string $url): self
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidInitialArgument("url");
        }
        $this->url = $url;

        return $this;
    }

    /**
     * Sets the last modification date for the page.
     *
     * This method validates the provided last modification date and sets it as the last modification date for the page.
     * If the last modification date is not valid, it throws an InvalidInitialArgument exception.
     *
     * @param string|DateTime $lastMod The last modification date of the page. Can be a string in a recognized format or a DateTime object.
     * @param string $format The format in which the last modification date should be stored. Default is 'c' (ISO 8601).
     * @return self The current instance of the Url class.
     * @throws InvalidInitialArgument If the provided last modification date is not valid.
     */
    public function setLastMod(string|DateTime $lastMod, string $format = 'c'): self
    {
        if (!$this->checkDateTime($lastMod)) {
            throw new InvalidInitialArgument("lastMod");
        }
        $this->lastMod = (new DateTime($lastMod))->format($format);

        return $this;
    }

    /**
     * Sets the priority for the page.
     *
     * This method validates the provided priority value and sets it as the priority for the page.
     * If the priority is not within the range of 0.0 to 1.0, it throws an InvalidInitialArgument exception.
     *
     * @param float $priority The priority of the page for search engines. Must be a float between 0.0 and 1.0.
     * @return self The current instance of the Url class.
     * @throws InvalidInitialArgument If the provided priority is not within the valid range.
     */
    public function setPriority(float $priority): self
    {
        if ($priority < 0 || $priority > 1) {
            throw new InvalidInitialArgument("priority, (0.0 - 1.0)");
        }

        $this->priority = $priority;
        return $this;
    }

    /**
     * Sets the change frequency for the page.
     *
     * This method validates the provided change frequency value and sets it as the change frequency for the page.
     * If the change frequency is not a valid enum value or a string from the ValidFrequenciesEnum, it throws an InvalidInitialArgument exception.
     *
     * @param string|ValidFrequenciesEnum $frequencies The change frequency of the page for search engines.
     *     Must be a string from the ValidFrequenciesEnum or a corresponding enum value.
     * @return self The current instance of the Url class.
     * @throws InvalidInitialArgument If the provided change frequency is not valid.
     */
    public function setFrequency(string|ValidFrequenciesEnum $frequencies): self
    {
        if ($frequencies instanceof ValidFrequenciesEnum) {
            $this->frequency = $frequencies->value;
        }

        if (is_string($frequencies) && empty(ValidFrequenciesEnum::tryFrom($frequencies))) {
            throw new InvalidInitialArgument(
                "frequency (daily, weekly, monthly, yearly, never)"
            );
        }
        $this->frequency = $frequencies;

        return $this;
    }

    /**
     * Returns the URL of the page.
     *
     * @return string The URL of the page.
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returns the last modification date of the page.
     *
     * This method retrieves the last modification date of the page and returns it as a string.
     * The date is stored in the ISO 8601 format.
     *
     * @return string The last modification date of the page in ISO 8601 format.
     */
    public function getLastMod(): string
    {
        return $this->lastMod;
    }

    /**
     * Returns the priority of the page for search engines.
     *
     * This method retrieves the priority value set for the page and returns it as a float.
     * The priority value should be within the range of 0.0 to 1.0.
     *
     * @return float The priority of the page for search engines.
     */
    public function getPriority(): float
    {
        return $this->priority;
    }

    /**
     * Returns the change frequency of the page for search engines.
     *
     * This method retrieves the change frequency value set for the page and returns it as a string.
     * The change frequency should be one of the following: daily, weekly, monthly, yearly, never.
     *
     * @return string The change frequency of the page for search engines.
     */
    public function getFrequency(): string
    {
        return $this->frequency;
    }

    /**
     * Converts the Url object into an associative array for XML sitemaps.
     *
     * This method returns an array containing the URL, last modification date, priority, and change frequency
     * of the page in a format suitable for inclusion in an XML sitemap.
     *
     * @return array An associative array with the following keys: 'loc', 'lastmod', 'priority', and 'changefreq'.
     *     - 'loc': The URL of the page.
     *     - 'lastmod': The last modification date of the page in ISO 8601 format.
     *     - 'priority': The priority of the page for search engines (float between 0.0 and 1.0).
     *     - 'changefreq': The change frequency of the page for search engines (string: daily, weekly, monthly, yearly, never).
     */
    public function toArray(): array
    {
        return [
            'loc' => $this->getUrl(),
            'lastmod' => $this->getLastMod(),
            'priority' => $this->getPriority(),
            'changefreq' => $this->getFrequency()
        ];
    }

    /**
     * Checks if the provided date is a valid DateTime object or a string in a recognized format.
     *
     * @param string|DateTime $date The date to be checked. Can be a string in a recognized format or a DateTime object.
     * @return bool Returns true if the provided date is a valid DateTime object or a string in a recognized format, false otherwise.
     * @throws \Exception If an error occurs while trying to create a DateTime object from the provided date.
     */
    private function checkDateTime(string|DateTime $date): bool
    {
        try {
            new \DateTime($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}