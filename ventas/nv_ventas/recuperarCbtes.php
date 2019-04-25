<?php
  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

	if (isset($_POST['tipo_cbte_post'])){
		$tipoComprobante	 = $_POST['tipo_cbte_post'];
	}
	if (isset($_POST['clase_cbte_post'])){
		$claseComprobante	 = $_POST['clase_cbte_post'];
	}
	if (isset($_POST['numero_cbte_post'])){
		$numeroComprobante = $_POST['numero_cbte_post'];
	}

/*
	$tipoComprobante   = '6';
	$claseComprobante  = 'x';
	$numeroComprobante = '000200037789';
*/

	$modulo = 3;
	$comandoConsultaCbtes = "CONSULTACBTEVTAS(".$tipoComprobante.",".$claseComprobante.",".$numeroComprobante.")";
	$datosCbteConsultado = conexionWS ( $modulo , $comandoConsultaCbtes );
	
	echo json_encode($datosCbteConsultado);

?>