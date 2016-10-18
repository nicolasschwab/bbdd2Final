<?php

require_once 'factories/beanFactory.php';
require_once 'redBean/rb.php';
require_once 'managers/databaseManager.php';
require_once 'factories/nullObjectFactory.php';
class DAO{
	

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
	
}

?>