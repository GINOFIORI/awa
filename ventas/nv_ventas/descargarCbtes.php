<?php

  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS.php");

	$haySolicitud = ( sizeof($_POST) > 0 );

	if ($haySolicitud){

		if (isset($_POST['tipo_cbte_post'])){
			$tipoComprobante	 = $_POST['tipo_cbte_post'];
		}
		if (isset($_POST['clase_cbte_post'])){
			$claseComprobante	 = $_POST['clase_cbte_post'];
		}
		if (isset($_POST['numero_cbte_post'])){
			$numeroComprobante = $_POST['numero_cbte_post'];
		}

		$modulo = 3;

		$comandoConsultaCbtes = "PDFCBTEVTAS(".$tipoComprobante.",".$claseComprobante.",".$numeroComprobante.")";

		$datosCbteConsultado  = conexionWS ( $modulo , $comandoConsultaCbtes );

		echo "path".$datosCbteConsultado->results_row->as_path_download."/path";
	}

?>