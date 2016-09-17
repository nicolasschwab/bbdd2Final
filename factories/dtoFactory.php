<?php

class DtoFactory{
    private static $dirDtos = "dtos";

    public static function getDto($dtoName){
        require_once self::$dirDtos."/".strtolower($dtoName).".php";
        return new $dtoName();
    }
}

?>