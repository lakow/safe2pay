<?php

namespace Safe2Pay\Resource;

class Order extends Safe2PayResource
{
    /**
     * {@inheritDoc}
     */
    protected $data = [
        'code' => '',
        'description' => '',
        'cost' => '0.00',
        'amount' => '1.00'
    ];

    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'code' => 'required|max:50',
        'description' => 'required|max:200',
        'cost' => 'required|max:18',
        'amount' => 'required|max:18'
    ];

    /**
     * {@inheritDoc}
     */
    protected $alias = [
        'code' => 'Codigo',
        'description' => 'Descricao',
        'cost' => 'ValorUnitario',
        'amount' => 'Quantidade',
    ];
}
