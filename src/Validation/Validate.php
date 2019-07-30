<?php

namespace Safe2Pay\Validation;

use Safe2Pay\Validation\ValidateException;

class Validate
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $rules;

    /**
     * @var string
     */
    private $column;

    /**
     * @param string $rules
     * @param string $value
     * @param string $column
     */
    public function __construct($rules, $value, $column) 
    {
        $this->rules = array_map(function ($val) { 
            return explode(':', $val); 
        },  explode('|', $rules));

        
        $this->value = $value;
        $this->column = $column;

        $this->execute();
    }

    /**
     * @param string $rules
     * @param string $value
     * @param string $column
     * 
     * @return Safe2Pay\Validation\Validate
     */
    public static function valid($rules, $value, $column)
    {
        return new Validate($rules, $value, $column);
    }

    /**
     * Performs validation
     */
    protected function execute()
    {
        foreach ($this->rules as $rule) {
            $param = $rule[1] ?? null;
            $method = $rule[0];
            $this->$method($param);
        }
    }

    /**
     * Tests if value exists
     * 
     * @throws Safe2Pay\Validation\ValidateException if value is null
     */
    protected function required()
    {
        if (is_null($this->value) || $this->value == '') {
            throw new ValidateException("{$this->column} is required.");
        }
    }

    /**
     * Tests the minimum string length
     * 
     * @throws Safe2Pay\Validation\ValidateException
     */
    protected function min($amount)
    {
        if (strlen($this->value) < $amount) {
            throw new ValidateException("{$this->column} need at least {$amount} characters.");
        }
    }

    /**
     * Tests the maximum string length
     * 
     * @throws Safe2Pay\Validation\ValidateException
     */
    protected function max($amount)
    {
        if (strlen($this->value) > $amount) {
            throw new ValidateException("{$this->column} only support {$amount} characters.");
        }
    }

    /**
     * Tests if email is valid
     * 
     * @throws Safe2Pay\Validation\ValidateException
     */
    protected function email()
    {
        if (!is_null($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidateException("{$this->value} is not valid email."); 
        }
    }
}
