<?php

class Session
{
    function __construct()
    {
        session_start();
    }

    public function __set($name, $value) //гет и сет -магические обработчики, которые вызываются, когда класс не может найти в себе свойство которые нужно задать или найти
    {
        $_SESSION[$name] = $value;
    }

    public function __get($name)
    {
        $value = $_SESSION[$name];

        return $value;
    }

    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }
}