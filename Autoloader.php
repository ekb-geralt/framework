<?php

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 30.03.2016
 * Time: 0:30
 */
class Autoloader
{
    public function getFileName($className)
    {
        if ($className == UserPanelWidget::class) { // UserPanelWidget::class возвращает имя класса
            return PROJECT_ROOT . '/widgets/userPanel/' . $className . '.php';
        }

        return $className . '.php';
    }

    public function load($className)
    {
        require_once $this->getFileName($className);
    }

    public function register() // регестрирует метод лоад как автозагрузчик
    {
        spl_autoload_register([$this, 'load']); // [$this, 'load'] - ссылка на матод лоад объекта зыс, такие ссылки работоспособны только для функций встроенных в пхп
    }

    public function canLoad($className)
    {
        return file_exists($this->getFileName($className)); // экспрешн дает тру если файл существует
    }
}