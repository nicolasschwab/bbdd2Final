<?php

require_once 'redBean/rb.php';
require_once 'factories/databaseFactory.php';
require_once 'managers/validationManager.php';
require_once 'models/consulta.php';
require_once 'models/usuario.php';
require_once 'models/permiso.php';

class Model{

    protected $consultaModel;
    protected $usuarioModel;
    protected $permisoModel;

    protected function getConsultaModel(){
        if(!isset($this->consultaModel)){
            $this->consultaModel= new Consulta();
        }
        return $this->consultaModel;
    }

    protected function getUsuarioModel(){
        if(!isset($this->usuarioModel)){
            $this->usuarioModel= new Usuario();
        }
        return $this->usuarioModel;
    }

    protected function getPermisoModel(){
        if(!isset($this->permisoModel)){
            $this->permisoModel= new Permiso();
        }
        return $this->permisoModel;
    }

    protected function findByTypeId($type, $id){
        DatabaseManager::createConnection();
        $usuario= R::load($type, $id);
        DatabaseManager::closeConnection();
        return $usuario;
    }

}


?>