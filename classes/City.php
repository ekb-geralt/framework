<?php

/**
 * Class City
 * @property int $id
 * @property string $name
 * @property int $population
 * @property int $isCapital
 * @property string $creationDate
 * @property float $unemploymentRate
 * @property int $countryId
 * @property DateTime $creationDateObject
 * пишем какие свойства есть у объекта, для IDE
 */
class City extends ActiveRecord
{
    public function __get($name)// магический геттер имеет 1 аргумент - имя свойства, к которому идет обращение
    {
        if ($name == 'creationDateObject') {
            return $this->getCreationDateObject();
        }
        
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if ($name == 'creationDateObject') {
            $this->setCreationDateObject($value);
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @return DateTime|null
     */
    public function getCreationDateObject()
    {
        return isset($this->creationDate) ? DateTime::createFromFormat('Y-m-d', $this->creationDate) : null;
    }

    /**
     * @param DateTime|null $value
     */
    public function setCreationDateObject($value)
    {
        $this->creationDate = $value ? $value->format('Y-m-d') : null;
    }
    
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