<?php

namespace Lampa\Sitemaps;

use Lampa\Entity\AbstractSitemap;
use Lampa\Url;

class JsonSitemap extends AbstractSitemap
{
    /**
     * Generates a JSON sitemap based on the URLs added to the sitemap.
     *
     * @return bool Returns true if the sitemap was successfully generated and saved, false otherwise.
     */
    public function generate(): bool
    {
        $items = array_map(fn(Url $url) => $url->toArray(), $this->getUrls());

        return $this->saveFile(json_encode($items));
    }
}