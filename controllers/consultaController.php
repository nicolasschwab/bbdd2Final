<?php

require_once "controllers/controller.php";

class ConsultaController extends Controller{

    private $nombre;
    private $nombreActual;
    private $sql;
    private $sqlActual;
    private $id;

    public function crear(){
        SessionManager::validateSession();
        $this->asignarVariablesPorPost();
        ServiceFactory::getConsultaService()->create($this->nombre, $this->sql, SessionManager::getName());
        ViewManager::crearConsulta();
    }

    public function mostrar(){
        SessionManager::validateSession();
        $this->asignarVariablesPorPost();
        $this->mostrarConsulta($this->id);
    }

    public function editar(){
        SessionManager::validateSession();
        $this->asignarVariablesPorPost();
        $permiso = ControllerFactory::getController("Permiso")->getPermiso($this->id);
        ServiceFactory::getConsultaService()->quiereModificar($this->id, $this->nombre, $this->nombreActual, $this->sql, $this->sqlActual, $permiso);
        $this->mostrarConsulta($this->id);
    }

    public function eliminar(){
        SessionManager::validateSession();
        $this->asignarVariablesPorPost();
        $permiso = ControllerFactory::getController("Permiso")->getPermiso($this->id);
        ServiceFactory::getConsultaService()->quiereEliminar($this->id, SessionManager::getId(), $permiso);        
        ViewManager::home();
    }

    public function encontrar($id){
        SessionManager::validateSession();
        return ServiceFactory::getConsultaService()->findById($id);
    }

    public function compartidas(){
        SessionManager::validateSession();
        $permisoController = ControllerFactory::getController("Permiso");
        $permisoController->getConsultasCompartidas(SessionManager::getId());
        ViewManager::redireccionarHomeConsultasCompartidas();
    }

    //me permite llamarlo desde otros metodos y no repetir codigo
    public function mostrarConsulta($consultaId){
        $permiso = ControllerFactory::getController("Permiso")->getPermiso($consultaId);
        ServiceFactory::getConsultaService()->quiereVer($consultaId, $permiso);
        ViewManager::redireccionarVistaConsulta();
    }

    private function asignarVariablesPorPost(){
        if(isset($_POST["nombre"])){
            $this->nombre = $_POST["nombre"];
        }
        if(isset($_POST["nombreActual"])){
            $this->nombreActual = $_POST["nombreActual"];
        }
        if(isset($_POST["sql"])){
            $this->sql = $_POST["sql"];
        }
        if(isset($_POST["sqlActual"])){
            $this->sqlActual= $_POST["sqlActual"];
        }
        if(isset($_POST["id"])){
            $this->id = $_POST["id"];
        }
    }
}
?>

