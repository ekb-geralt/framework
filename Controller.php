<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 27.03.2016
 * Time: 22:11
 */
abstract class Controller //с abstract запрещается создание экземпляра этого класса
{
    public $defaultActionName = 'default';
    /**
     * @var Application
     */
    public $app;

    public function execute($actionName = null)
    {
        if (is_null($actionName)) {
            $actionName = $this->defaultActionName;
        }
        $methodName = $actionName . 'Action';
        if (method_exists($this, $methodName)) {
            $this->$methodName();
        } else {
            throw new Exception('Нет такого действия.');
        }
    }

    public function getName()
    {
        $className = get_class($this);
        $controllerName = substr($className, 0, strrpos($className, 'Controller')); //проверить что счет совпадает, напр. сфбстр считает с 0, а стрпос точно ли с 0 считет, совпадают ли позиции, отсчитывать 5 символов включительно или исключительно

        return $controllerName;
    }

    public function render($viewName, $params = [])
    {
        $__fileName = 'views/' . $this->getName() . '/' . $viewName . '.php'; //сделно через __имя, чтобы избежать прихода аналогичного имени из data
        if (!file_exists($__fileName)) {
            throw new Exception('Нет такого представления.'); // представление - вьюха
        }
        extract($params);

        include $__fileName;
    }
}