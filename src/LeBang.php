<?php

namespace Skies\LeBang;

class LeBang
{
    protected ApiClient $apiClient;

    public function __construct(string $apiKey, string $baseUrl = "")
    {
        $this->apiClient = new ApiClient($apiKey, $baseUrl);
    }

    public function detail(string $url, array $params = [], bool $isFormat = false): array|StandardFormat|null
    {
        return $this->detect($url)::detail($this->apiClient, $url, $params, $isFormat);
    }

    public function detect(string $url): string
    {
        foreach ($this->getAllECommerce() as $ecommerce) {
            if ($ecommerce::detect($url)) {
                return $ecommerce;
            }
        }

        throw new \RuntimeException('Can\'t found ecommerce for this url');
    }

    public function getAllECommerce(): array
    {
        $ecommerces = scandir(__DIR__ . "/ECommerce");
        $allEcommerceClass = [];
        foreach ($ecommerces as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $allEcommerceClass[] = "Skies\LeBang\ECommerce\\" . pathinfo($item)['filename'];
        }

        return $allEcommerceClass;
    }
}
