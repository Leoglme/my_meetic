<?php
/* Class Autoloader pour auto require les différentes class*/
class Autoloader{
    static function push(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class){
        require('' . __DIR__ . '\\' . $class . '.php');
    }

}

