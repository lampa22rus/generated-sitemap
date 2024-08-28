<?php

namespace Lampa\Enums;

use Lampa\Sitemaps\CSVSitemap;
use Lampa\Sitemaps\JsonSitemap;
use Lampa\Sitemaps\XMLSitemap;

/**
 * This enum represents different types of sitemaps and provides a method to convert the enum values to their corresponding string representations.
 */
enum TypesEnum: string
{
    case JSON = JsonSitemap::class;

    case XML = XMLSitemap::class;

    case CSV = CSVSitemap::class;

    /**
     * @return string|null
     */
    public function toString(): ?string
    {
        return match ($this) {
            self::JSON => 'json',
            self::XML => 'xml',
            self::CSV => 'csv',
        };
    }
}
