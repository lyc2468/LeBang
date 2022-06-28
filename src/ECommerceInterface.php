<?php

namespace Skies\LeBang;

interface ECommerceInterface
{
    public static function detail(ApiClient $client, string $url, array $params = [], bool $isFormat = false): array|StandardFormat|null;
    public static function detect(string $url): bool;
}
