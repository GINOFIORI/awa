<?php

  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");
 	
 	$modulo = 7;

  $comandoGrupos      = "GRUPOS(0)";
  $datosGrupos        = conexionWS ( $modulo , $comandoGrupos ); 

  echo json_encode($datosGrupos);
?>