<?php

include "factories/dtoFactory.php";

class DtoManager{

    public static function createUsuarioDto($usuario){
        $usuarioDto = DtoFactory::getUsuarioDto();
        $usuarioDto->nombre = $usuario->nombre;
        $usuarioDto->apellido = $usuario->apellido;
        $usuarioDto->email = $usuario->email;
        $usuarioDto->nombre_usuario = $usuario->nombre_usuario;
        return $usuarioDto;
    }

    public static function createConsultaDto($consulta){
        $consultaDto= DtoFactory::getConsultaDto();
        $consultaDto->id = $consulta->id;
        $consultaDto->nombre = $consulta->nombre;
        $consultaDto->codigo_sql = $consulta->codigo_sql;
        $consultaDto->creador = self::createUsuarioDto($consulta->usuario);
        return $consultaDto;
    }

    public static function createPermisoDto($permiso){
        $permisoDto= DtoFactory::getPermisoDto();
        $permisoDto->id = $permiso->id;
        $permisoDto->nombreUsuario = $permiso->usuario->nombre_usuario;
        $permisoDto->permiso = $permiso->getShowPermiso();
        return $permisoDto;
    }

    public static function crearArrayDtoDeConsultas($consultas){
        $array= array();
        foreach ($consultas as $consulta){
            $dtoConsulta = self::createConsultaDto($consulta);
            $array[$consulta->id] = $dtoConsulta;
        }
        return $array;
    }

    public static function crearArrayDtoDeUsuarios($usuarios){
        $array= array();
        foreach ($usuarios as $usuario){
            $dtoUsuario = self::createUsuarioDto($usuario);
            $array[$usuario->id] = $dtoUsuario;
        }
        return $array;
    }

    public static function createArrayPermisoDto($permisos){
        $array= array();
        foreach ($permisos as $permiso){
            $dtoPermiso = self::createPermisoDto($permiso);
            $array[$permiso->id] = $dtoPermiso;
        }
        return $array;
    }

}

?>
