<?php

require_once("maestro.php");

session_start();

/*
$maestro  = new Maestro();

if (!($maestro->validarDisponibilidad())) {
	echo '<script type="text/javascript"> alert("Cuenta temporalmente inhabilitada.");</script>';
	header("Location: '../../../../cerrar_sesion.php'");
  //return simplexml_load_string($mensaje);
  die();
}
*/

if (!array_key_exists("datosLogin", $_SESSION)) {
	echo '<script>window.top.location.href="index.php";</script>';
}elseif(isset ( $_SESSION["admin"] )){
	echo '<script>window.top.location.href="admin.php";</script>';
}

?>
