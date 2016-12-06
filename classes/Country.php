<?php

/**
 * Class Country
 * @property $id int
 * @property $name string
 * @property $capitalId int
 * @property $population string
 * @property $area string
 */
class Country extends ActiveRecord
{
    public static function getTableName()
    {
        return 'countries';
    }

    /**
     * ���������� ������� ������
     * @return City|null
     */
    public function getCapital()
    {
        return City::getById($this->capitalId);
    }
}