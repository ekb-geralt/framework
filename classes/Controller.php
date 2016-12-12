<?php

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
        $className = get_class($this); //возвращает полное имя класса, а нужно короткое
        $className = array_pop(explode('\\', $className));//разбиваем класснейм по \, получается массив, где последний элемент и есть короткое имя класса
        $controllerName = substr($className, 0, strrpos($className, 'Controller')); //проверить что счет совпадает, напр. сфбстр считает с 0, а стрпос точно ли с 0 считет, совпадают ли позиции, отсчитывать 5 символов включительно или исключительно

        return $controllerName;
    }

    public function render($localViewName, $variables = [])
    {
        $globalViewName = $this->getName() . '/' . $localViewName;
        $layoutContent = $this->renderViewOnly($globalViewName, $variables); //передаем variables насквозь, т.к. интерфейс совместимый

        echo $this->renderViewOnly('layout', ['content' => $layoutContent]);
    }

    /**
     * @param string $globalViewName
     * @param array $variables
     * @return string
     * @throws Exception
     */
    public function renderViewOnly($globalViewName, $variables = [])
    {
        $__fileName = 'views/' . $globalViewName . '.php';
        if (!file_exists($__fileName)) {
            throw new Exception('Нет такого представления.'); // представление - вьюха
        }
        extract($variables);
        ob_start();
        include $__fileName;

        return ob_get_clean();
    }
}