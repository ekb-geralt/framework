<?php

class City extends ActiveRecord
{
    /**
     * @return string
     * ���������� ������ � ������ �������, ����� ActiveRecord ��� ��������� ������� � ��������������� �������
     */
    public static function getTableName()
    {
        return 'cities';
    }

}