<?php
	include_once('admin/modelo/config_mdl.php');
	include_once('includes/maestro.php');

	$lista_config = [];

	$alertaErrores = '';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (isset($_POST['agregar'])){
			$alertaErrores = agregar();
		}

		if (isset($_POST['borrar'])){
			$alertaErrores = borrar();
		}

		if (isset($_POST['modificar'])){
			$alertaErrores = modificar();
		}

	}

	$lista_config = listarConfiguraciones();

	if ( gettype($lista_config) == 'string' ){
		$alertaErrores = $lista_config;
		$lista_config = [];
	}

	function listarConfiguraciones(){
		$config_mdl = new Configuraciones_mdl;

		$listado = $config_mdl->listar_configuraciones();
		$errores = $config_mdl->get_errores(); 

		if ($errores){
			return $errores;
		}else{
			foreach ($listado as $key => $configuracion) {
				$maestro = Maestro::instanciar();
				$listado[$key]->UrlCliente 				= $maestro->desencriptar($configuracion->UrlCliente,$configuracion->IdCliente);
				$listado[$key]->ServidorCliente		= $maestro->desencriptar($configuracion->ServidorCliente,$configuracion->IdCliente);
				$listado[$key]->BDCliente			  	= $maestro->desencriptar($configuracion->BDCliente,$configuracion->IdCliente);
				$listado[$key]->CaminoAwaDownload	= $maestro->desencriptar($configuracion->CaminoAwaDownload,$configuracion->IdCliente);
				$listado[$key]->CaminoAwaBR				= $maestro->desencriptar($configuracion->CaminoAwaBR,$configuracion->IdCliente);
				$listado[$key]->UsuarioAdm				= $maestro->desencriptar($configuracion->UsuarioAdm,$configuracion->IdCliente);
				$listado[$key]->Llave							= $maestro->desencriptar($configuracion->Llave,$configuracion->IdCliente);
				$listado[$key]->PassAdm						= $configuracion->PassAdm;
			}
			return $listado;
		}


	}

	function agregar(){

		$config_mdl 			= new Configuraciones_mdl;
		$IdCliente 				= $_POST['IdCliente'];
		$UrlCliente		 		= $_POST['UrlCliente'];
		$ServidorCliente	= $_POST['ServidorCliente'];
		$BDCliente				= $_POST['BDCliente'];
		$IdEmpCliente			= $_POST['IdEmpCliente'];
		$IdSucCliente			= $_POST['IdSucCliente'];
		$CaminoAwaDownload= $_POST['CaminoAwaDownload'];
		$CaminoAwaBR			= $_POST['CaminoAwaBR'];
		$DescripcionEmp		= $_POST['DescripcionEmp'];
		$UsuarioAdm				= $_POST['UsuarioAdm'];
		$PassAdm	 				= $_POST['PassAdm'];
		$Disponible				= $_POST['Disponible'];
		$Llave					  = $_POST['Llave'];

		$configuracion    = $config_mdl->get_config($IdCliente);

		if (($configuracion) != null){
			return 'El ID ya se encuentra registrado.';
		}else{
			$maestro = Maestro::instanciar();
			$configuracion = new stdClass();
			$configuracion->IdCliente 				= $IdCliente;
			$configuracion->UrlCliente 				= $maestro->encriptar($UrlCliente,$IdCliente);
			$configuracion->ServidorCliente		= $maestro->encriptar($ServidorCliente,$IdCliente);
			$configuracion->BDCliente			  	= $maestro->encriptar($BDCliente,$IdCliente);
			$configuracion->IdEmpCliente			= $IdEmpCliente;
			$configuracion->IdSucCliente			= $IdSucCliente;
			$configuracion->CaminoAwaDownload	= $maestro->encriptar($CaminoAwaDownload,$IdCliente);
			$configuracion->CaminoAwaBR				= $maestro->encriptar($CaminoAwaBR,$IdCliente);
			$configuracion->DescripcionEmp		= $DescripcionEmp;
			$configuracion->UsuarioAdm				= $maestro->encriptar($UsuarioAdm,$IdCliente);
			$configuracion->PassAdm						= $maestro->encriptar($PassAdm,$IdCliente);
			$configuracion->Llave							= $maestro->encriptar($Llave,$IdCliente);
			$configuracion->Disponible				= $Disponible;

			$config_mdl->set_config($configuracion);
			return ($config_mdl->get_errores());
		}
	}

	function borrar(){
		$config_mdl    = new Configuraciones_mdl;
		$IdCliente 		 = $_POST['IdCliente'];
		$administrador = $config_mdl->del_config($IdCliente);
		return ($config_mdl->get_errores());
	}

	function modificar(){
		$config_mdl 			= new Configuraciones_mdl;
		$IdCliente 				= $_POST['IdCliente'];
		$UrlCliente		 		= $_POST['UrlCliente'];
		$ServidorCliente	= $_POST['ServidorCliente'];
		$BDCliente				= $_POST['BDCliente'];
		$IdEmpCliente			= $_POST['IdEmpCliente'];
		$IdSucCliente			= $_POST['IdSucCliente'];
		$CaminoAwaDownload= $_POST['CaminoAwaDownload'];
		$CaminoAwaBR			= $_POST['CaminoAwaBR'];
		$DescripcionEmp		= $_POST['DescripcionEmp'];
		$UsuarioAdm				= $_POST['UsuarioAdm'];
		$PassAdm	 				= $_POST['PassAdm'];
		$Disponible				= $_POST['Disponible'];
		$Llave					  = $_POST['Llave'];
		if (is_null($Disponible)){
			$Disponible = 0;
		}

		$configuracion    = $config_mdl->get_config($IdCliente);

		if (($configuracion) == null){
			return 'El ID del cliente no se encuentra en la base de datos';
		}else{

			$maestro = Maestro::instanciar();
			
			$configuracion->UrlCliente 				= $maestro->encriptar($UrlCliente,$IdCliente);
			$configuracion->ServidorCliente		= $maestro->encriptar($ServidorCliente,$IdCliente);
			$configuracion->BDCliente			  	= $maestro->encriptar($BDCliente,$IdCliente);
			$configuracion->IdEmpCliente			= $IdEmpCliente;
			$configuracion->IdSucCliente			= $IdSucCliente;
			$configuracion->CaminoAwaDownload	= $maestro->encriptar($CaminoAwaDownload,$IdCliente);
			$configuracion->CaminoAwaBR				= $maestro->encriptar($CaminoAwaBR,$IdCliente);
			$configuracion->DescripcionEmp		= $DescripcionEmp;
			$configuracion->UsuarioAdm				= $maestro->encriptar($UsuarioAdm,$IdCliente);
			$configuracion->Llave							= $maestro->encriptar($Llave,$IdCliente);
			
			// encriptar contraseña solo si es distinta a la actual ...
			if($configuracion->PassAdm!==$PassAdm){
				$configuracion->PassAdm	= $maestro->encriptar($PassAdm,$IdCliente);
			}
			$configuracion->Disponible				= $Disponible;

			$config_mdl->update_config($configuracion);
			return ($config_mdl->get_errores());
		}
	}

	include_once('admin/ventanas/abm_awaconfig.php');

?>