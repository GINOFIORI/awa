<?php
  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

	if (isset($_POST['num_tablero'])){
		$numTablero	 = (string)$_POST['num_tablero'];
	}else{
		$numTablero	 = 1;
	}
	
	$modulo = 9999;

	$comandoTableroBI = "PANELBIUSUARIO(" . $numTablero . ")"; 

  $resultado     = conexionWS ( $modulo , $comandoTableroBI );

	echo json_encode($resultado);

?>