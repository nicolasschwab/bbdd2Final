<?php

require_once 'managers/viewManager.php';
require_once 'managers/sessionManager.php';
require_once "managers/validationManager.php";
require_once "factories/nullObjectFactory.php";

class Bean{

    public function persist($bean){
        R::store($bean);
    }

    public function eliminar($bean){
        if($bean == null or $bean->id == 0){
            throw new Exception();
        }
        R::trash($bean);
    }

    public function findById($claseBean, $id){
        return R::load($claseBean, $id);
    }

}

?>