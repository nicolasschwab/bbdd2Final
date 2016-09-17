<?php

require_once 'models/model.php';

class Permiso extends Model{

    public function createCreator($usuarioId, $consultaId){
        $this->create($usuarioId,$consultaId, "1");
    }

    public function createAdmin($usuarioId, $consultaId){
        $this->create($usuarioId,$consultaId, "2");
    }

    public function createEjecutor($usuarioId, $consultaId){
        $this->create($usuarioId,$consultaId, "3");
    }

    public function createVisitor($usuarioId, $consultaId){
        $this->create($usuarioId,$consultaId, "4");
    }

    private function create($usuarioId, $consultaId, $permiso){
        DatabaseManager::createConnection();
        try {
            $consultaBean = $this->getConsultaModel()->findById($consultaId);
            $usuarioBean = $this->getUsuarioModel()->findById($usuarioId);
            if ($consultaBean->id == 0 || $usuarioBean->id == 0 || ($permiso != 1 && $permiso != 2 && $permiso != 3 && $permiso != 4)) {
                return null;
            }
            $permisoBean = R::dispense('permiso');
            $permisoBean["consulta"] = $consultaBean;
            $permisoBean["usuario"] = $usuarioBean;
            $permisoBean["permiso"] = $permiso;

            R::store($permisoBean);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    public function findById($id){
        return $this->findByTypeId("permiso", $id);
    }

    public function tienePermiso($usuarioId, $consultaId, $permiso){
        DatabaseManager::createConnection();
        $permisoBean = null;
        try {
            switch ($permiso) {
                case "ver":
                    $permisoBean = R::findOne("permiso", "usuario_id = ? and consulta_id = ?", [$usuarioId, $consultaId]);
                    break;
                case "editar":
                    $permisoBean = R::findOne("permiso", "usuario_id = ? and consulta_id = ? and permiso<3", [$usuarioId, $consultaId]);
                    break;
                case "ejecutar":
                    $permisoBean = R::findOne("permiso", "usuario_id = ? and consulta_id = ? and permiso<4", [$usuarioId, $consultaId]);
                    break;
                case "administrar":
                    $permisoBean = R::findOne("permiso", "usuario_id = ? and consulta_id = ? and permiso<3", [$usuarioId, $consultaId]);
                    break;
                case "editarAdmin":
                    $permisoBean = R::findOne("permiso", "usuario_id = ? and consulta_id = ? and permiso=1", [$usuarioId, $consultaId]);
                    break;
            }
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        if($permisoBean != null){
            return $permisoBean->permiso;
        }
        return 0;
    }

    public function modificar($usuarioId, $consultaId, $permiso)
    {
        DatabaseManager::createConnection();
        try {
            $permisoBean = $this->getPermiso($usuarioId, $consultaId);
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
            }
            $permisoBean->permiso = $permiso;
            R::store($permisoBean);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    public function eliminar($idConsulta, $idUsuario){
        DatabaseManager::createConnection();
        try {
            $permisoBean = $this->getPermiso($idUsuario, $idConsulta);
            R::trash($permisoBean);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    public function getPermiso($usuarioId, $consultaId){
        DatabaseManager::createConnection();
        $permisoBean = null;
        try {
            $permisoBean = R::findOne("permiso", "usuario_id = ? and consulta_id = ?", [$usuarioId, $consultaId]);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();

        return $permisoBean;
    }

    public function getPermisosHastaDe($usuarioId, $permiso){
        DatabaseManager::createConnection();
        $result= array();
        try {
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
            $result = R::find("permiso", "usuario_id= ? and permiso >= ?", [$usuarioId, $permiso]);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return array_values($result);
    }

}

?>