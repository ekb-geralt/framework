<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 27.03.2016
 * Time: 23:44
 */
class Request
{
    public function getParam($paramName)
    {
        return isset($_REQUEST[$paramName]) ? $_REQUEST[$paramName] : null; //возвращаем параметр если он задан или нулл если не задан. а если не прописать нулл отдельно, то будет ошибка
    }

    public function __get($propertyName) //магия
    {
        return $this->getParam($propertyName);
    }
}