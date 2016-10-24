<?php

class City extends ActiveRecord
{
    /**
     * @return string
     * Возвращает строку с именем таблицы, чтобы ActiveRecord мог построить запросы к соответствующей таблице
     */
    public static function getTableName()
    {
        return 'cities';
    }

}