<?php

abstract class ActiveRecord
{
    /**
     * @var int
     */
    public $id;
    
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
            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * @param $id int
     * @return static|null
     */
    public static function getById($id)
    {
        $objects = static::getObjects(['=', 'id', $id], 1);
        if ($objects) {
            return array_shift($objects);
        }
        
        return null;
    }

    /**
     * @throws Exception
     */
    public function save()
    {
        $database = Application::getInstance()->db;
        $fields = (array)$this; //получаем список полей в БД
        $keys = array_keys($fields); //получаем ключи из fields[] в виде нового массива, где они будут значениями
        $values = array_values($fields);
        $data = join(', ', array_map(function($key, $value) use ($database) { //array_map в данном случае сделает массив вида ключ = значение, use пробрасывает $database из родительской функции в безымянную
            if (is_null($value)) {
                $sqlValue = 'NULL';
            } else {
                $sqlValue = "'" . $database->connection->real_escape_string($value) . "'";
            }
            
            return $database->escapeName($key) . ' = ' . $sqlValue;
        }, $keys, $values));
        $id = $database->connection->real_escape_string($this->id);
        $query = 'UPDATE ' . $database->escapeName($this->getTableName()) . ' SET ' . $data . ' WHERE id = ' . $id;
        $database->sendQuery($query);
    }
}