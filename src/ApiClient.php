<?php

namespace Skies\LeBang;

use GuzzleHttp\Client;

class ApiClient
{
    protected string $apiKey = '';
    protected string $baseUrl = 'https://api03.6bqb.com';
    protected Client $httpClient;

    public function __construct(string $apiKey, ?string $baseUrl = null)
    {
        $this->apiKey = $apiKey;
        if (! empty($baseUrl)) {
            $this->baseUrl = $baseUrl;
        }

        $this->httpClient = new Client(['base_uri' => $this->baseUrl, 'timeout' => 60]);
    }

    public function get(string $url, array $query = []): string
    {
        $query = array_merge($query, [
            'apikey' => $this->apiKey,
        ]);

        $response = $this->httpClient->get($url, [
            'query' => $query,
        ]);

        return $response->getBody()->getContents();
    }
}
