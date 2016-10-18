<?php

require_once "daos/dao.php";

class ConsultaDAO extends DAO{
	
	public function create ($consulta, $usuario){
		DatabaseManager::createConnection();
        $consultaBean = null;
        try {
            $consultaBean = $this->getConsultaBean()->crear($consulta, $usuario);
            $this->getPermisoBean()->crear($consultaBean, $usuario, 1);
            ViewManager::setEstado(true);
            ViewManager::addMensaje('mensaje','Se creo la consulta!');
            ViewManager::setObjeto($consultaBean);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $consultaBean;
	}

    public function modificar($consultaVista, $nombreNuevo, $sqlNuevo){
        DatabaseManager::createConnection();
        try {
            $consulta = $this->getConsultaBean()->findById( $consultaVista->getId() );
            $this->getConsultaBean()->modificar($consulta, $consultaVista, $nombreNuevo, $sqlNuevo );
            ViewManager::addMensaje('mensaje', 'se modifico la consulta!!');
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        ViewManager::setEstado(true);
        ViewManager::setObjeto( $this->findById( $consultaVista->getId()) );
    }

	public function mostrar($id){
        DatabaseManager::createConnection();
        try {
            $result = $this->getConsultaBean()->findById($id);
            $permisos = $this->getPermisoBean()->getPermisosExcepto($id, SessionManager::getId());
            ViewManager::setObjeto($result);
            ViewManager::setEstado(true);
            ViewManager::addMensaje('permisos', $permisos);
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
            $return = $this->getConsultaBean()->findById($id);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $return;
    }

    public function eliminar($idUsuario, $consulta){
        DatabaseManager::createConnection();
        try {
            $this->getPermisoBean()->encontrarYEliminar($idUsuario, $consulta->getId());
            $consultaBean = $this->getConsultaBean()->findById($consulta->getId());
            $this->getConsultaBean()->eliminar($consultaBean);
            ViewManager::addMensaje('mensaje', 'La consulta se elimino con exito!');
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();        
    }  

}

?>