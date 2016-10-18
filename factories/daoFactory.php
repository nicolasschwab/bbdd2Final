<?php

class DAOFactory{

	private static $dirDaos = "daos";

    private static function getDAO($daoName){
        require_once self::$dirDaos."/".strtolower($daoName)."DAO.php";
        $fullDaoName = $daoName."DAO";
        return new $fullDaoName();
    }

    public static function getUsuarioDAO(){
    	return  self::getDAO('Usuario');
    }

    public static function getConsultaDAO(){
    	return self::getDAO('Consulta');
    }

    public static function getPermisoDAO(){
    	return self::getDAO('Permiso');
    }
}

?>