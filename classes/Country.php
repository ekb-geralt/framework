<?php

class Country extends ActiveRecord
{
    public static function getTableName()
    {
        return 'countries';
    }
}