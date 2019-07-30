<?php

namespace Safe2Pay\Resource;

class BankSlip extends Safe2PayResource
{
    /**
     * {@inheritDoc}
     */
    protected $data = [
        'duo_date' => '',
        'cancel_after_expiration' => false,
        'partial_payment' => false,
        'deadline' => 0,
        'penalty' => '0.00',
        'rate' => '0.00',
        'instruction' => '',
        'messages' => [],
    ];

    /**
     * {@inheritDoc}
     */
    protected $type = [
        'cancel_after_expiration' => 'bool',
        'partial_payment' => 'bool',
        'deadline' => 'int',
        'messages' => 'array',
    ];

    /**
     * {@inheritDoc}
     */
    protected $alias = [
        'duo_date' => 'DataVencimento',
        'cancel_after_expiration' => 'CancelarAposVencimento',
        'partial_payment' => 'PermitePagamentoParcial',
        'deadline' => 'PrazoBaixa',
        'penalty' => 'TaxaMulta',
        'rate' => 'TaxaJuros',
        'instruction' => 'Instrucoes',
        'messages' => 'Mensagens',
    ];

    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'duo_date' => 'required|min:10|max:10',
        'instruction' => 'required|max:200'
    ];
}
