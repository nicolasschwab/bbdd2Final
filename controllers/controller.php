<?php

require_once "managers/validationManager.php";
require_once "managers/sessionManager.php";
require_once "managers/viewManager.php";
require_once "managers/dtoManager.php";
require_once "factories/modelFactory.php";
require_once "factories/serviceFactory.php";
require_once "factories/controllerFactory.php";
require_once "factories/dtoFactory.php";

class Controller{

    protected function getConsultaController(){
        return ControllerFactory::getController("Consulta");
    }

    protected function getLoginController(){
        return ControllerFactory::getController("Login");
    }

    protected function getPermisoController(){
        return ControllerFactory::getController("Permiso");
    }

    protected function getUserController(){
        return ControllerFactory::getController("User");
    }

    protected function getUsuarioModel(){
        return ModelFactory::getModel("usuario");
    }

    protected function getPermisoModel(){
        return ModelFactory::getModel("permiso");
    }

    protected function getConsultaModel(){
        return ModelFactory::getModel("consulta");
    }


    protected function getConsultas($nombreUsuario){
        if(SessionManager::validateSession()) {
            $usuarioBean = $this->usuarioModel->findByUserName($nombreUsuario);
            return array_values($usuarioBean["ownConsultaList"]);
        }
        return array();
    }

}
?>