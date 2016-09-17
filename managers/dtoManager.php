<?php

include "factories/dtoFactory.php";

class DtoManager{

    public static function createUsuarioDto($usuario){
        $usuarioDto = DtoFactory::getDto("usuarioDTO");
        $usuarioDto->nombre = $usuario->nombre;
        $usuarioDto->apellido = $usuario->apellido;
        $usuarioDto->email = $usuario->email;
        $usuarioDto->nombre_usuario = $usuario->nombre_usuario;
        return $usuarioDto;
    }

    public static function createConsultaDto($consulta){
        $consultaDto= DtoFactory::getDto("consultaDTO");
        $consultaDto->id=$consulta->id;
        $consultaDto->nombre=$consulta->nombre;
        $consultaDto->codigo_sql=$consulta->codigo_sql;
        $consultaDto->creador=self::createUsuarioDto($consulta->usuario);;
        return $consultaDto;
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

}

?>