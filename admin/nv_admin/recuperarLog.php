<?php

  session_start();
  include("../../includes/conexionWS_ajax_admin.php");
  
  if (isset($_POST['fecha_desde'])){
		$fechaDesde	 = $_POST['fecha_desde'];
	}

	if (isset($_POST['fecha_hasta'])){
		$fechaHasta = $_POST['fecha_hasta'];
	}
	if (isset($_POST['usuario_busqueda'])){
		$usuarioBusqueda = $_POST['usuario_busqueda'];
	}else{
    $usuarioBusqueda = '';
   }
	
	if (isset($_POST['rol_usuario'])){
		$rolUsuario = $_POST['rol_usuario'];
	}

	$modulo    = 9999;

	$comando   = "RECUPERALOG(".$fechaDesde.",".$fechaHasta.",".$usuarioBusqueda.",".$rolUsuario.")";

	//$comando = "RECUPERALOG(".'01/01/1980'.",".'01/01/2020'.",".''.",".'2'.")";

  $resultado = conexionWS ( $modulo , $comando );

  //var_dump($resultado);

  echo json_encode($resultado);

?>
