<?php

require_once "controllers/controller.php";

class ConsultaController extends Controller{

    private $nombre;
    private $nombreActual;
    private $sql;
    private $sqlActual;
    private $id;

    public function crear(){
        if(SessionManager::validateSession()){
            $this->asignarVariablesPorPost();
            $consultaBean = ModelManager::getModel("consulta")->create($this->nombre, $this->sql, $_SESSION["nombre"]);
            if($consultaBean != null && $consultaBean->id != 0){
                $this->redireccionarVistaConsulta($consultaBean);
            }else{
                $this->redireccionarHome(array("mensaje" => "no se pudo crear la consulta"));
            }
        }else{
            $this->redireccionarLogin();
        }
    }

    public function mostrar(){
        if(SessionManager::validateSession()){
            $this->asignarVariablesPorPost();
            $tienePermiso = ControllerManager::getController("permiso")->tienePermiso($this->id, "ver");
            if($tienePermiso != 0){
                $consultaBean = ModelManager::getModel("consulta")->findById($this->id);
                $this->redireccionarVistaConsulta($consultaBean, array("permiso" => $tienePermiso));
            }else{
                $this->redireccionarHome($this->sinPermiso);
            }
        }else{
            $this->redireccionarLogin();
        }
    }

    public function editar(){
        if(SessionManager::validateSession()){
            $this->asignarVariablesPorPost();
            $tienePermiso = ControllerManager::getController("permiso")->tienePermiso($this->id, "editar");
            if($tienePermiso != 0){
                $consultaBean = ModelManager::getModel("consulta")->modificar($this->id, $this->nombre, $this->nombreActual, $this->sql, $this->sqlActual);
                if($consultaBean != null && $consultaBean->id != 0){
                    $mensaje = array("mensaje" => "se modifico la consulta!");
                }
                else{
                    $mensaje = array("mensaje" => "la consulta fue modificada mientras procesabamos tu modificación. Mira como quedo!");
                }
                $consultaBean = ModelManager::getModel("consulta")->findById($this->id);
                $this->redireccionarVistaConsulta($consultaBean, $mensaje);
            }else{
                $this->redireccionarHome($this->sinPermiso);
            }
        }else{
            $this->redireccionarLogin();
        }
    }

    public function eliminar(){
        if(SessionManager::validateSession()){
            $this->asignarVariablesPorPost();
            $tienePermiso = ControllerManager::getController("permiso")->tienePermiso($this->id, "administrar");
            if($tienePermiso != 0){
                $usuarioBean = ModelManager::getModel("usuario")->findByUserName(SessionManager::getName());
                ModelManager::getModel("consulta")->eliminar($this->id, $usuarioBean->id);
                $this->redireccionarHome(array("mensaje" => "La consulta se elimino con exito!"));
            }else{
                $this->redireccionarHome($this->sinPermiso);
            }
        }else{
            $this->redireccionarLogin();
        }
    }

    public function encontrar($id){
        if(SessionManager::validateSession()){
            return ModelManager::getModel("consulta")->findById($id);
        }else{
            $this->redireccionarLogin();
        }
    }

    public function compartidas(){
        if(SessionManager::validateSession()){
            $permisoController = ControllerManager::getController("permiso");
            $arrayConsultasBean = $permisoController->getConsultasCompartidas(SessionManager::getId());
            $this->redireccionarHomeConsultasCompartidas($arrayConsultasBean);
        }else{
            $this->redireccionarLogin();
        }
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

    public function cargarNuevaConsulta(){
        $this->redireccionarNuevaConsulta();
    }
}
?>

