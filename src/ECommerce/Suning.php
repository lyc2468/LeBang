<?php

namespace Skies\LeBang\ECommerce;

use Skies\LeBang\ApiClient;
use Skies\LeBang\ECommerceInterface;
use Skies\LeBang\StandardFormat;

class Suning implements ECommerceInterface
{
    public static function detail(ApiClient $client, string $url, array $params = [], bool $isFormat = false): array|StandardFormat|null
    {
        [$shopId, $itemId] = static::getShopIdAndItemId($url);
        $params = array_merge($params, [
            'itemid' => $itemId,
            'shopid' => $shopId,
        ]);

        $product = json_decode($client->get("/suning/detail", $params), true);

        if (! is_null($product) && $isFormat) {
            return static::toStandardFormat($product);
        }

        return $product;
    }

    public static function detect(string $url): bool
    {
        $urlInfo = parse_url($url);
        $matches = [];
        preg_match('/\.suning\.com/', $urlInfo['host'], $matches);

        return count($matches) !== 0;
    }

    protected static function getShopIdAndItemId(string $url): array
    {
        $urlInfo = parse_url($url);
        $pathInfo = explode('/', $urlInfo['path']);

        return [$pathInfo[1], current(explode('.', last($pathInfo)))];
    }

    protected static function toStandardFormat(array $product): StandardFormat
    {
        $doc = new \DOMDocument();
        $doc->loadHTML($product['data']['desc']);
        $xpath = new \DOMXPath($doc);
        $imgNode = $xpath->query("//img");
        $descImages = [];
        foreach ($imgNode as $img) {
            $descImages[] = $img->attributes->getNamedItem('src2')->nodeValue;
        }

        return new StandardFormat(
            $product['data']['title'],
            $product['data']['images'],
            $descImages
        );
    }
}
