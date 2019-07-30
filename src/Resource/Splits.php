<?php

namespace Safe2Pay\Resource;

class Splits extends Safe2PayResource
{
    /**
     * {@inheritDoc}
     */
    protected $data = [
        'document' => '',
        'rate' => 'Valor',
        'recipient' => 'Empresa',
        'pay_rate' => false,
        'value' => '0.00'
    ];

    /**
     * {@inheritDoc}
     */
    protected $alias = [
        'document' => 'Documento',
        'rate' => 'Taxa',
        'recipient' => 'Recebedor',
        'pay_rate' => 'PagaTaxa',
        'value' => 'Valor',
    ];

    /**
     * {@inheritDoc}
     */
    protected $type = [
        'pay_rate' => 'bool'
    ];

    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'document' => 'required|max:14',
        'rate' => 'required|max:200',
        'recipient' => 'required|max:8',
        'value' => 'required'
    ];
}
