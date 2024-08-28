<?php

namespace Lampa\Interfaces;

use Lampa\Entity\AbstractSitemap;

/**
 * Interface SitemapInterface
 *
 * This interface defines the contract for creating a sitemap.
 */
interface SitemapInterface
{
    /**
     * Creates a new sitemap instance.
     *
     * @param array $urls An array of URLs to be included in the sitemap.
     * @param string $path The file path where the sitemap will be saved.
     * @param string $type The type of sitemap (e.g., XML, HTML).
     *
     * @return AbstractSitemap The newly created sitemap instance.
     */
    public static function make(array $urls, string $path, string $type): AbstractSitemap;
}