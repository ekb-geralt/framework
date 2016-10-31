<?php
use components\Database;

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 18.05.2016
 * Time: 23:10
 */
class DatabaseFieldExpression extends DatabaseExpression
{
    public function getEscapedValue()
    {
        return Database::escapeName($this->value);
    }
}