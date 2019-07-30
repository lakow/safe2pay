<?php

namespace Safe2Pay;

class PaymentType
{
    /**
     * Payment type bank slip
     *
     * @const string
     */
    const BANK_SLIP = 1;

    /**
     * Payment type credit card
     *
     * @const string
     */
    const CREDIT_CARD = 2;

    /**
     * Payment type bitcoin
     *
     * @const string
     */
    const BITCOIN = 3;

    /**
     * Payment type debit card
     *
     * @const string
     */
    const DEBIT_CARD = 4;
}