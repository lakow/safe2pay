<?php

namespace Safe2Pay\Transation;

use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait TransactionTrait
{
    public function execute()
    {
        $client = new Client(['base_uri' => $this->safe2pay->getEndpoint()]);

        $response = $client->request($this->getMethod(), $this->getUrl(), [
            'json' => $this->payload(),
            'headers' => [
                'X-API-KEY' => $this->safe2pay->getToken(),
                'Content-Type' => 'application/json',
            ]
        ]);

        return $response->getBody()->getContents();
    }

    public function getMethod()
    {
        return self::METHOD;
    }

    public function getUrl()
    {
        return sprintf('/%s/%s', $this->safe2pay->getApiVersion(), self::PATH);
    }
}
