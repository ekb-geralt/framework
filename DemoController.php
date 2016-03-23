<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 17.03.2016
 * Time: 0:49
 */
class DemoController
{
    public $defaultActionName = 'hello';

    public function sortAction()
    {

    }

    public function helloAction()
    {
        echo 'Hello, World!';
    }

    public function execute($actionName = null)
    {
        if (is_null($actionName)) {
            $actionName = $this->defaultActionName;
        }
        $methodName = $actionName . 'Action';
        if (method_exists($this, $methodName)) {
            $this->$methodName();
        } else {
            throw new Exception('Нет такого действия');
        }
    }
}