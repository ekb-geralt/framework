<?php

/**
 * Class Component
 * @property $app Application
 */
abstract class Component
{
    public function __get($name)
    {
        if ($name == 'app') {
            return Application::getInstance();
        }

        throw new Exception('Нет такого свойства');
    }
}