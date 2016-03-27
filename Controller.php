<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 27.03.2016
 * Time: 22:11
 */
abstract class Controller //� abstract ����������� �������� ���������� ����� ������
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
            throw new Exception('��� ������ ��������.');
        }
    }

    public function getName()
    {
        $className = get_class($this);
        $controllerName = substr($className, 0, strrpos($className, 'Controller')); //��������� ��� ���� ���������, ����. ������ ������� � 0, � ������ ����� �� � 0 ������, ��������� �� �������, ����������� 5 �������� ������������ ��� �������������

        return $controllerName;
    }

    public function render($viewName, $data = [])
    {
        $__fileName = 'views/' . $this->getName() . '/' . $viewName . '.php'; //������ ����� __���, ����� �������� ������� ������������ ����� �� data
        if (!file_exists($__fileName)) {
            throw new Exception('��� ������ �������������.'); // ������������� - �����
        }
        extract($data);

        include $__fileName;
    }
}