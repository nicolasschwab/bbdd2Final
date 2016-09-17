<?php

require_once 'vendor/autoload.php';

class ViewController{

    private static $dirVistas="vistas";

    public function cargarLogin($parametros=array()){
        $this->cargarVista("login.html", $parametros);
    }

    public function cargarSingUp($parametros=array()){
        $this->cargarVista("singup.html", $parametros);
    }

    public function cargarNuevaConsulta($parametros=array()){
        $this->cargarVista("consultaNueva.html", $parametros);
    }

    public function cargarHome($parametros=array()){
        $this->cargarVista("home.html",$parametros);
    }

    public function cargarDetalleConsulta($parametros=array()){
        $this->cargarVista("detalleConsulta.html",$parametros);
    }

    private function cargarVista($nombreVista, $parametros=array()){
        $loader = new Twig_Loader_Filesystem(self::$dirVistas);
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate($nombreVista);
        $parametros["login"]= SessionManager::getName();
        $template->display($parametros );
    }


}


?>