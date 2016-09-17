<?php

require_once "managers/validationManager.php";
require_once "managers/sessionManager.php";
require_once "managers/dtoManager.php";
require_once "factories/modelFactory.php";
require_once "factories/controllerFactory.php";
require_once "factories/dtoFactory.php";

class Controller{

    private $logueate=array("mensaje" => "Tenes que loguarte! ");
    protected $sinPermiso =array("mensaje" => "No tenes permiso!");

    protected function redireccionarLogin($mensaje=array()){
        if(!SessionManager::validateSession()) {
            $viewController = ControllerManager::getController("view");
            $viewController->cargarLogin($mensaje);
        }else{
            $this->redireccionarHome($mensaje);
        }
    }

    protected function redireccionarHome($mensaje=array()){
        if(SessionManager::validateSession()){
            $viewController=ControllerManager::getController("view");
            $resul = $this->getConsultas(SessionManager::getName());
            $mensaje["consultas"] = DtoManager::crearArrayDtoDeConsultas($resul);
            $mensaje["selected"] = "home";
            $viewController->cargarHome($mensaje);
        }else{
            $this->redireccionarLogin($this->logueate);
        }
    }

    protected function redireccionarHomeConsultasCompartidas($mensajes){
        if(SessionManager::validateSession()){
            $viewController=ControllerManager::getController("view");
            $mensaje["consultas"] = DtoManager::crearArrayDtoDeConsultas($mensajes);
            $mensaje["selected"] = "compartidas";
            $viewController->cargarHome($mensaje);
        }else{
            $this->redireccionarLogin($this->logueate);
        }
    }

    protected function redireccionarSingUp($mensaje=array()){
        if(!SessionManager::validateSession()){
            $viewController=ControllerManager::getController("view");
            $viewController->cargarSingUp();
        }else{
            $this->redireccionarHome($this->logueate);
        }
    }
    protected function redireccionarNuevaConsulta($mensaje=array()){
        if(SessionManager::validateSession()){
            $viewController=ControllerManager::getController("view");
            $mensaje["selected"] = "crear";
            $viewController->cargarNuevaConsulta($mensaje);
        }else{
            $this->redireccionarLogin($this->logueate);
        }
    }

    protected function redireccionarVistaConsulta($consulta,$mensaje=array()){
        if(SessionManager::validateSession()){
            $viewController=ControllerManager::getController("view");
            $mensaje["consulta"]= DtoManager::createConsultaDto($consulta);
            $viewController->cargarDetalleConsulta($mensaje);
        }else{
            $this->redireccionarLogin($mensaje);
        }
    }

    protected function getConsultas($nombreUsuario){
        if(SessionManager::validateSession()) {
            $usuarioBean = ModelManager::getModel("usuario")->findByUserName($nombreUsuario);
            return array_values($usuarioBean["ownConsultaList"]);
        }
        return array();
    }

}
?>