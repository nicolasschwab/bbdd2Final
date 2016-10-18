<?php

require_once "controllers/controller.php";

class PermisoController extends Controller{

    private $userMail;
    private $consultaId;
    private $permiso;
    private $permisoId;


    public function getPermiso($idConsulta){
        return ServiceFactory::getPermisoService()->getPermiso(SessionManager::getId(), $idConsulta);
    }

    public function agregar(){        
        SessionManager::validateSession();
        $this->getParametrosPost();
        ServiceFactory::getPermisoService()->quiereAgregar($this->userMail, $this->consultaId, $this->permiso);
        $this->getConsultaController()->mostrarConsulta($this->consultaId);
    }

    public function quitar(){
        SessionManager::validateSession();
        $this->getParametrosPost();
        ServiceFactory::getPermisoService()->quiereQuitar($this->consultaId, $this->permisoId);
        $this->getConsultaController()->mostrarConsulta($this->consultaId);
    }

    public function getConsultasCompartidas($idUsuario){
        SessionManager::validateSession();
        $result = ServiceFactory::getPermisoService()->getPermisosHastaDe($idUsuario, "administrar");
        $respuesta = array();
        foreach ($result as $permiso){
            $respuesta[]=$permiso->consulta;
        }
        ViewManager::setObjeto($respuesta);
    }

    private function getParametrosPost(){
        if(isset($_POST["compartirEmail"])){
            $this->userMail=$_POST["compartirEmail"];
        }
        if(isset($_POST["id"])){
            $this->consultaId=$_POST["id"];
        }
        if(isset($_POST["permiso"])){
            $this->permiso=$_POST["permiso"];
        }
        if(isset($_POST["idPermiso"])){
            $this->permisoId=$_POST["idPermiso"];
        }
    }

}

?>