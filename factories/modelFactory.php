<?php


class ModelManager{

    private static $dirModels = "models";

    public static function getModel($modelName){
        require_once self::$dirModels."/".strtolower($modelName).".php";
        return new $modelName();
    }

}


?>