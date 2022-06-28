<?php

namespace Skies\LeBang;

class StandardFormat
{
    public function __construct(public string $name, public array $images, public string|array $desc)
    {
    }

    public static function imageUrlFormat(array $images): array
    {
        $imagesFormat = [];
        foreach ($images as $imgUrl) {
            if (! str_starts_with($imgUrl, 'http')) {
                $imgUrl = 'https:' . $imgUrl;
            }

            $imagesFormat[] = $imgUrl;
        }

        return $imagesFormat;
    }
}
