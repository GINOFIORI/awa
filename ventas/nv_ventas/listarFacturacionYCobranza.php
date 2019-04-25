<?php

  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");
	
	if (isset($_POST['fecha_desde'])){
		$fechaDesde = $_POST['fecha_desde'];
	}

	if (isset($_POST['fecha_hasta'])){
		$fechaHasta = $_POST['fecha_hasta'];
	}
	
	if (isset($_POST['tipo_listado'])){
		$tipoListado = $_POST['tipo_listado'];
	}

	if (isset($_POST['cod_cliente'])){
		$codCliente	 = $_POST['cod_cliente'];
	}
	
	if (isset($_POST['separar_vendedores'])){
		$separaVendedor = $_POST['separar_vendedores'];
	}
	
	if (isset($_POST['codigo_vendedor'])){
		$codVendedor = $_POST['codigo_vendedor'];
	}

	$modulo = 3;

	//$comando = "LISTARFACTCOBRPERIODO(".'2018-01-01'.",".'2018-01-31'.",".'1'.",".'0'.",".'0'.",".'0'.")";

	$comando = "LISTARFACTCOBRPERIODO(".$fechaDesde.",".$fechaHasta.",".$tipoListado.",".$codCliente.",".$separaVendedor.",".$codVendedor.")";

  $resultado = conexionWS ( $modulo , $comando );

	//var_dump($resultado);

	echo json_encode($resultado);

?>