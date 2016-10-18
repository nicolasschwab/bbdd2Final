<?php

require_once 'models/model.php';
require_once 'managers/sessionManager.php';

class Model_Usuario extends Model{

    public function login(){        
        SessionManager::createSession($this->bean->nombre_usuario, $this->bean->id);
        SessionManager::setIgnoreCookie(true);
    }

    public function getMisConsultas(){        
        return $this->bean->ownConsultaList;
    }

    public function findById($id){
        return $this->getUsuarioBean()->findById($id);
    }

}


?>