<?php

require_once "controllers/controller.php";

class PermisoController extends Controller{

    private $userMail;
    private $consultaId;
    private $permiso;

    private $permisoModel;


    /**
     * Devuelve el permiso que tenga, o 0 si no tiene
     *
     * @param $idConsulta
     * @param $permiso
     * @return bool
     */
    public function tienePermiso($idConsulta, $permiso){
        $usuarioBean = ModelManager::getModel("usuario")->findByUserName(SessionManager::getName());
        if($permiso != "ver" && $permiso != "editar" && $permiso != "ejecutar" && $permiso != "administrar" && $permiso != "editarAdmin"){
            return 0;
        }
        return ModelManager::getModel("permiso")->tienePermiso($usuarioBean->id, $idConsulta, $permiso);
    }

    public function agregar(){
        if(SessionManager::validateSession()){
            $this->getParametrosPost();
            //alguno es null reenviamos al home
            if(!isset($this->userMail) || $this->userMail == "" || !isset($this->consultaId) || $this->consultaId == "" || !isset($this->permiso) || $this->permiso == ""){
                $this->redireccionarHome();
            }else{
                $consultaController = ControllerManager::getController("consulta");
                $consultaBean = $consultaController->encontrar($this->consultaId);
                //chequeo que la consulta exista
                if($consultaBean == null || $consultaBean->id == 0){
                    $this->redireccionarHome(array("mensaje"=>"no tenes permisos para acceder a la consulta"));
                }else {
                    //chequeo que el usuario tenga permisos de admin o creador en la consulta
                    $permisoModel = ModelManager::getModel("permiso");
                    $tienePermiso = $permisoModel->tienePermiso(SessionManager::getId(), $consultaBean->id, "administrar");
                    if($tienePermiso == 0){
                        $this->redireccionarHome(array("mensaje"=>"no tenes permisos para acceder a la consulta"));
                    }
                    else {
                        $userController = ControllerManager::getController("user");
                        $usuarioBean = $userController->encontrarUsuarioByEmail($this->userMail);
                        //chqueo que el mail exista
                        if ($usuarioBean == null || $usuarioBean->id == 0) {
                            $mensaje = array("mensaje" => "no hay ningun usuario con ese mail");
                        } else {
                            //chequeo que el permiso elegida exista y no se de creador
                            if ($this->permiso != "ver" && $this->permiso != "ejecutar" && $this->permiso != "administrar") {
                                $mensaje = array("mensaje" => "no existe ese permiso!");
                            } else {
                                //chequeo que no se este dando permisos a el mismo xD
                                if($usuarioBean->id == SessionManager::getId()){
                                    $mensaje = array("mensaje" => "no puedes darte permisos a vos mismo!");
                                }
                                else {
                                    $tienePermiso = $permisoModel->tienePermiso($usuarioBean->id, $consultaBean->id, "ver");
                                    //chequeo si el usuario ya tenia un permiso
                                    if ($tienePermiso != 0) {
                                        $permisoModel->modificar($usuarioBean->id, $consultaBean->id, $this->permiso);
                                        $mensaje = array("mensaje" => "permiso otrogado!");
                                    } else {
                                        switch ($this->permiso) {
                                            case "ver":
                                                $permisoModel->createVisitor($usuarioBean->id, $this->consultaId);
                                                break;
                                            case "ejecutar":
                                                $permisoModel->createEjecutor($usuarioBean->id, $this->consultaId);
                                                break;
                                            case "administrar":
                                                $permisoModel->createAdmin($usuarioBean->id, $this->consultaId);
                                                break;
                                        }
                                        $mensaje = array("mensaje" => "permiso otrogado!");
                                    }
                                }
                            }
                        }
                        $this->redireccionarVistaConsulta($consultaBean,$mensaje);
                    }
                }
            }
        }else{
            $this->redireccionarLogin();
        }
    }

    public function getConsultasCompartidas($idUsuario){
        if(SessionManager::validateSession()){
            $this->setPermisoModel();
            $result = $this->permisoModel->getPermisosHastaDe($idUsuario, "administrar");
            foreach ($result as $permiso){
                $respuesta[]=$permiso->consulta;
            }
            if(isset($respuesta )){
                return $respuesta;
            }
            return array();
        }else{
            $this->redireccionarLogin();
        }
    }

    private function setPermisoModel(){
        if(!isset($this->permisoModel)){
            $this->permisoModel = ModelManager::getModel("permiso");
        }
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
    }

}

?>