<?php

namespace Skies\LeBang\ECommerce;

use Skies\LeBang\ApiClient;
use Skies\LeBang\ECommerceInterface;
use Skies\LeBang\StandardFormat;

class JD implements ECommerceInterface
{
    public static function detail(ApiClient $client, string $url, array $params = [], bool $isFormat = false): array|StandardFormat|null
    {
        $params = array_merge($params, [
            'itemid' => static::getItemIdFromUrl($url),
        ]);

        $product = json_decode($client->get("/jd/detail", $params), true);
        if (! is_null($product) && $isFormat) {
            return static::toStandardFormat($product);
        }

        return $product;
    }

    public static function detect(string $url): bool
    {
        $urlInfo = parse_url($url);
        $matches = [];
        preg_match('/\.jd\.com/', $urlInfo['host'], $matches);

        return count($matches) !== 0;
    }

    protected static function getItemIdFromUrl(string $url): string|null
    {
        $urlInfo = parse_url($url);

        return current(explode('.', last(explode('/', $urlInfo['path']))));
    }

    protected static function toStandardFormat(array $product): StandardFormat
    {
        return new StandardFormat(
            $product['data']['item']['name'],
            StandardFormat::urlFormat($product['data']['item']['images']),
            StandardFormat::urlFormat($product['data']['item']['descImgs'])
        );
    }
}
