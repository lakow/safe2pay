<?php

namespace Safe2Pay\Resource;

class Notification extends Safe2PayResource
{
    /**
     * {@inheritDoc}
     */
    protected $data = [
        'url' => ''
    ];

    /**
     * {@inheritDoc}
     */
    protected $alias = [
        'url' => 'URLNotificacao',
    ];

    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'url' => 'max:200'
    ];
}
