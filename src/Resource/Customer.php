<?php

namespace Safe2Pay\Resource;

class Customer extends Safe2PayResource
{
    /**
     * {@inheritDoc}
     */
    protected $data = [
        'name' => '',
        'document' => '',
        'email' => ''
    ];

    /**
     * {@inheritDoc}
     */
    protected $address;

    /**
     * {@inheritDoc}
     */
    protected $alias = [
        'name' => 'Nome',
        'document' => 'CPFCNPJ',
        'email' => 'Email',
    ];

    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'name' => 'required|max:200',
        'document' => 'required|min:11|max:14',
        'email' => 'email'
    ];

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(array $address)
    {
        $this->address = (new Address($this->safe2pay))->create($address);
        return $this;
    }
}
