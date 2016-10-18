<?php

require_once 'beans/bean.php';

class PermisoBean extends Bean{

    public function crear($consulta, $usuario, $numeroPermiso){
        $permiso = R::dispense('permiso');
        $permiso["consulta"] = $consulta;
        $permiso["usuario"] = $usuario;
        $permiso["permiso"] = $numeroPermiso;
        $this->persist($permiso);
    }

    public function findById($id){
        $permiso = parent::findById("permiso",$id);
        return $this->processOneReturn($permiso);
    }

    public function tienePermiso($nombrePermiso, $usuarioId, $consultaId){
        switch ($nombrePermiso) {
            case "ver":
                return  R::findOne("permiso", "usuario_id = ? and consulta_id = ?", [$usuarioId, $consultaId]);
                break;
            case "ejecutar":
                return  R::findOne("permiso", "usuario_id = ? and consulta_id = ? and permiso<4", [$usuarioId, $consultaId]);
                break;
            case "administrar":
                return  R::findOne("permiso", "usuario_id = ? and consulta_id = ? and permiso<3", [$usuarioId, $consultaId]);
                break;
            case "editarAdmin":
                return  R::findOne("permiso", "usuario_id = ? and consulta_id = ? and permiso=1", [$usuarioId, $consultaId]);
                break;
        }
    }

    public function modificar($numeroPermiso, $permiso){
        if( $permiso->usuario->id == SessionManager::getId()){
            ViewManager::addMensaje('mensaje', 'no puedes darte permisos a vos mismo');
            throw new Exception();
        }
        $permiso['permiso'] = $numeroPermiso;
        $this->persist($permiso);
    }

    public function getPermiso($usuarioId, $consultaId){
        $permiso = R::findOne("permiso", "usuario_id = ? and consulta_id = ?", [$usuarioId, $consultaId]);
        return $this->processOneReturn($permiso);
    }

    public function getPermisoHastaDe($usuarioId, $permiso){
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
            case "creador":
                $permiso = 1;
                break;
        }

       return R::find("permiso", "usuario_id= ? and permiso >= ?", [$usuarioId, $permiso]);
    }

    public function encontrarYEliminar($idUsuario, $idConsulta){
        $permiso = $this->getPermiso($idUsuario, $idConsulta);        
        parent::eliminar($permiso);
    }

    public function getPermisosExcepto($idConsulta, $idUsuario){
        return R::find('permiso', 'consulta_id = ? and usuario_id != ?', [$idConsulta, $idUsuario]);
    }

    public function eliminar($permiso){
        if($permiso->usuario->id != $permiso->consulta->usuario_id){
            parent::eliminar($permiso);
        }else{
            ViewManager::addMensaje('mensaje', 'no puedes eliminar al creador');
            throw new Exception;
        }
    }

    private function processOneReturn($permiso){
        if($permiso == null || $permiso->id == 0 ){
            return NullObjectFactory::getPermisoNullObject();
        }
        return $permiso;
    }
}

?>