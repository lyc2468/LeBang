<?php

namespace Skies\LeBang\ECommerce;

use Skies\LeBang\ApiClient;
use Skies\LeBang\ECommerceInterface;
use Skies\LeBang\StandardFormat;

class Alibaba implements ECommerceInterface
{
    public static function detail(ApiClient $client, string $url, array $params = [], bool $isFormat = false): array|StandardFormat|null
    {
        $params = array_merge($params, [
            'itemid' => static::getItemIdFromUrl($url),
        ]);

        $product = json_decode($client->get("/alibaba/pro/detail", $params), true);

        if (! is_null($product) && $isFormat) {
            return static::toStandardFormat($product);
        }

        return $product;
    }

    public static function detect(string $url): bool
    {
        $urlInfo = parse_url($url);
        $matches = [];
        preg_match('/\.1688\.com/', $urlInfo['host'], $matches);

        return count($matches) !== 0;
    }

    protected static function getItemIdFromUrl(string $url): string|null
    {
        $urlInfo = parse_url($url);

        return current(explode('.', last(explode('/', $urlInfo['path']))));
    }

    protected static function toStandardFormat(array $product): StandardFormat
    {
        $doc = new \DOMDocument();
        $doc->loadHTML($product['data']['desc']);
        $xpath = new \DOMXPath($doc);
        $imgNode = $xpath->query("//img");
        $descImages = [];
        foreach ($imgNode as $img) {
            $descImages[] = 'https:' . $img->attributes->getNamedItem('src')->nodeValue;
        }

        return new StandardFormat(
            $product['data']['title'],
            $product['data']['images'],
            $descImages,
        );
    }
}
