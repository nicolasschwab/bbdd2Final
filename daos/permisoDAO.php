<?php

require_once "daos/dao.php";

class PermisoDAO extends DAO{

    public function createByModel($permisoModel){
        DatabaseManager::createConnection();
        try {
            $this->getPermisoBean()->crear($permisoModel->getConsulta(), $permisoModel->getUsuario(), $permisoModel->getPermiso());
            DatabaseManager::commitTransaction();
            ViewManager::addMensaje('mensaje', 'Se ortorgo el permiso correctamente!');
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    private function createByIds($usuarioId, $consultaId, $permiso){
        DatabaseManager::createConnection();
        try {
            $consultaBean = $this->getConsultaBean()->findById($consultaId);
            $usuarioBean = $this->getUsuarioBean()->findById($usuarioId);
            $this->getPermisoBean()->crear($consultaBean, $usuarioBean, $permiso);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    public function findById($id){
        DatabaseManager::createConnection();
        $return = null;
        try {
            $return = $this->getPermisoBean()->findById($id);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $return;
    }

    public function getPermiso($usuarioId, $consultaId){
        DatabaseManager::createConnection();
        $permiso = NullObjectFactory::getPermisoNullObject();
        try {
            $permiso = $this->getPermisoBean()->getPermiso($usuarioId, $consultaId);            
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        if($permiso == null){
            $permiso = NullObjectFactory::getPermisoNullObject();
        }
        return $permiso;
    }

    public function getPermisosHastaDe($usuarioId, $permiso){
        DatabaseManager::createConnection();
        $result= array();
        try {
            $result = $this->getPermisoBean()->getPermisoHastaDe($usuarioId, $permiso);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return array_values($result);
    }

    public function update($permisoModel)
    {
        DatabaseManager::createConnection();
        try {
            $permiso = $this->getPermisoBean()->getPermiso( $permisoModel->getUsuario()->id, $permisoModel->getConsulta()->id );
            $this->getPermisoBean()->modificar($permisoModel->getPermiso(), $permiso);            
            DatabaseManager::commitTransaction();
            ViewManager::addMensaje('mensaje', 'Se modificaron los permisos correctamente!');
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    public function quitarPermiso($permisoId){
        DatabaseManager::createConnection();
        try {
            $permiso = $this->getPermisoBean()->findById($permisoId);
            $this->getPermisoBean()->eliminar($permiso);
            ViewManager::addMensaje('mensaje', 'Se quitó el permiso con exito!');
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

	
}

?>