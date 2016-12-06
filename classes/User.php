<?php

/**
 * Class User
 * @property $id int
 * @property $username string
 * @property $password string
 */
class User extends ActiveRecord
{
    public static function getTableName()
    {
        return 'authentic';
    }
}