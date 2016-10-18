<?php

require_once 'managers/validationManager.php';
require_once 'factories/serviceFactory.php';
require_once 'factories/daoFactory.php';

class Service{
	
	public function sinPermisos(){
        ViewManager::addMensaje('mensaje', 'No tenes permiso suficientes');
        ViewManager::setEstado(false);
    }

}

?>