<?php

class NullObjectFactory{
	

    private static $nullObjectDir = "nullObjects";

    private static function getNullObject($nullObjectName){
        require_once self::$nullObjectDir."/".strtolower($nullObjectName)."NullObject.php";
        $fullName = $nullObjectName."NullObject";
        return new $fullName;
    }

    public static function getUsuarioNullObject(){
    	return self::getNullObject('Usuario');
    }
    
    public static function getPermisoNullObject(){
    	return self::getNullObject('Permiso');
    }

    public static function getConsultaNullObject(){
    	return self::getNullObject('Consulta');
    }


}

?>