<?php

  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");
 	
 	$modulo = 7;
 	
  $comandoFamilias    = "FAMILIAS()";
  $datosFamilias      = conexionWS ( $modulo , $comandoFamilias );      
	echo json_encode($datosFamilias);

?>