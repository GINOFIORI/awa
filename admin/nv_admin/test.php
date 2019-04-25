<?php

  session_start();
  include("../../includes/conexionWS_ajax_admin.php");

	$modulo 		 = 9999;
	
	$comandoTest = 'DUMMY()';
	
  $resultado = conexionWS ( $modulo , $comandoTest );

	echo json_encode($resultado);

?>