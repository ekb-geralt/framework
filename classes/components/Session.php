<?php
namespace components;
use Component;

/**
 * Class Session
 */
class Session  extends Component
{
    function __construct()
    {
        session_start();
    }

    public function __set($name, $value) //гет и сет -магические обработчики, которые вызываются, когда класс не может найти в себе свойство которые нужно задать или найти
    {
        $_SESSION[$name] = $value;
    }

    public function __get($name)
    {
        if (!isset($_SESSION[$name])) {
            
            return null;
        } else {

            return $_SESSION[$name];
        }
    }

    public function __isset($name)
    {
        
        return isset($_SESSION[$name]);
    }

    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }
}