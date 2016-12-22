<?php

/**
 * Class Country
 * @property int $id
 * @property string $name
 * @property int $capitalId
 * @property string $population
 * @property string $area
 * @property-read City $capital
 * @property-read City[] $cities
 */
class Country extends ActiveRecord
{
    public static function getTableName()
    {
        return 'countries';
    }

    /**
     * Возвращает столицу страны
     * @return City|null
     */
    public function getCapital()
    {
        return City::getById($this->capitalId);
    }

    public function getCities()
    {
        return City::getObjects(['=', 'countryId', $this->id]);
    }

    public function getFieldLabels()
    {
        return [
            'name' => 'Название',
            'capitalId' => 'Столица',
            'population' => 'Численность населения',
            'area' => 'Площадь',
        ];
    }
}