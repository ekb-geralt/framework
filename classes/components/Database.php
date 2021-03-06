<?php
namespace components;
use Component;
use DatabaseExpression;
use Exception;
use mysqli;

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 27.04.2016
 * Time: 22:13
 */
class Database extends Component
{
    /**
     * @var mysqli
     */
    public $connection;

    public function __construct($params)
    {
        $this->connect($params['hostName'], $params['userName'], $params['password'], $params['baseName']);
    }

    public function connect($serverName, $userName, $userPassword, $dbName)
    {
        $this->connection = new mysqli($serverName, $userName, $userPassword, $dbName);
        if ($this->connection->connect_error) {
            throw new Exception('Ошибка подключения (' . $this->connection->connect_errno . ') '
                . $this->connection->connect_error);
        }
        if (!$this->connection->set_charset('utf8')) {
            throw new Exception('Ошибка при загрузке набора символов utf8: ' . $this->connection->error);
        }
    }


    public function sendQuery($query)
    {
        $result = $this->connection->query($query);
        if (!$result) {
            throw new Exception('Ошибка запроса (' . $this->connection->errno . ') '
                . $this->connection->error);
        }
        if ($result === true) {
            return true;
        } else {
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $result->free();

            return $rows;
        }
    }

    /**
     * @param $name string неэкранированная часть имени
     * @return string экранированная часть имени
     */
    static function escapePartialName($name)
    {
        if ($name !== '*') {
            $name = str_replace('`', '``', $name);
            $name = '`' . $name . '`';
        }

        return $name;
    }

    /**
     * @param $name string неэкранированное имя
     * @return string экранированное имя
     */
    static function escapeName($name)
    {
        $names = explode('.', $name);
        $names = array_map([static::class, 'escapePartialName'], $names); // [$this, 'escapePartialName'] - один из синтаксисов callable(типа данных), а нужен он потому что синтаксис аррей мапа
        $names = join('.', $names);

        return $names;
    }

    /**
     * @param $name string|DatabaseExpression
     * @return string
     */
    public static function escapeAnyName($name)
    {
        return $name instanceof DatabaseExpression
            ? $name->getEscapedValue()
            : static::escapeName($name);
    }

    /**
     * @param $fields
     * @return string
     */
    public function formatSetQuerySection($fields)
    {
        $keys = array_keys($fields); //получаем ключи из fields[] в виде нового массива, где они будут значениями
        $values = array_values($fields);
        $data = join(', ', array_map(function ($key, $value) { //array_map в данном случае сделает массив вида ключ = значение
            if (is_null($value)) {
                $sqlValue = 'NULL';
            } else {
                $sqlValue = "'" . $this->connection->real_escape_string($value) . "'";
            }

            return $this->escapeName($key) . ' = ' . $sqlValue;
        }, $keys, $values));
        
        return $data;
    }
}