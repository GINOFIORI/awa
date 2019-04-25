<?php

  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

  	if (isset($_POST['cod_cliente'])){
		$codCliente	 = $_POST['cod_cliente'];
	}

	if (isset($_POST['fecha_ref'])){
		$fechaRef = $_POST['fecha_ref'];
	}
	if (isset($_POST['tipo_listado'])){
		$tipoListado = $_POST['tipo_listado'];
	}
	
	if (isset($_POST['tipo_orden'])){
		$tipoOrden = $_POST['tipo_orden'];
	}
	if (isset($_POST['tipo_saldos'])){
		$tipoSaldos = $_POST['tipo_saldos'];
	}
	
	if (isset($_POST['separar_vendedores'])){
		$separaVendedor = $_POST['separar_vendedores'];
	}
	if (isset($_POST['codigo_vendedor'])){
		$codVendedor = $_POST['codigo_vendedor'];
	}

	$modulo = 3;

	$comandoSaldosCli = "LISTADOSALDOSCLIENTES(".$fechaRef.",".$tipoListado.",".$tipoOrden.",".$tipoSaldos.",".$codCliente.",".$separaVendedor.",".$codVendedor.")";

	//$comandoSaldosCli = "LISTADOSALDOSCLIENTES(".'2018-02-28'.",".'3'.",".'1'.",".'1'.",".'0'.",".'0'.",".'0'.")";
	
	$resultado = conexionWS ( $modulo , $comandoSaldosCli );

	//var_dump($resultado);

	echo json_encode($resultado);

?>