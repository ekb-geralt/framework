<?php

class Form
{
    /**
     * @var ActiveRecord
     */
    public $model;

    public function __construct($model)
    {
        $this->model = $model; // форма узнает с какой моделью она работает
    }

    public function open($method = 'get') //по умолчанию метод в хтмл - гет
    {
        return '<form method="' . $method. '">'; //хтмл - в одинарных кавычках, имя метода в двойных кавычках
    }

    public function close()
    {
        return '</form>';
    }
    
    protected function _input($name, $value)
    {
        return '<input name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" id="' . htmlspecialchars($name) . '">';
    }

    public function input($name) //для формы в name содержится все, что нужно, т.к. там одно и то же используется - одноименное значение свойства модели 
    {
        $value = $this->model->$name;
        
        return $this->_input($name, $value);
    }

    public function dateInput($name) //здесь в name находится creationDateObject, поэтому на нем можно делать формат
    {
        /** @var DateTime|null $date */
        $date = $this->model->$name;
        $value = is_null($date) ? '' : $date->format('d.m.Y');

        return $this->_input($name, $value);
    }

    public function label($name)
    {
        $labels = $this->model->getFieldLabels();
        $label = isset($labels[$name]) ? $labels[$name] : $name;

        return '<label for="' . $name . '">' . $label . '</label>';
    }
    
}