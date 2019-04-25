<?php
	include_once('admin/modelo/config_mdl.php');
	include_once('includes/maestro.php');

	$lista_config = [];

	$alertaErrores = '';

	$lista_config = listarConfiguraciones();

	if ( gettype($lista_config) == 'string' ){
		$alertaErrores = $lista_config;
		$lista_config = [];
	}

	function listarConfiguraciones(){

		// SE RECUPERAN LAS CONFIGURACIONES PARA OBTENER LOS idCliente QUE FIGURAN EN EL DROPDOWN DE "EMPRESA" EN LOS FILTROS DEL LOG

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
				$listado[$key]->PassAdm						= $configuracion->PassAdm;
			}
			return $listado;
		}


	}

	include_once('admin/ventanas/abm_log.php');


?>