<?php

require_once "controllers/controller.php";

class LoginController extends Controller{

    private $usuario;
    private $contrasena;

    public function login(){
        SessionManager::validateNoSession();
        $this->asignarVariablesPorPost();
        ServiceFactory::getUsuarioService()->login($this->usuario, $this->contrasena);
        $this->home();
    }

    public function logout(){
        SessionManager::validateSession();
        SessionManager::deleteSession();
        ViewManager::home();     
    }

    public function home(){
        ViewManager::home();
    }

    public function cargarSingUp(){
        ViewManager::redireccionarSingUp();
    }

    private function asignarVariablesPorPost(){
        if(isset($_POST["usuario"])){
            $this->usuario = $_POST["usuario"];
        }
        if(isset($_POST["contrasena"])){
            $this->contrasena = $_POST["contrasena"];
        }
    }

}


?>