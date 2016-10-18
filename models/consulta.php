<?php

require_once 'models/model.php';

class Model_Consulta extends Model{

    private $id;
    private $nombre;
    private $sql;

    public function getNombre(){
        return $this->nombre;
    }

    public function getSql(){
        return $this->sql;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setSql($sql){
        $this->sql = $sql;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

   /* public function listar($ownerName){
        DatabaseManager::createConnection();
        $result=array();
        try {
            $usuarioModel = $this->getUsuarioBean();
            $usuario = $usuarioModel->findByUserName($ownerName);
            $result = $this->getConsultaBean()->listar($usuario);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $result;
    }  */

}

?>

