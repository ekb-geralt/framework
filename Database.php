<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 27.04.2016
 * Time: 22:13
 */
class Database
{
    /**
     * @var mysqli
     */
    public $connection;

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
}