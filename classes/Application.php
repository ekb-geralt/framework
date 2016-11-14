<?php
use components\Autoloader;
use components\Database;
use components\FlashMessages;
use components\Request;
use components\Session;
use components\UrlManager;
use components\User;

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

    static private $instance;

    /**
     * @var UrlManager
     */
    public $urlManager;

    /**
     * @return static
     */
    public static function getInstance() //singletone подход, только 1 объект этого класса, сы не пришем нюь Аппликейшн, а используем Аппликейшн-инстанс и он возвращает уже существующий объект
    {
        if (!static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

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
        $className = 'controllers\\' . ucfirst($controllerName) . 'Controller';

        if (!$this->autoloader->canLoad($className)) { //удостоверяемся в том, что такой класс существует
            throw new Exception('Нет такого контроллера');
        }
        /** @var Controller $controller */
        $controller = new $className();
        $controller->app = $this; //связываем аппликейшн с контроллером для того чтобы конороллер он мог узнать в каком приложении он запущен и обратиться к другим модулям этого приложения

        return $controller;
    }

    public function configure($config)
    {
        $this->createComponents($config['components']);
    }

    public function createComponents($list)
    {
        foreach ($list as $name => $configuration) {
            $params = isset($configuration['params']) ? $configuration['params'] : [];
            $component = new $configuration['className']($params);
            $this->$name = $component;
        }
    }
}