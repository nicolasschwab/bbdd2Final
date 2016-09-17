<?php

require_once 'models/model.php';

class Usuario extends Model{

    public function create($nombre, $apellido, $email, $nombreUsuario, $contrasena){
        DatabaseManager::createConnection();
        try {
            $usuario = R::dispense('usuario');
            $usuario['nombre'] = $nombre;
            $usuario['apellido'] = $apellido;
            $usuario['email'] = $email;
            $usuario['nombre_usuario'] = $nombreUsuario;
            $usuario['contrasena'] = md5($contrasena);
            R::store($usuario);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    public function findByNameAndContrasena($usuario, $contrasena){
        DatabaseManager::createConnection();
        $result = null;
        try {
            $result = R::findOne('usuario', 'nombre_usuario=? and contrasena = ?', [$usuario, md5($contrasena)]);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $result;
    }

    public function singUp($nombre, $apellido, $email, $usuario, $contrasena){
        $result = $this->findByUserName($usuario);
        if(!ValidationManager::noEmptyArray($result)){
            $this->create($nombre, $apellido, $email, $usuario, $contrasena);
            return "usuario creado";
        }else{
            return null;
        }
    }

    public function findByUserName($name){
        DatabaseManager::createConnection();
        $result = null;
        try {
            $result = R::findOne('usuario', 'nombre_usuario=?', [$name]);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $result;
    }

    public function findById($id){
        return $this->findByTypeId("usuario", $id);
    }

    public function findByEmail($email){
        DatabaseManager::createConnection();
        $result = null;
        try {
            $result = R::find("usuario", "email LIKE ?", ["%" . $email . "%"]);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return array_values($result);
    }

    public function findByExactEmail($email){
        DatabaseManager::createConnection();
        $result = null;
        try {
            $result = R::findOne("usuario", "email = ?", [$email]);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $result;
    }

}


?>