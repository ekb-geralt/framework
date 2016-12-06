<?php

class User extends ActiveRecord
{
    public static function getTableName()
    {
        return 'authentic';
    }
}