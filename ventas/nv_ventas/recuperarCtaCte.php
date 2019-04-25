<?php
  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

	if (isset($_POST['cod_cliente'])){
		$codCliente	 = (string)$_POST['cod_cliente'];
	}else{
		$codCliente = '';
	}
	if (isset($_POST['fecha_desde'])){
		$fechaDesde	 = date_create((string)$_POST['fecha_desde']);
	}else{
		$fechaDesde = date_create('2016/01/01');
	}
	if (isset($_POST['fecha_hasta'])){
		$fechaHasta	 = date_create((string)$_POST['fecha_hasta']);
	}else{
		$fechaHasta = date_create('2019/01/01');
	}
	if (isset($_POST['orden'])){
		$orden	 = (string)$_POST['orden'];
	}else{
		$orden = 1;
	}
	if (isset($_POST['excl_anul'])){
		$exclAnulados	 = (string)$_POST['excl_anul'];
	}else{
		$exclAnulados	 = 1;
	}
	if (isset($_POST['excl_cancel'])){
		$exclCancelados	 = (string)$_POST['excl_cancel'];
	}else{
		$exclCancelados	 = 1;
	}
	
	$modulo = 3;
	$comandoCtaCte = "CTACTECLI(" . $codCliente . "," . $orden . "," . date_format( $fechaDesde , "d/m/Y" ) . "," . date_format ( $fechaHasta , "d/m/Y" ) . "," . $exclAnulados . "," . $exclCancelados . ")"; 

  $resultado     = conexionWS ( $modulo , $comandoCtaCte );

	echo json_encode($resultado);
?>