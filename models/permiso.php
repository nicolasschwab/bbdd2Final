<?php

require_once 'models/model.php';

class Model_Permiso extends Model{

    private $consulta;
    private $permiso;
    private $usuario;
    private $id;

    public function agregarPermiso($permisoService){
        if($this->bean['permiso']<3){
            //es admin o creador
            $permisoService->puedeAgregar();
        }else{
            $permisoService->sinPermisos();
        }
    }

    public function quitarPermiso($permisoService){
        if($this->bean['permiso']<3){
            //es admin o creador
            $permisoService->puedeQuitar();
        }else{
            $permisoService->sinPermisos();
        }
    }

    public function crear($permisoService){
        $permisoService->modificar();
    }

    public function puedeMostrar($consultaService){
        $this->verificarAccion($consultaService, "ver", "ver");
    }

    public function puedeModificar($consultaService){
        $this->verificarAccion($consultaService, "administrar", "editar");
    }

    public function puedeEliminar($consultaService){
        $this->verificarAccion($consultaService, "administrar", "eliminar");
    }

    private function verificarAccion($consultaService, $permiso, $accion){
        $result = $this->tienePermiso($this->bean->permiso, $permiso);
        if($result == 1){
            //tiene permiso
            ViewManager::addMensaje('permiso', $this->bean["permiso"]);
            switch ($accion) {
                case 'ver':
                    $consultaService->mostar();
                    break;
                case 'editar':
                    $consultaService->modificar();
                    break;
                case 'eliminar':
                    $consultaService->eliminar();
                    break;
            }            
        }else{
            //no tiene permiso
            $consultaService->sinPermisos();
        }
    }

    public function findById($id){
        DatabaseManager::createConnection();
        $return = NullObjectFactory::getNullObject("Permiso");
        try {
            $return = $this->getPermisoBean()->findById($id);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        if($return == null){
            $return = NullObjectFactory::getNullObject("Permiso");
        }
        return $return;
    }


    private function tienePermiso($permisoQueTiene, $permisoQueQuiere){
        switch ($permisoQueQuiere) {
            case 'ver':
                return true;
                break;
            case 'administrar':
                if($permisoQueTiene < 3){
                    return true;
                }
                break;            
            default:
                return false;
                break;
        }
    }    

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setPermiso($permiso){
        switch ($permiso) {
            case "ver":
                $permiso = 4;
                break;
            case "ejecutar":
                $permiso = 3;
                break;
            case "administrar":
                $permiso = 2;
                break;
            default:
                ViewManager::addMensaje('mensaje', 'no puedes asignar ese permiso');
                throw new Exception;
                break;
        }
        $this->permiso = $permiso;
    }

    public function getPermiso(){
        return $this->permiso;
    }

    public function getShowPermiso(){
        switch ($this->bean['permiso']) {
            case 4:
                return "ver";
                break;
            case 3:
                return "ejecutar";
                break;
            case 2:
                return "administrar";
                break;
            case 1:
                return "creador";
                break;
        }
    }

    public function setConsulta($consulta){
        $this->consulta = $consulta;
    }

    public function getConsulta(){
        return $this->consulta;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }   
}

?>