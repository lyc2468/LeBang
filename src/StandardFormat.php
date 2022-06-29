<?php

namespace Skies\LeBang;

class StandardFormat
{
    public function __construct(public string $name, public array $images, public string|array $desc, public array $videos = [])
    {
    }

    public static function urlFormat(array|string $url): array|string
    {
        $formatUrl = [];

        if (is_string($url)) {
            return self::format($url);
        }

        foreach ($url as $i) {
            $formatUrl[] = self::urlFormat($i);
        }

        return $formatUrl;
    }

    /**
     * @param string $url
     * @return string
     */
    protected static function format(string $url): string
    {
        if (! str_starts_with($url, 'http')) {
            $url = 'https:' . $url;
        }

        return $url;
    }
}
