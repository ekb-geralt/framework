<?php

abstract class ActiveRecord
{
    /**
     * @return string
     * Возвращает строку с именем таблицы, чтобы ActiveRecord мог построить запросы к соответствующей таблице
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
    public static function getObjects($condition = null, $limit = null) //static от self отличается тем, что static ссылается на тот класс, в котором вызван метод, а self - где объявлен метод
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
                $object->$name = $value; //object - это объект, и аожно после стрелки просто написать переменную в которой значение, или напрямую имя свойства, которое будет у объекта
            }
            $objects[] = $row;
        }

        return $objects;
    }
}