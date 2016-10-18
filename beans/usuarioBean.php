<?php

require_once "beans/bean.php";

class UsuarioBean extends Bean{

    public function create($nombre, $apellido, $email, $nombreUsuario, $contrasena){
        $usuario = R::dispense('usuario');
        $usuario['nombre'] = $nombre;
        $usuario['apellido'] = $apellido;
        $usuario['email'] = $email;
        $usuario['nombre_usuario'] = $nombreUsuario;
        $usuario['contrasena'] = md5($contrasena);
        $this->persist($usuario);
    }

    public function findByNameAndContrasena($usuario, $contrasena){
        $result = R::findOne('usuario', 'nombre_usuario=? and contrasena = ?', [$usuario, md5($contrasena)]);
        return $this->processOneReturn($result);
    }

    public function findByUserName($name){
        $result =  R::findOne('usuario', 'nombre_usuario=?', [$name]);
        return $this->processOneReturn($result);
    }

    public function findById($id){
        parent::findById("usuario",$id);
    }

    public function findByEmail($email){
        return R::find("usuario", "email LIKE ?", ["%" . $email . "%"]);
    }

    public function findByExactEmail($email){
        $result = R::findOne("usuario", "email = ?", [$email]);
        return $this->processOneReturn($result);
    }

    private function processOneReturn($usuario){
        if($usuario == null || $usuario->id == 0 ){
            return NullObjectFactory::getUsuarioNullObject();
        }
        return $usuario;
    }

}

?>