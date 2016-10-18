<?php

require_once "factories/modelFactory.php";

class PermisoNullObject{
	
	public function puedeMostrar($consulta){		
		$consulta->sinPermisos();
	}

	public function puedeModificar($consulta){
		$consulta->sinPermisos();
	}
	
	public function puedeEliminar($consulta){
		$consulta->sinPermisos();
	}

	public function modificar($usuarioId, $consultaId, $permiso){
		$permisoModel = ModelFactory::getModel("permiso");
		$permisoModel->givePermission($usuarioId, $consultaId, $permiso);
	}
	
	public function agregarPermiso($permisoService){
		$permisoService->sinPermisos();
	}

	public function crear($permisoService){
		$permisoService->agregar();
	}

	public function quitarPermiso($permisoService){
		$permisoService->sinPermisos();
	}
}

?>