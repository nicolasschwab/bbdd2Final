<?php

require_once 'managers/viewManager.php';

class ValidationManager{

    private static function noEmptyString($string){
        if(  $string!= "" && $string!=null && !empty(trim($string)) ){
            return true;
        }
        return false;
    }

    private static function noNullString($string){
        if( isset($string) && $string != null ){
            return true;
        }
        return false;
    }

    public static function noEmptyArray($array){
        return !empty($array);
    }

    public static function modificarConsulta($nombre, $sql){
        $result = true;
        if( !self::noEmptyString($nombre) && !noNullString($nombre) ){
            $result &= false;
            ViewManager::addMensaje('nombre', 'El nombre de la consulta no puede estar vacio');
        }
        if( !self::noEmptyString($sql) && !self::noNullString($sql) ){
            $result &= false;
            ViewManager::addMensaje('sql', 'El codigo de la consulta no puede estar vacio');
            }
        ViewManager::setEstado(true);
        return $result;
    }

    public static  function crearConsulta($nombre, $sql){
        $result = true;
        $result &= self::validateStringNoSpecialChars($nombre, 'nombre');
        $result &= self::validateStringAllowSpecialChars($sql, 'sql');
        return $result;
    }

    public static function login($nombreUsuario, $constrasena){
        $result = true;
        $result &= self::validateStringNoSpecialChars($nombreUsuario, 'usuario');
        $result &= self::validateStringAllowSpecialChars($constrasena, 'contrasena');
        return $result;
    }

    public static function misConsultas($nombreUsuario){
        return self::validateStringAllowSpecialChars($nombreUsuario);
    }

    public static function singUp($nombre, $apellido, $email, $usuario, $contrasena){
        $result = true;
        $result &= self::validateStringNoSpecialChars($nombre, 'nombre');
        $result &= self::validateStringNoSpecialChars($apellido, 'apellido');
        $result &= self::validateEmail($email, 'email');
        $result &= self::validateStringNoSpecialChars($usuario, 'usuario');
        $result &= self::validateStringAllowSpecialChars($contrasena, 'contrasena');
        return $result;   
    }

    public static function agregarPermiso($userMail, $consultaId, $permiso){
        $result = true;
        $result &= self::validatePositiveInt($consultaId, '');
        $result &= self::validateStringNoSpecialChars($permiso, 'permiso');
        $result &= self::validateEmail($userMail, 'email');
        return $result;
    }

    private static function validateStringAllowSpecialChars($string, $nameString = ''){
        self::addVariableValue($nameString, $string);
        if( !self::noEmptyString($string) ){
            if( self::noNullString($string) ){
                self::addMensajeVacio($nameString);
            }
            return false;
        }
        return true;
    }

    private static function validatePositiveInt($int, $nameString){
        if( is_numeric($int) && $int > 0 ){
            return true;
        }else{
            self::addMensajeVacio($nameString);
            return false;
        }
    }

    private static function validateStringNoSpecialChars($string, $nameString = ''){
        self::addVariableValue($nameString, $string);
        if( !self::noEmptyString($string) ){
            if( self::noNullString($string) ){
                self::addMensajeVacio($nameString);
            }
            return false;
        }else{
                if( !preg_match("/^[a-zA-Z ]*$/",$string) ){
                    self::addMensajeCaracteresErrones($nameString);
                    return false;
                }
            }
        return true;
    }

    private static function validateEmail($email, $nameEmail){
        self::addVariableValue($nameEmail, $email);
        if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
            self::addMensajeEmail($nameEmail);
            return false;
        }
        return true;
    }

    private static function addVariableValue($name, $value){
        ViewManager::addMensaje("$name"."Value", $value);
    }

    private static function addMensajeEmail($variableName){
        ViewManager::addMensaje("$variableName", "El campo $variableName tiene el formato incorrecto");
    }

    private static function addMensajeCaracteresErrones($variableName){
        ViewManager::addMensaje("$variableName", "El campo $variableName no puede tener caracteres especiales");
    }

    private static function addMensajeVacio($variableName){
        ViewManager::addMensaje("$variableName", "El campo $variableName no puede estar vacio");
    }

}
?>