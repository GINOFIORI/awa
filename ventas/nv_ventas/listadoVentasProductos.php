<?php

  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

	if (isset($_POST['cod_cliente'])){
		$codCliente	 = $_POST['cod_cliente'];
	}
	
	if (isset($_POST['fecha_desde'])){
		$fechaDesde = $_POST['fecha_desde'];
	}

	if (isset($_POST['fecha_hasta'])){
		$fechaHasta = $_POST['fecha_hasta'];
	}
	
	if (isset($_POST['tipo_corte'])){
		$tipoCorte = $_POST['tipo_corte'];
	}
	
	if (isset($_POST['separar_vendedores'])){
		$separaVendedor = $_POST['separar_vendedores'];
	}
	if (isset($_POST['codigo_vendedor'])){
		$codVendedor = $_POST['codigo_vendedor'];
	}

	$modulo = 3;

	$comandoVentasFGA = "LISTARVENTASFGA(".$fechaDesde.",".$fechaHasta.",".$tipoCorte.",".$codCliente.",".$separaVendedor.",".$codVendedor.")";

	//$comandoVentasFGA = "LISTARVENTASFGA(".'2018-01-01'.",".'2018-01-31'.",".'1'.",".'0'.",".'0'.",".'0'.")";

  $resultado = conexionWS ( $modulo , $comandoVentasFGA );

	//var_dump($resultado);

	echo json_encode($resultado);

?>