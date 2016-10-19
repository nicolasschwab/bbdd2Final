<?php

require_once "services/service.php";
require_once "models/permiso.php";

class PermisoService extends Service{
	
	private $permisoDAO;
	private $permiso;

	function __construct(){
		$this->permisoDAO = DAOFactory::getPermisoDAO();
		$this->permiso = new Model_Permiso();
	}

	public function getPermiso( $usuarioId, $consultaId ){
		return $this->permisoDAO->getPermiso( $usuarioId, $consultaId );
	}

	public function getPermisosHastaDe($idUsuario, $permiso){
		return $this->permisoDAO->getPermisosHastaDe($idUsuario, $permiso);
	}

	public function quiereAgregar($userMail, $consultaId, $permiso){
		if( ValidationManager::agregarPermiso($userMail, $consultaId, $permiso) ){
			$usuarioBean = ServiceFactory::getUsuarioService()->findByExactEmail($userMail);
			$consultaBean = ServiceFactory::getConsultaService()->findById($consultaId);
			$this->permiso->setUsuario($usuarioBean);			
			$this->permiso->setPermiso($permiso);
			$this->permiso->setConsulta($consultaBean);
            $permisoModel = $this->permisoDAO->getPermiso(SessionManager::getId(), $consultaId);
            //verificar si el usuario tiene permisos para dar permisos
            $permisoModel->agregarPermiso($this);
        }
	}

	public function puedeAgregar(){
		//aca me llega o nullObject de permiso o el permiso que ya tiene el usuario al cual le queremos asignar un permiso 
		$permiso = $this->permisoDAO->getPermiso($this->permiso->getUsuario()->getId(), $this->permiso->getConsulta()->getId());
		$permiso->crear($this);
	}

	public function agregar(){		
		//si llega aca el usuaro no tenia un permiso asginado
		$this->permisoDAO->createByModel($this->permiso);
	}

	public function modificar(){
		//si llega aca significa que el usuario ya tenia un permiso y se lo van a cambiar
		$this->permisoDAO->update($this->permiso);
	}

	public function quiereQuitar($idConsulta, $idPermiso){
	    $permiso = $this->permisoDAO->getPermiso(SessionManager::getId(), $idConsulta);
	    $this->permiso->setId($idPermiso);
        //verificar si el usuario tiene permisos para quitar permisos
        $permiso->quitarPermiso($this);
	}

	public function puedeQuitar(){
		$this->permisoDAO->quitarPermiso($this->permiso->getId());
	}
	
}

?>