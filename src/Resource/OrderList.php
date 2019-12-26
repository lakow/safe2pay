<?php

namespace Safe2Pay\Resource;

use Safe2Pay\Safe2Pay;
use Safe2Pay\Resource\Order;
use Safe2Pay\Resource\Splits;
use Safe2Pay\Resource\Customer;
use Safe2Pay\Resource\BankSlip;
use Safe2Pay\Transation\TransactionTrait;

class OrderList extends Safe2PayResource
{
    use TransactionTrait;

    /**
     * Endpoint path
     * 
     * @var string
     */
    const PATH = 'payment';

    /**
     * Method request
     * 
     * @var string
     */
    const METHOD = 'post';

    /**
     * @var array
     */
    protected $orders = [];

    /**
     * @var array
     */
    protected $splits = [];

    /**
     * @var string
     */
    protected $notification;

    /**
     * @var Safe2Pay\Resource\Customer
     */
    protected $customer;

    /**
     * @var Safe2Pay\Resource\BankSlip
     */
    protected $payment;

    /**
     * @var int
     */
    protected $method;

    /**
     * {@inheritDoc}
     */
    protected $data = [
        'application' => 'SAFE2PAY_SDK_PHP',
        'reference' => '',
        'seller' => ''
    ];

    /**
     * {@inheritDoc}
     */
    protected $alias = [
        'application' => 'Aplicacao',
        'reference' => 'Referencia',
        'seller' => 'Vendedor'
    ];

    /**
     * Add a new item to the order
     * 
     * @param string $code
     * @param string $description
     * @param string $cost
     * @param string $amount
     * 
     * @return Safe2Pay\Resource\OrderList
     */
    public function addItem($code, $description, $cost, $amount = 1)
    {
        $amount = number_format($amount, 2, '.', '');
        $cost = number_format($cost, 2, '.', '');
        $data = compact('code', 'description', 'cost', 'amount');
        $order = (new Order($this->safe2pay))->create($data);
        array_push($this->orders, $order);
        return $this;
    }

    /**
     * Add a new split in the order
     * 
     * @param string $document
     * @param string $rate
     * @param string $recipient
     * @param string $pay_rate
     * @param string $value
     * 
     * @return Safe2Pay\Resource\OrderList
     */
    public function addSplit($document, $rate, $recipient, $pay_rate, $value)
    {
        $data = compact('document', 'rate', 'recipient', 'pay_rate', 'value');
        $split = (new Splits($this->safe2pay))->create($data);
        array_push($this->splits, $split);
        return $this;
    }

    /**
     * @param \Safe2Pay\Resource\Customer $customer
     * 
     * @return Safe2Pay\Resource\OrderList
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @param int $method
     * @param array $data
     * 
     * @return Safe2Pay\Resource\OrderList
     */
    public function payment($method, $data)
    {
        $this->method = $method;
        switch($method) {
            case 1: $this->payment = (new BankSlip($this->safe2pay))->create($data);
                break;
        }
        return $this;
    }

    /**
     * @param string $url
     * 
     * @return Safe2Pay\Resource\OrderList
     */
    public function notification($url)
    {
        $this->notification = $url;
        return $this;
    }


    /**
     * @return array $payload
     */
    public function payload() 
    {
        $payload = [
            'FormaPagamento' => $this->method,
            'IsSandbox' => $this->safe2pay->getSandbox(),
            'Produtos' => $this->toArrayRecursive($this->orders),
            'Boleto' => $this->payment->toArray(),
            'DadosCobranca' => array_merge($this->customer->toArray(), $this->customer->getAddress()->toArray()),
        ];

        $payload = array_merge($payload, $this->toArray());

        if (count($this->splits)) {
            $payload['Splits'] = $this->toArrayRecursive($this->splits);
        }

        if ($this->notification !== '') {
            $payload['URLNotificacao'] = $this->notification;
        }

        return $payload;
    }
}
