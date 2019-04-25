<?php

 session_start();

 include("../../includes/conexionWS_ajax_admin.php");

   if (isset($_POST['awaId'])){
		$awaId	 = $_POST['awaId'];
	}

	if (isset($_POST['IpVisitante'])){
		$IpVisitante = $_POST['IpVisitante'];
	}
	if (isset($_POST['fechaHoraLog'])){
		$fechaHoraLog = $_POST['fechaHoraLog'];
	}
	
	if (isset($_POST['comandoInfo'])){
		$comandoInfo = $_POST['comandoInfo'];
	}

	$modulo    = 9999;

	$comando   = "RECUPERAINFOLOG(".$awaId.",".$IpVisitante.",".$fechaHoraLog.",".$comandoInfo.")";

	//$comando   = "RECUPERAINFOLOG(".'46944876'.",".'192.168.0.182'.",".'2018-10-24 15:18:46.367'.",".'2'.")";

  $resultado = conexionWS ( $modulo , $comando );

  //($resultado);

  echo json_encode($resultado);

?>