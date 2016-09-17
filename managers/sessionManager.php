<?php

class SessionManager{

    public static function createSession($name, $id){
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION["nombre"]=$name;
        $_SESSION["id"]=$id;
    }

    public static function deleteSession(){
        if(!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION["nombre"]);
        session_write_close();
    }

    public static function validateSession(){
        if(!isset($_SESSION)) {
            session_start();
        }
        if(isset($_SESSION["nombre"])){
            return true;
        }
        return false;
    }

    public static function getName(){
        if(self::validateSession()){
            return $_SESSION["nombre"];
        }
        return "";
    }

    public static function getId(){
        if(self::validateSession()){
            return $_SESSION["id"];
        }
        return "";
    }
}
?>