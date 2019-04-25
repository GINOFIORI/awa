<?php
  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

	if (isset($_POST['cod_cliente'])){
		$codCliente	 = (string)$_POST['cod_cliente'];
	}

	$modulo = 3;

	$comandoCliente = "CLIENTE(".$codCliente.")";
  $datosCliente   = conexionWS ( $modulo , $comandoCliente );
	echo json_encode($datosCliente);
?>