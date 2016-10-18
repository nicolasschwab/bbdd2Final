<?php

class DtoFactory{
    private static $dirDtos = "dtos";

    private static function getDto($dtoName){
        require_once self::$dirDtos."/".strtolower($dtoName).".php";
        return new $dtoName();
    }

	public static function getUsuarioDto(){
		return self::getDto('UsuarioDTO');
	}

	public static function getConsultaDto(){
		return  self::getDto('ConsultaDTO');
	}

	public static function getPermisoDto(){
		return self::getDto('PermisoDTO');
	}
}

?>