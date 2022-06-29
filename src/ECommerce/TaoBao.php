<?php

namespace Skies\LeBang\ECommerce;

use Skies\LeBang\ApiClient;
use Skies\LeBang\ECommerceInterface;
use Skies\LeBang\StandardFormat;

class TaoBao implements ECommerceInterface
{
    public static function detail(ApiClient $client, string $url, array $params = [], bool $isFormat = false): array|StandardFormat|null
    {
        $params = array_merge($params, [
            'itemid' => static::getItemIdFromUrl($url),
        ]);

        $product = json_decode($client->get("/taobao/detail", $params), true);

        if (! is_null($product) && $isFormat) {
            return static::toStandardFormat($product);
        }

        return $product;
    }

    public static function detect(string $url): bool
    {
        $urlInfo = parse_url($url);
        $matches = [];
        preg_match('/\.taobao\.com/', $urlInfo['host'], $matches);

        return count($matches) !== 0;
    }

    protected static function getItemIdFromUrl(string $url): string|null
    {
        $urlInfo = parse_url($url);
        $query = explode('&', $urlInfo['query']);

        foreach ($query as $item) {
            if (strpos($item, 'id=') !== false) {
                return last(explode('=', $item));
            }
        }

        return null;
    }

    protected static function toStandardFormat(array $product): StandardFormat
    {
        $videos = [];

        if (isset($product['data']['item']['videos'])
            && count($product['data']['item']['videos']) > 0
        ) {
            foreach ($product['data']['item']['videos'] as $videoInfo) {
                $videos[] = $videoInfo['url'];
            }
        }

        return new StandardFormat(
            $product['data']['item']['title'],
            StandardFormat::urlFormat($product['data']['item']['images']),
            StandardFormat::urlFormat($product['data']['item']['descImgs']),
            StandardFormat::urlFormat($videos)
        );
    }
}
