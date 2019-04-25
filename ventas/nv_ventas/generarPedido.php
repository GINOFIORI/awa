<?php

  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

	if (isset($_POST['cod_cliente'])){
		$codCliente	 = $_POST['cod_cliente'];
	}
	if (isset($_POST['cod_vendedor'])){
		$codVendedor = $_POST['cod_vendedor'];
	}
	if (isset($_POST['leyenda'])){
		$leyenda = $_POST['leyenda'];
	}
	if (isset($_POST['detalle_pedido'])){
		$detallePedido = $_POST['detalle_pedido'];
	}

	$modulo = 3;

	$comandoPedidos = "GENERARNOTAPEDIDO(".$codCliente.",".$codVendedor.",".$leyenda.",".$detallePedido.")";

	$resultado = conexionWS ( $modulo , $comandoPedidos );

	echo json_encode($resultado);

?>