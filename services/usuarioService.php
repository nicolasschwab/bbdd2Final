<?php

require_once "services/service.php";
require_once "models/usuario.php";

class UsuarioService extends Service{
	
	private $usuario;
	private $usuarioDAO;

	function __construct(){
		$this->usuario = new Model_usuario();
		$this->usuarioDAO = DAOFactory::getUsuarioDAO();
	}

	public function findByUserName($name){
		$usuarioDAO = DAOFactory::getUsuarioDAO();
		return $usuarioDAO->findByUserName($name);       
    }

    public function login($nombreUsuario, $contrasena){
    	if ( ValidationManager::login( $nombreUsuario,$contrasena ) ){
            $this->usuario = $this->usuarioDAO->findByNameAndContrasena($nombreUsuario, $contrasena);
            $this->usuario->login();                
        }
    }

    public function getMisConsultas($nombreUsuario){
    	if( ValidationManager::misConsultas($nombreUsuario) ){
    		$usuario = $this->usuarioDAO->findByUserName($nombreUsuario);
    		return $usuario->getMisConsultas();
    	}
    }

    public function singUp($nombre, $apellido, $email, $usuario, $contrasena){    	
    	if( ValidationManager::singUp($nombre, $apellido, $email, $usuario, $contrasena) ){
    		$this->usuarioDAO->create($nombre, $apellido, $email, $usuario, $contrasena);
    	}
    }

    public function findByExactEmail($email){
        return $this->usuarioDAO->findByExactEmail($email);
    }

    public function findByEmail($email){
        return $this->usuarioDAO->findByEmail($email);
    }

}

?>
