<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 17.03.2016
 * Time: 1:33
 */
class Application
{
    public $defaultControllerName = 'demo';
    /**
     * @var Request
     */
    public $request;

    /**
     * @param null $controllerName
     * @return DemoController
     * @throws Exception
     */
    public function getController($controllerName = null)
    {
        if (is_null($controllerName)) {
            $controllerName = $this->defaultControllerName;
        }
        $className = ucfirst($controllerName) . 'Controller';
        $fileName = $className . '.php';
        if (!file_exists($fileName)) { //удостоверяемся в том, что такой класс существует
            throw new Exception('Нет такого контроллера');
        }
        require_once $fileName;
        $controller = new $className();
        $controller->app = $this; //связываем аппликейшн с контроллером для того чтобы конороллер он мог узнать в каком приложении он запущен и обратиться к другим модулям этого приложения

        return $controller;
    }
}