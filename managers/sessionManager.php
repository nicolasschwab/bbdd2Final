<?php

class SessionManager{

    public static $ignoreCookie = false;

    public static function createSession($name, $id){
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION["nombreUs"] = $name;
        $_SESSION["id"] = $id;
        $_SESSION["nombre"] = md5(uniqid());
        $_SESSION["valor"] = md5(uniqid());
        self::createCookie();
    }

    public static function deleteSession(){
        if(!isset($_SESSION)) {
            session_start();
        }
        unset($_COOKIE[$_SESSION["nombre"]]);
        unset($_SESSION["nombre"]);
        session_write_close();
    }

    public static function validateSession(){
        if(!isset($_SESSION)) {
            session_start();
        }
        if(self::ifSession()){
            self::createCookie();
            return;
        }else{
            throw new Exception();            
        }
    }

    public static function validateNoSession(){
        if(!isset($_SESSION)) {
            session_start();
        }
        if(!self::ifSession()){
            return;
        }else{
            throw new Exception();            
        }
    }

    public static function getName(){
        if(self::ifSession()){
            return $_SESSION["nombreUs"];
        }
        return "";
    }

    public static function getId(){
        if(self::ifSession()){
            return $_SESSION["id"];
        }
        return "";
    }

    public static function ifSession(){
        if(!isset($_SESSION)) {
            session_start();
        }
        if(self::$ignoreCookie){
            return true;
        }
        if(isset($_SESSION["nombre"]) && isset($_SESSION["valor"])){
            if(!empty($_COOKIE[$_SESSION["nombre"]]) && ( $_COOKIE[$_SESSION["nombre"]] == $_SESSION["valor"]) ){
                return true;
            }
        }        
        return false;
    }

    public static function setIgnoreCookie($value){
        self::$ignoreCookie = $value;
    }

    private static function createCookie(){
        setcookie($_SESSION["nombre"], $_SESSION["valor"], time() + 86400 );
    }
}
?>
