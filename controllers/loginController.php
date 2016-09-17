<?php

require_once "controllers/controller.php";

class LoginController extends Controller{

    private $usuario;
    private $contrasena;

    public function login(){
        if(!SessionManager::validateSession()) {
            $this->asignarVariablesPorPost();
            if (ValidationManager::noEmptyString($this->usuario) && ValidationManager::noEmptyString($this->contrasena)) {
                $usuarioModel = ModelManager::getModel("usuario");
                $resultado = $usuarioModel->findByNameAndContrasena($this->usuario, $this->contrasena);
                if ($resultado == null || $resultado->id == 0 ) {
                    $this->redireccionarLogin(array('mensaje' => "El usuario y/o contraseña son incorrectos"));
                } else {
                    SessionManager::createSession($this->usuario, $resultado->id);
                    $this->redireccionarHome();
                }
            } else {
                //mensaje de error
                $this->redireccionarLogin(array('mensaje' => "Debe completar todos los campos"));
            }
        }else{
            $this->redireccionarHome();
        }
    }

    public function logout(){
        if(SessionManager::validateSession()) {
            SessionManager::deleteSession();
        }
        $this->redireccionarLogin();
    }

    private function asignarVariablesPorPost(){
        if(isset($_POST["usuario"])){
            $this->usuario = $_POST["usuario"];
        }
        if(isset($_POST["contrasena"])){
            $this->contrasena = $_POST["contrasena"];
        }
    }

    public function cargarLogin(){
        $this->redireccionarLogin();
    }

    public function cargarSingUp(){
        $this->redireccionarSingUp();
    }

}


?>