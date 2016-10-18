<?php


class ServiceFactory{

	private static $dirServices = "services";

    private static function getService($serviceName){
        require_once self::$dirServices."/".strtolower($serviceName)."Service.php";
        $fullServiceName = $serviceName."Service";
        return new $fullServiceName();
    }

    public static function getUsuarioService(){
		return self::getService('Usuario');
    }

    public static function getConsultaService(){
		return self::getService('Consulta');
    }

    public static function getPermisoService(){
		return  self::getService('Permiso');
    }
}

?>