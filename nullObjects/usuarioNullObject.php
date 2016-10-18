<?php

require_once 'managers/viewManager.php';

class UsuarioNullObject{
	

	public function create($nombre, $apellido, $email, $nombreUsuario, $contrasena){
		return;
	}

	public function login(){
		ViewManager::addMensaje('mensaje', 'El usuario y/o contraseña son incorrectos');
	}

	public function getMisConsultas(){
		return Array();
	}

	public function getId(){
		return -1;
	}

}

?>