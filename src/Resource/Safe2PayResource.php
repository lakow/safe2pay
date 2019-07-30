<?php

namespace Safe2Pay\Resource;

use Safe2Pay\Safe2Pay;
use Safe2Pay\PaymentType;
use Safe2Pay\Validation\Validate;
use Safe2Pay\Exception\ResourceException;

abstract class Safe2PayResource
{
    /**
     * Version of API.
     *
     * @const string
     */
    const VERSION = 'v1';

    /**
     * @var \Safe2Pay\Safe2Pay
     */
    protected $safe2pay;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $alias = [];

    /**
     * @var array
     */
    protected $type = [];

    /**
     * Create a new instance.
     *
     * @param \Safe2Pay\Safe2Pay $Safe2Pay
     */
    public function __construct(Safe2Pay $safe2pay)
    {
        $this->safe2pay = $safe2pay;
    }

    /**
     * Create resource
     * 
     * @param array $data
     * 
     * @return Safe2Pay\Resource\Safe2PayResource
     */
    public function create(array $data)
    {
        foreach ($data as $column => $value) {
            $this->setAttr($column, $value);
        }
        $this->validate();
        return $this;
    }

    /**
     * validate data
     */
    public function validate()
    {
        foreach ($this->rules as $column => $rules) {
            $attribute = $this->getAttr($column);
            Validate::valid($rules, $attribute, $column);
        }
    }

    /**
     * Verify if column exists in $this->data
     * 
     * @param string $name
     * 
     * @return bool
     */
    protected function has(string $name)
    {
        return array_key_exists($name, $this->data);
    }

    /**
     * Get attribute by name
     * 
     * @param string $name
     * 
     * @return mixed
     * 
     * @throws ResourceException if the attribute does not exit
     */
    public function getAttr($name)
    {
        if ($this->has($name)) {
            return $this->data[$name];
        }

        throw new ResourceException("Attribute {$name} does not exist.");
    }

    /**
     * Write attribute value
     * 
     * @param string $name attribute name
     * @param string $value attribute value
     * 
     * @return Safe2Pay\Resource\Safe2PayResource
     */
    public function setAttr($name, $value)
    {
        if ($this->has($name)) {
            $this->data[$name] = is_array($value) ? array_map('trim', $value) : trim($value);
            $type = array_key_exists($name, $this->type) ? $this->type[$name] : 'string';
            settype($this->data[$name], $type);
        }

        return $this;
    }

    /**
     * Convert data to array
     * 
     * @return array $arr
     */
    public function toArray()
    {
        $keys = $this->getAlias();
        foreach ($keys as $key => $alias) {
            $arr[$alias] = $this->getAttr($key);
        }
        return $arr;
    }

    /**
     * Convert data to array recursively
     * 
     * @param array $collection
     * 
     * @return array $collection
     */
    public function toArrayRecursive(array $collection)
    {
        return array_map(function ($resource){
            return $resource->toArray();
        }, $collection);
    }

    /**
     * @return array
     */
    protected function getAlias()
    {
        if (!count($this->alias)) {
            $keys = array_keys($this->data);
            return array_combine($keys, $keys);
        }
        return $this->alias;
    }
}
