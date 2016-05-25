<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 04.05.2016
 * Time: 21:59
 */
class Query
{
    /**
     * @var string[]
     */
    protected $select;
    /**
     * @var string[]
     */
    protected $from;
    /**
     * @var Database
     */
    protected $database;
    /**
     * @var array
     */
    protected $where;

    /**
     * @var array[]
     */
    protected $join = [];

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $skip;

    public function select($columnNames = '*') //в скобках дефолтный параметр
    {
        if (is_string($columnNames)) { //делает массив если строка
            $columnNames = [$columnNames];
        }

        foreach ($columnNames as &$columnName) { //экранирование
            $columnName = $this->escapeAliasedName($columnName);
        }
        unset($columnName);

        $this->select = $columnNames;

        return $this;
    }

    public function from($tableNames)
    {
        if (is_string($tableNames)) {
            $tableNames = [$tableNames];
        }

        foreach ($tableNames as &$tableName) {
            $tableName = $this->escapeAliasedName($tableName);
        }
        unset($tableName);
        $this->from = $tableNames;

        return $this; //chaining - метод возвращает сам объект, для того, чтобы вызывать на одном объекте несколько методов через стрелки
    }

    public function getText()
    {
        $selectBlock = 'select ' . join(', ', $this->select);
        $fromBlock = $this->from ? ' from ' . join(', ', $this->from) : '';
        $joinBlock = join('', array_map(function ($array) {
            return ' join ' . $this->escapeAliasedName($array[0]) . ' on ' . $this->formatCondition($array[1]);
        }, $this->join));
        $whereBlock = $this->where ? ' where ' . $this->formatCondition($this->where) : '';

        $limitBlock = '';
        if (isset($this->limit) && is_null($this->skip)) {
            $limitBlock = ' limit ' . $this->limit;
        } elseif (isset($this->skip)) {
            $limit = isset($this->limit) ? $this->limit : 4294967295; //4294967295 предположительно, максимальное к-во строк в таблице
            $limitBlock = ' limit ' . $this->skip . ', ' . $limit;
        }

        return $selectBlock . $fromBlock . $joinBlock . $whereBlock . $limitBlock;
    }

    /**
     * @param $name string
     * @return string
     * @throws Exception
     */
    protected function escapeAliasedName($name)
    {
        $name = str_ireplace(' as ', ' ', $name);
        $parts = explode(' ', $name);
        $parts = array_filter($parts, function ($part) {
            return $part != '';
        }); //каждый элемент из первого массива посылает как первый аргумент в функцию, поэтому в part есть значение
        $count = count($parts);
        if ($count == 1) {
            $name = Database::escapeName($parts[0]); //запуск статического метода
        } elseif ($count == 2) {
            $name = Database::escapeName($parts[0]) . ' as ' . Database::escapeName($parts[1]);
        } else {
            throw new Exception('Неправильный формат имени таблицы');
        }

        return $name;
    }

    public function __construct($database) //метод конструктор, запускается при создании объекта класса, выполняется на нем же. Теперь Квери знает с какой БД работает. Это надо для мскули ескапе стринг
    {
        $this->database = $database;
    }

    protected function formatCondition($condition)
    {
        switch ($condition[0]) {
            case '=':
                $second = $condition[2] instanceof DatabaseExpression
                    ? $condition[2]->getEscapedValue()
                    : ('\'' . $this->database->connection->real_escape_string($condition[2]) . '\''); //кавычки экранируются \
                return Database::escapeName($condition[1]) . ' = ' . $second;
            case 'and':
                return join(' and ', array_map([$this, 'formatCondition'], array_slice($condition, 1)));
        }

        throw new Exception('Неподдерживаемый оператор');
    }

    public function where($condition) //condition - условие
    {
        $this->where = $condition;

        return $this;
    }

    public function getRows()
    {
        $query = $this->getText();
        $result = $this->database->sendQuery($query);

        return $result;
    }

    public function join($tableName, $condition)
    {
        $this->join[] = [$tableName, $condition];

        return $this;
    }

    /**
     * @param $limit int|float|string число возвращаемых рядов
     * @return $this
     */
    public function limit($limit) //первая часть Limit,  rows
    {
        if (!is_numeric($limit)) {
            throw new InvalidArgumentException('Неверный формат данных');
        }
        $this->limit = (int)$limit;

        return $this;
    }

    /**
     * @param $skip int|float|string число возвращаемых рядов
     * @return $this
     */
    public function skip($skip) //2я часть Limit, offset
    {
        if (!is_numeric($skip)) {
            throw new InvalidArgumentException('Неверный формат данных');
        }
        $this->skip = (int)$skip;

        return $this;
    }
}