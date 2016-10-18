<?php


class ControllerFactory{

    private static $dirControllers = "controllers";

    public static function getController($controllerName){
        require_once self::$dirControllers."/".strtolower($controllerName)."Controller.php";
        $fullControllerName = $controllerName."Controller";
        return new $fullControllerName();
    }

}


?>