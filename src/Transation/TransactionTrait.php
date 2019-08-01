<?php

namespace Safe2Pay\Transation;

use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait TransactionTrait
{
    protected $response = [];

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

        $this->response = json_decode($response->getBody(), true);
        return $this;
    }

    public function getMethod()
    {
        return self::METHOD;
    }

    public function getUrl()
    {
        return sprintf('/%s/%s', $this->safe2pay->getApiVersion(), self::PATH);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function hasError()
    {
        if (array_key_exists('HasError', $this->response)) {
            return (bool) $this->response['HasError'];
        }
    }

    public function errorMessage()
    {
        if ($this->hasError() && array_key_exists('Error', $this->response)) {
            return $this->response['Error'];
        }
    }
}
