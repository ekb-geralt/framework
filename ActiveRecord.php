<?php

abstract class ActiveRecord
{
    /**
     * @return string
     * ���������� ������ � ������ �������, ����� ActiveRecord ��� ��������� ������� � ��������������� �������
     */
    public static function getTableName()
    {
        return '';
    }

    /**
     * @param $condition
     * @param $limit
     * @return static[]
     */
    public static function getObjects($condition = null, $limit = null) //static �� self ���������� ���, ��� static ��������� �� ��� �����, � ������� ������ �����, � self - ��� �������� �����
    {
        $objects = [];
        $query = new Query(Application::getInstance()->db);
        $query->select()->from(static::getTableName());
        if ($condition) {
            $query->where($condition);
        }
        if ($limit) {
            $query->limit($limit);
        }
        foreach ($query->getRows() as $row) {
            $object = new static;
            foreach ($row as $name => $value) {
                $object->$name = $value; //object - ��� ������, � ����� ����� ������� ������ �������� ���������� � ������� ��������, ��� �������� ��� ��������, ������� ����� � �������
            }
            $objects[] = $row;
        }

        return $objects;
    }
}