<?php

require_once 'redBean/rb.php';

require_once 'managers/validationManager.php';
require_once 'managers/viewManager.php';
require_once 'factories/beanFactory.php';
require_once 'managers/databaseManager.php';
require_once 'factories/nullObjectFactory.php';

class Model extends RedBean_SimpleModel{

    protected $consultaBean;
    protected $usuarioBean;
    protected $permisoBean;

    protected function getConsultaBean(){
        if(!isset($this->consultaBean)){
            $this->consultaBean = BeanFactory::getBean('consulta');
        }
        return $this->consultaBean;
    }

    protected function getUsuarioBean(){
        if(!isset($this->usuarioBean)){
            $this->usuarioBean = BeanFactory::getBean('usuario');
        }
        return $this->usuarioBean;
    }

    protected function getPermisoBean(){
        if(!isset($this->permisoBean)){
            $this->permisoBean = BeanFactory::getBean('permiso');
        }
        return $this->permisoBean;
    }

    protected function findByTypeId($type, $id){
        DatabaseManager::createConnection();
        $usuario= R::load($type, $id);
        DatabaseManager::closeConnection();
        return $usuario;
    }

}


?>