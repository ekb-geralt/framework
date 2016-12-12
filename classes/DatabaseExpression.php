<?php

class DatabaseExpression
{
    /**
     * @var string
     */
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getEscapedValue()
    {
        return $this->value;
    }
}