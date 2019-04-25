<?php
  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

	if (isset($_POST['cod_vendedor'])){
		$codVendedor	 = $_POST['cod_vendedor'];
	}else{
		$codVendedor = 0;
	}

	$modulo = 3;

	$comandoBuscarVendedor = "VENDEDORES(".$codVendedor.")";
	$vendedores   = conexionWS ( $modulo , $comandoBuscarVendedor );

	echo json_encode($vendedores);

?>