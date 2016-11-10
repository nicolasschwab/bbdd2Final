<?php

require_once 'beans/bean.php';

class ConsultaBean extends Bean{

    public function crear($consulta, $usuario){
        
        $consultaBean = R::dispense('consulta');
        $consultaBean["nombre"] = $consulta->getNombre();
        $consultaBean["codigo_sql"] = $consulta->getSql();
        $usuario->ownConsultaList[] = $consultaBean;
        $this->persist($usuario);

        return $consultaBean;
    }

    public function listar($usuario){
        if ($usuario != null && $usuario->id != 0) {
            return R::find("consulta", "usuario_id = ?", [$usuario->id]);
        }
    }

    public function modificar($consultaBean, $consultaVista, $nombreNuevo, $sqlNuevo ){
        if($consultaBean->nombre == $consultaVista->getNombre() && $consultaBean->codigo_sql == $consultaVista->getSql() ) {
            $consultaBean["nombre"] = $nombreNuevo;
            $consultaBean["codigo_sql"] = $sqlNuevo;
            $this->persist($consultaBean);
        }
        else{
            //La consulta se modifico entre que el usuario la vio y la modifico!!!
            ViewManager::addMensaje("mensaje", "la consulta fue modificada mientras procesabamos tu modificación. Mira como quedo!");
            throw new Exception();
        }
    }

    public function findById($id, $var = null){
        return parent::findById("consulta", $id);
    }

}

?>