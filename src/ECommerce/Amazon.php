<?php

namespace Skies\LeBang\ECommerce;

use Skies\LeBang\ApiClient;
use Skies\LeBang\ECommerceInterface;
use Skies\LeBang\StandardFormat;

class Amazon implements ECommerceInterface
{
    public static function detail(ApiClient $client, string $url, array $params = [], bool $isFormat = false): array|StandardFormat|null
    {
        $params = array_merge($params, [
            'url' => $url,
        ]);

        $product = json_decode($client->get("/amazon/detail", $params), true);
        if (! is_null($product) && $isFormat) {
            return static::toStandardFormat($product);
        }

        return $product;
    }

    public static function detect(string $url): bool
    {
        $urlInfo = parse_url($url);
        $matches = [];
        preg_match('/\.amazon\.com/', $urlInfo['host'], $matches);

        return count($matches) !== 0;
    }

    protected static function toStandardFormat(array $product): StandardFormat
    {
        return new StandardFormat(
            $product['data']['title'],
            array_column($product['data']['imgs'], 'hiRes'),
            implode("\n", $product['data']['features'])
        );
    }
}
