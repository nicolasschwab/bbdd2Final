<?php

require_once 'Route.php';

class Router{

    private $baseUrl= "/bbdd2";
    private $routes = array();

    public function addRoute($name,$nameFileController, $nameClassController, $function){
        $route= new Route($name, $nameFileController, $nameClassController,$function);
        if(isset($this->routes[$name])){
            die("Esa ruta ya esta asignada");
        }else{
            $this->routes[$name] = $route;
        }
    }

    public function redirect($url){
        $name= explode($this->baseUrl,$url)[1];
        if(isset($this->routes[$name])){
            $route=$this->routes[$name];
            $route->redirect();
        }else{
            ViewManager::error();
        }
    }

}
?>