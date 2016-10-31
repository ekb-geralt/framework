<?php
namespace components;
use UserPanelWidget;

/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 30.03.2016
 * Time: 0:30
 */
class Autoloader //загружает классы
{
    public function getFileName($className)
    {
        if ($className == UserPanelWidget::class) { // UserPanelWidget::class возвращает имя класса, теперь уже полное имя, вместе с неймспейс
            return PROJECT_ROOT . '/widgets/userPanel/' . $className . '.php';
        }

        return PROJECT_ROOT . '/classes/' . join('/', explode('\\', $className)) . '.php'; //$className приходит из spl_autoload_register и load и содержит имя класса вместе с неймспейсом через \, а путь идет с /, поэтому меняем \ на /
    }

    public function load($className)
    {
        if (!file_exists($this->getFileName($className))){
            debug_print_backtrace();
            var_dump($className); exit;

        }
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