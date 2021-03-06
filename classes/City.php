<?php
use validators\EmptyValidator;

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
 * @property-read Country $country
 * @property float $unemploymentRatePercent
 * пишем какие свойства есть у объекта, для IDE
 */
class City extends ActiveRecord
{
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

    public function getUnemploymentRatePercent()
    {
        return isset($this->unemploymentRate) ? $this->unemploymentRate * 100 : null;
    }

    public function setUnemploymentRatePercent($value)
    {
        $this->unemploymentRate = $value ? $value / 100 : null;
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

    public function getFieldLabels()
    {
        return [
            'name' => 'Название',
        ];
    }

    public function getValidationRules()
    {
        return [
            ['field' => 'name', 'validator' => EmptyValidator::class, 'params' => ['not' => true]], //здесь надо указывать полный путь или объявлять использование класса
        ];
    }
}