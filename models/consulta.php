<?php

require_once 'models/model.php';

class Consulta extends Model{

    public function create($nombre, $sql, $ownerName){
        DatabaseManager::createConnection();
        $consulta = null;
        try {
            $usuarioModel = $this->getUsuarioModel();
            $usuario = $usuarioModel->findByUserName($ownerName);
            if ($usuario != null && $usuario->id != 0) {
                $consulta = R::dispense('consulta');
                $consulta["nombre"] = $nombre;
                $consulta["codigo_sql"] = $sql;
                $usuario->ownConsultaList[] = $consulta;
                R::store($usuario);
                $this->getPermisoModel()->createCreator($usuario->id, $consulta->id);
            }
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $consulta;
    }

    public function listar($ownerName){
        DatabaseManager::createConnection();
        $result=array();
        try {
            $usuarioModel = $this->getUsuarioModel();
            $usuario = $usuarioModel->findByUserName($ownerName);
            if ($usuario != null && $usuario->id != 0) {
                $result = R::find("consulta", "usuario_id = ?", [$usuario->id]);
            }
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $result;
    }

    public function modificar($idConsulta, $nombre, $nombreActual, $sql, $sqlActual){
        DatabaseManager::createConnection();
        $consultaBean = null;
        try {
            $consultaBean = $this->findById($idConsulta);
            if($consultaBean->nombre == $nombreActual && $consultaBean->codigo_sql == $sqlActual) {
                $consultaBean["nombre"] = $nombre;
                $consultaBean["codigo_sql"] = $sql;
                R::store($consultaBean);
            }
            else{
                //La consulta se modifico entre que el usuario la vio y la modifico!!!
                $consultaBean = null;
                throw new Exception();
            }
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
        return $consultaBean;
    }

    public function eliminar($idConsulta, $idUsuario){
        DatabaseManager::createConnection();
        try {
            $this->getPermisoModel()->eliminar($idConsulta, $idUsuario);
            $consultaBean = $this->findById($idConsulta);
            R::trash($consultaBean);
            DatabaseManager::commitTransaction();
        }
        catch (Exception $e){
            DatabaseManager::rollbackTransaction();
        }
        DatabaseManager::closeConnection();
    }

    public function findById($id){
        return $this->findByTypeId("consulta" ,$id);

    }

}

?>

