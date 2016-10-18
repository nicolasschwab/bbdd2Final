<?php

require_once "services/service.php";
require_once "models/consulta.php";

class ConsultaService extends Service{

	private $consulta;
	private $sqlNuevo;
	private $nombreNuevo;
	private $idUsuario;
	private $consultaDAO;

	function __construct(){
		$this->consulta = new Model_Consulta();
		$this->consultaDAO = DAOFactory::getConsultaDAO();
	}

	public function create($nombreConsulta, $sql, $nombreUsuario){
		
		if (  ValidationManager::crearConsulta($nombreConsulta, $sql) ){
			$this->setVariables(null, $nombreConsulta, $sql);
			$usuarioService = ServiceFactory::getUsuarioService();
			$usuario = $usuarioService->findByUserName($nombreUsuario);
			$this->consultaDAO->create( $this->consulta, $usuario);
		}
	}

	public function quiereVer($id, $permiso){
		$this->setVariables($id);
		$permiso->puedeMostrar($this);
	}

	public function mostar(){
        $this->consultaDAO->mostrar( $this->consulta->getId() );
    }

    public function quiereModificar( $idConsulta, $nombre, $nombreActual, $sql, $sqlActual, $permiso ){

    	if( ValidationManager::modificarConsulta( $nombre, $sql ) ){
	        $this->setVariables($idConsulta, $nombreActual, $sqlActual);
	        $this->nombreNuevo = $nombre;
	        $this->sqlNuevo = $sql;
	        $permiso->puedeModificar($this);
    	}
    }

    public function modificar(){
		$this->consultaDAO->modificar( $this->consulta, $this->nombreNuevo, $this->sqlNuevo );
    }

    public function quiereEliminar($idConsulta, $idUsuario, $permiso){
        $this->setVariables( $idConsulta );
        $this->idUsuario = $idUsuario;        
        $permiso->puedeEliminar($this);
    }

    public function eliminar(){
    	$this->consultaDAO->eliminar( $this->idUsuario, $this->consulta );
    }

    public function findById($id){
    	return $this->consultaDAO->findById($id);
    }

    private function setVariables($idConsulta = null, $nombre = null, $sql = null, $idUsuario = null ){
        $this->consulta->setId( $idConsulta );
        $this->consulta->setSql( $sql );
        $this->consulta->setNombre( $nombre );
    }

}

?>