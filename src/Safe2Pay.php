<?php

namespace Safe2Pay;

use Safe2Pay\Resource\Customer;
use Safe2Pay\Resource\OrderList;

class Safe2Pay
{
    /**
     * endpoint of production.
     *
     * @const string
     */
    const ENDPOINT_PRODUCTION = 'https://api.safe2pay.com.br';

    /**
     * Api version.
     *
     * @const string
     */
    const API_VERSION = 'v1';

    /**
     * Endpoint of request.
     *
     * @var \Safe2Pay\Safe2Pay::ENDPOINT_PRODUCTION
     */
    private $endpoint;

    /**
     * Authorization token.
     *
     * @var string
     */
    private $token;


    /**
     * Homologation
     *
     * @var bool
     */
    private $sandbox;

    /**
     * @param string $endpoint
     */
    public function __construct($token, $endpoint = self::ENDPOINT_PRODUCTION)
    {
        $this->token = $token;
        $this->sandbox = false;
        $this->endpoint = $endpoint;
    }

    /**
     * Create a new Customer instance.
     *
     * @return \Safe2Pay\Resource\Customer
     */
    public function customer()
    {
        return new Customer($this);
    }

    public function isSandbox(bool $sandbox = true)
    {
        $this->sandbox = $sandbox;
    }

    /**
     * Create a new Orders instance.
     *
     * @return \Safe2Pay\Resource\Orders
     */
    public function orders()
    {
        return new OrderList($this);
    }

    /**
     * Create a new Notification Prefences instance.
     *
     * @return NotificationPreferences
     */
    public function notifications()
    {
        return new NotificationPreferences($this);
    }

    /**
     * Get the endpoint.
     *
     * @return \Safe2Pay\Safe2Pay::ENDPOINT_PRODUCTION
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Get the token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the endpoint.
     *
     * @return \Safe2Pay\Safe2Pay::API_VERSION
     */
    public function getApiVersion()
    {
        return self::API_VERSION;
    }

    public function getSandbox()
    {
        return $this->sandbox;
    }
}
