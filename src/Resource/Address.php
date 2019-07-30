<?php

namespace Safe2Pay\Resource;

class Address extends Safe2PayResource
{
    /**
     * {@inheritDoc}
     */
    protected $data = [
        'zip_code' => '',
        'street' => '',
        'number' => '',
        'complement' => '',
        'neighborhood' => '',
        'uf' => '',
        'city' => '',
        'country' => 'Brasil'
    ];

    /**
     * {@inheritDoc}
     */
    protected $alias = [
        'zip_code' => 'CEP',
        'street' => 'Logradouro',
        'number' => 'Numero',
        'complement' => 'Complemento',
        'neighborhood' => 'Bairro',
        'uf' => 'UF',
        'city' => 'Cidade',
        'country' => 'Pais'
    ];

    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'zip_code' => 'max:20',
        'street' => 'max:150',
        'number' => 'max:10',
        'complement' => 'max:150',
        'neighborhood' => 'max:100',
        'uf' => 'max:2',
        'city' => 'max:200',
        'country' => 'max:100'
    ];
}
