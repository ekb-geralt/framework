<?php

abstract class ActiveRecord
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    protected $currentDbId; //старый ид, является флагом, если объект загружен из базы, в нем будет старый айдишник
    
    public function __construct($isNew = true)
    {
        if ($isNew) {
            $this->init();
        }
    }

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
            $object = new static(false); //передаем конструктору команду не инициализировать, чтобы не затереть свойства, например
            $object->currentDbId = $row['id'];
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
        $fields = $this->getFields();
        $data = $database->formatSetQuerySection($fields);
        if (isset($this->currentDbId)) {
            $currentDbId = $database->connection->real_escape_string($this->currentDbId); //$this->id кладется во втором фориче в getObjects
            $query = 'UPDATE ' . $database->escapeName($this->getTableName()) . ' SET ' . $data . ' WHERE id = ' . $currentDbId;
        } else {
            $query = 'INSERT ' . $database->escapeName($this->getTableName()) . ' SET ' . $data;
        }

        $database->sendQuery($query);
        if (!isset($this->currentDbId)) { //после save у этого объекта в id ничего нет, поэтому кладем туда значение
            $this->id = $database->connection->insert_id;
        }
        $this->currentDbId = $this->id; // возваращаем в исходное состояние - при получении инфы о городе, например, есть id,
        //и currentDbId равен id, что говорит нам о том, что мы взяли объект из бд. если в конце не вернуть все в исходное состояние, то при
        //следующем таком же запросе метод будет работать со старыми данными
    }

    public function delete()
    {
        if (is_null($this->currentDbId)) {
            throw new Exception('Нет такого объекта в базе');
        }
        $database = Application::getInstance()->db;
        $currentDbId = $database->connection->real_escape_string($this->currentDbId);
        $query = 'DELETE FROM ' . $database->escapeName($this->getTableName()) . 'WHERE id = ' . $currentDbId;
        $database->sendQuery($query);
        $this->currentDbId = null;
    }

    public static function getTableColumns()
    {
        $database = Application::getInstance()->db;
        $tableName = static::getTableName();
        $query = 'SHOW COLUMNS FROM' . $database->escapeName($tableName);

        return $database->sendQuery($query); // возвращает массив ассоциативных массивов
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return array_column(static::getTableColumns(), 'Field');
    }

    /**
     * @return array Ассоциативный массив, где ключи - имена столбцов, а значения - значения одноименных свойств модели
     */
    public function getFields()
    {
        $columnNamesAsKeys = array_flip(static::getColumnNames());

        return array_intersect_key((array)$this, $columnNamesAsKeys);//получаем список полей(столбцов) в БД, объект this кастуется как массив, id здесь
    }

    /**
     * Инициализируем свойства у объекта
     * Каждое свойство - это название столбца таблицы
     */
    protected function init()
    {
        $columnNames = static::getColumnNames();
        foreach ($columnNames as $columnName) {
            $this->$columnName = null;
        }
    }

}