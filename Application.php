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
     * @var Autoloader
     */
    public $autoloader;

    /**
     * @var Database
     */
    public $db;

    /**
     * @var Session
     */
    public $session;

    /**
     * @var FlashMessages
     */
    public $flashMessages;

    /**
     * @var User
     */
    public $user;

    /**
     * @param null $controllerName
     * @return Controller
     * @throws Exception
     */
    public function getController($controllerName = null)
    {
        if (is_null($controllerName)) {
            $controllerName = $this->defaultControllerName;
        }
        $className = ucfirst($controllerName) . 'Controller';
        if (!$this->autoloader->canLoad($className)) { //удостоверяемся в том, что такой класс существует
            throw new Exception('Нет такого контроллера');
        }
        $controller = new $className();
        $controller->app = $this; //связываем аппликейшн с контроллером для того чтобы конороллер он мог узнать в каком приложении он запущен и обратиться к другим модулям этого приложения

        return $controller;
    }
}