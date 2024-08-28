<?php

namespace Lampa\Sitemaps;

use Lampa\Entity\AbstractSitemap;
use SimpleXMLElement;

class XMLSitemap extends AbstractSitemap
{
    private array $attributes = [
        "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
        "xmlns" => "http://www.sitemaps.org/schemas/sitemap/0.9",
        "xsi:schemaLocation" => "http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd",
    ];

    /**
     * Generates an XML sitemap based on the provided URLs and saves it to a file.
     *
     * @return bool Returns true if the sitemap is successfully saved, false otherwise.
     */
    public function generate(): bool
    {
        $xml = new SimpleXMLElement('<urlset/>');

        foreach ($this->attributes as $key => $value) {
            $xml->addAttribute($key, $value);
        }

        foreach ($this->getUrls() as $url) {
            $urlElement = $xml->addChild('url');

            $urlElement
                ->addChild('loc', htmlspecialchars($url->getUrl()))
                ->addChild('lastmod', $url->getLastMod())
                ->addChild('changefreq', $url->getFrequency())
                ->addChild('priority', $url->getPriority());
        }

        return $this->saveFile($xml->asXML());
    }
}