<?php
	include_once('admin/modelo/admin_mdl.php');

	$lista_administradores = [];

	$alertaErrores = '';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (isset($_POST['agregar'])){
			$alertaErrores = agregarAdministrador();
		}

		if (isset($_POST['borrar'])){
			$alertaErrores = borrarAdministrador();
		}

		if (isset($_POST['modificar'])){
			$alertaErrores = modificarAdministrador();
		}

	}

	$lista_administradores = listarAdministradores();

	if ( gettype($lista_administradores) == 'string' ){
		$alertaErrores = $lista_administradores;
		$lista_administradores = [];
	}

	function listarAdministradores(){
		$admin_mdl = new Administradores_mdl;

		$listado = $admin_mdl->listar_administradores();
		$errores = $admin_mdl->get_errores(); 

		if ($errores){
			return $errores;
		}else{
			return $listado;
		}
	}

		function agregarAdministrador(){

		// Validaciones Iniciales ...

		if (trim($_POST['NombreUsuario'])===''){
			return 'El usuario ingresado es inválido.';
		}

		if (trim($_POST['PassUsuario'])===''){
			return 'La contraseña ingresada es inválida.';
		}

		$admin_mdl 		 = new Administradores_mdl;
		$NombreUsuario = $_POST['NombreUsuario'];
		$Nombre 			 = $_POST['Nombre'];
		$Apellido			 = $_POST['Apellido'];
		$PassUsuario	 = password_hash($_POST['PassUsuario'],PASSWORD_DEFAULT);

		$administrador = $admin_mdl->get_admin($NombreUsuario);

		if (($administrador) != null){
			return 'El usuario ingresado ya existe.';
		}else{
			$administrador = new stdClass();
			$administrador->NombreUsuario = $NombreUsuario;
			$administrador->Nombre 				= $Nombre;
			$administrador->Apellido			= $Apellido;
			$administrador->PassUsuario	  = $PassUsuario;
			$admin_mdl->set_admin($administrador);
			return ($admin_mdl->get_errores());
		}
	}

function borrarAdministrador(){
		$admin_mdl 	   = new Administradores_mdl;
		$NombreUsuario = $_POST['NombreUsuario'];
		$administrador = $admin_mdl->del_admin($NombreUsuario);
		return ($admin_mdl->get_errores());
	}

	function modificarAdministrador(){

		// Validaciones Iniciales ...

		if (trim($_POST['NombreUsuario'])===''){
			return 'El usuario ingresado es inválido.';
		}

		if (trim($_POST['PassUsuario'])===''){
			return 'La contraseña ingresada es inválida.';
		}

		$admin_mdl 		 = new Administradores_mdl;
		$NombreUsuario = $_POST['NombreUsuario'];
		$Nombre 			 = $_POST['Nombre'];
		$Apellido			 = $_POST['Apellido'];
		$PassUsuario	 = $_POST['PassUsuario'];

		$admin_mdl 	   = new Administradores_mdl;

		$administrador = $admin_mdl->get_admin($NombreUsuario);

		if (($administrador) == null){
			return 'El usuario ingresado es inválido.';
		}else{

			if ($administrador->PassUsuario!=$PassUsuario){
				$PassUsuario = password_hash($PassUsuario,PASSWORD_DEFAULT);
			}

			$administrador->Nombre 		  = $Nombre;
			$administrador->Apellido    = $Apellido;
			$administrador->PassUsuario = $PassUsuario;
			
			$admin_mdl->update_admin($administrador);
			return ($admin_mdl->get_errores());
		}
	}

	include_once('admin/ventanas/abm_admin.php');

?>