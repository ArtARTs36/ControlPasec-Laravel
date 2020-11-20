<?php

namespace App\Bundles\Contragent\Support;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class DaDataClient
{
    protected $requester;

    protected $accessKey;

    public function __construct(ClientInterface $requester, string $accessKey)
    {
        $this->requester = $requester;
        $this->accessKey = $accessKey;
    }

    public function findByInn(string $inn): array
    {
        return $this->responseToArray(
            $this->requester->request('GET', 'rs/findById/party?query='. $inn, $this->headers())
        );
    }

    protected function responseToArray(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true) ?? [];
    }

    protected function headers(): array
    {
        return [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Token '. $this->accessKey,
            ],
        ];
    }
}
