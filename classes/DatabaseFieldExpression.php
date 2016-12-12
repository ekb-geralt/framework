<?php
use components\Database;

class DatabaseFieldExpression extends DatabaseExpression
{
    public function getEscapedValue()
    {
        return Database::escapeName($this->value);
    }
}