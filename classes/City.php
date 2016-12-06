<?php

/**
 * Class City
 * @property $id int
 * @property $name string
 * @property $population int
 * @property $isCapital int
 * @property $creationDate string
 * @property $unemploymentRate float
 * @property $countryId int
 * пишем какие свойства есть у объекта, для IDE
 */
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

    /**
     * Возвращает страну, которой принадлежит город
     * @return Country
     */
    public function getCountry()
    {
        return Country::getById($this->countryId);
    }

}