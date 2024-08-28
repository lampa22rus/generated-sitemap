<?php

namespace Lampa\Sitemaps;

use Lampa\Entity\AbstractSitemap;

class CSVSitemap extends AbstractSitemap
{
    private array $columns = [
        'loc',
        'lastmod',
        'changefreq',
        'priority'
    ];

    /**
     * Generates a CSV sitemap file based on the provided URLs.
     *
     * @return bool Returns true if the file is successfully closed, false otherwise.
     */
    public function generate(): bool
    {
        $file = fopen($this->getPath(), 'w');

        fputcsv($file, $this->columns);

        foreach ($this->getUrls() as $item) {
            fputcsv($file, $item->toArray());
        }

        return fclose($file);
    }
}