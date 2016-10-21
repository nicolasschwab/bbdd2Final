<?php

require_once 'vendor/autoload.php';
require_once 'managers/sessionManager.php';

class ViewManager{

    private static $dirVistas="vistas";
    private static $estado;
    private static $mensaje;
    private static $objeto;

    public function setEstado($nuevoEstado){
        self::$estado = $nuevoEstado;
    }

    public function setMensaje($nuevoMensaje){
        self::$mensaje = $nuevoMensaje;
    }

    public function addMensaje($clave, $valor){
        if(self::$mensaje == null){
            self::$mensaje = array();
        }
        self::$mensaje[$clave] = $valor;        
    }

    public function setObjeto($nuevoObjecto){
        self::$objeto = $nuevoObjecto;
    }

    public static function crearConsulta(){
        if(self::$estado == true){
            self::redireccionarVistaConsulta();
        }
        else{
            self::redireccionarNuevaConsulta();
        }
    }

    public static function modificarConsulta(){
        if(self::$estado == true){
            self::redireccionarVistaConsulta();
        }
        else{
            self::home();            
        }
    }

    public static function home(){
        if(SessionManager::ifSession()){
            $usuarioController = ControllerFactory::getController("User");
            $usuarioController->misConsultas();
            self::$mensaje["consultas"] = DtoManager::crearArrayDtoDeConsultas(self::$objeto);
            self::$mensaje["selected"] = "home";
            self::cargarHome(self::$mensaje);
            SessionManager::setIgnoreCookie(false);
        }else{            
            self::cargarLogin(self::$mensaje);
        }
    }

    public static function redireccionarSingUp(){
        SessionManager::validateNoSession();
        if(self::$estado == true){
            self::home(self::$mensaje);
        }else{
            self::cargarSingUp(self::$mensaje);
        }
    }

    public static function redireccionarHomeConsultasCompartidas(){
        SessionManager::validateSession();
        self::$mensaje["consultas"] = DtoManager::crearArrayDtoDeConsultas(self::$objeto);
        self::$mensaje["selected"] = "compartidas";
        self::cargarHome(self::$mensaje);
    }

    
    public static function redireccionarNuevaConsulta(){
        SessionManager::validateSession();
        self::$mensaje["selected"] = "crear";
        self::cargarNuevaConsulta(self::$mensaje);
    }

    public static function redireccionarVistaConsulta(){
        SessionManager::validateSession();
        if(self::$estado == true){
            self::$mensaje['consulta'] = DtoManager::createConsultaDto(self::$objeto);
            self::$mensaje['permisos'] = DtoManager::createArrayPermisoDto(self::$mensaje['permisos']);
            self::cargarDetalleConsulta(self::$mensaje);
        }else{
            self::home();
        }
    }

    public static function error(){
        self::cargarVista("error.html");
    }

    private static function cargarLogin($parametros=array()){
        self::cargarVista("login.html", $parametros);
    }

    private static function cargarSingUp($parametros=array()){
        self::cargarVista("singup.html", $parametros);
    }

    private static function cargarNuevaConsulta($parametros=array()){
        self::cargarVista("consultaNueva.html", $parametros);
    }

    private static function cargarHome($parametros=array()){
        self::cargarVista("home.html",$parametros);
    }

    private static function cargarDetalleConsulta($parametros=array()){
        self::cargarVista("detalleConsulta.html",$parametros);
    }

    private static function cargarVista($nombreVista, $parametros=array()){
        $loader = new Twig_Loader_Filesystem(self::$dirVistas);
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate($nombreVista);
        $parametros["login"]= SessionManager::getName();
        $template->display($parametros );
    }


}


?>
