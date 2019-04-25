<?php
  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

	if (isset($_POST['cod_cliente_busca'])){
		$codCliente	 = $_POST['cod_cliente_busca'];
	}else{
		$codCliente = '0';
	}
	if (isset($_POST['nom_cliente_busca'])){
		$nombreCliente	 = $_POST['nom_cliente_busca'];
	}else{
		$nombreCliente = "";
	}

	if ($codCliente != "" && $nombreCliente != ""){
		$codCliente = "";
	}

	$modulo = 3;

	$comandoBuscarCliente = "BUSCARCLIENTES(".$codCliente.",".$nombreCliente.")";
	$clientes   = conexionWS ( $modulo , $comandoBuscarCliente );
	echo json_encode($clientes);

?>