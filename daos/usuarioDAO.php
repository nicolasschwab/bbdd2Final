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
            $result = $this->getUsuarioBean()->findByUserName($nombreUsuario);
            $result2 = $this->getUsuarioBean()->findByExactEmail($email);
            if(!ValidationManager::noEmptyArray($result) && !ValidationManager::noEmptyArray($result2)){
                $this->getUsuarioBean()->create($nombre, $apellido, $email, $nombreUsuario, $contrasena);
                ViewManager::addMensaje('mensaje', 'Usuario creado!');
                ViewManager::setEstado(true);
            }else{
                ViewManager::addMensaje('mensaje', 'El nombre de usuario y/o mail ya esta en uso');
                ViewManager::setEstado(false);
            }
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