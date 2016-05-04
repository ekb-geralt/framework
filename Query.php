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

    /**
     * @param $name string неэкранированная часть имени
     * @return string экранированная часть имени
     */
    protected function escapePartialName($name)
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
    protected function escapeName($name)
    {
        $names = explode('.', $name);
        $names = array_map([$this, 'escapePartialName'], $names); // [$this, 'escapePartialName'] - один из синтаксисов callable(типа данных), а нужене он потому что синтаксис аррей мапа
        $names = join('.', $names);

        return $names;
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
        return 'select ' . join(', ', $this->select) . ' from ' . join(', ', $this->from);
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
            $name = $this->escapeName($parts[0]);
        } elseif ($count == 2) {
            $name = $this->escapeName($parts[0]) . ' as ' . $this->escapeName($parts[1]);
        } else {
            throw new Exception('Неправильный формат имени таблицы');
        }

        return $name;
    }
}