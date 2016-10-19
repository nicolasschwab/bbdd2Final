<?php

require_once "daos/dao.php";

class UsuarioDAO extends DAO{
	
	public function findByUserName($nombreUsuario){

		DatabaseManager::createConnection();
        $result = null;
        try {
            $result = $this->getUsuarioBean()->findByUserName($nombreUsuario);            
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $result;
	}

    public function findByNameAndContrasena($usuario, $contrasena){
        DatabaseManager::createConnection();
        $result = null;
        try {
            $result = $this->getUsuarioBean()->findByNameAndContrasena($usuario, $contrasena);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $result;
    }

    public function create($nombre, $apellido, $email, $nombreUsuario, $contrasena){
        DatabaseManager::createConnection();
        try {
            $usuarioPorNombre = $this->getUsuarioBean()->findByUserName($nombreUsuario);
            $usuarioPorMail = $this->getUsuarioBean()->findByExactEmail($email);
            $usuarioPorNombre->create();
            $usuarioPorMail->create();
            $this->getUsuarioBean()->create($nombre, $apellido, $email, $nombreUsuario, $contrasena);
            ViewManager::addMensaje('mensaje', 'Usuario creado!');
            ViewManager::setEstado(true);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    public function findByExactEmail($email){
        DatabaseManager::createConnection();
        $result = null;
        try {
            $result = $this->getUsuarioBean()->findByExactEmail($email);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $result;
    }

    public function findByEmail($email){
        DatabaseManager::createConnection();
        $result = null;
        try {
            $result = $this->getUsuarioBean()->findByEmail($email);
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