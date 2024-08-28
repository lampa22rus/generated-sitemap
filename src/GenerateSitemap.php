<?php

namespace Lampa;

use Lampa\Entity\AbstractSitemap;
use Lampa\Enums\TypesEnum;
use Lampa\Interfaces\SitemapInterface;

class GenerateSitemap implements SitemapInterface
{
    private static array $types = [
        'json' => TypesEnum::JSON,
        'xml' => TypesEnum::XML,
        'csv' => TypesEnum::CSV,
    ];

    public static function make(array $urls, string $path, string|TypesEnum $type = 'json'): AbstractSitemap
    {
        if ($type instanceof TypesEnum) {
            return new $type->value($urls, $path);
        };

        if (is_string($type) && key_exists($type, self::$types)) {
            return new self::$types[$type]->value($urls, $path);
        }

        throw new \InvalidArgumentException(
            "Please, type valid file type"
        );
    }
}