<?php


class ModelFactory{

    private static $dirModels = "models";

    public static function getModel($modelName){
        require_once self::$dirModels."/".strtolower($modelName).".php";
        $fullName = "Model_".$modelName;
        return new $fullName;
    }

}


?>