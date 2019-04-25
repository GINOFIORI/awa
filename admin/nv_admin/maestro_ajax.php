<?php

	include("../../includes/maestro.php");

	$maestro = new Maestro();


	if (isset($_POST['cadena'])){
		$cadena = $_POST['cadena'];
	}else{
		$cadena = 'cGR79enImr+qJZ5z0zPRBNKsbqM5ipfLR05C+gMGyGs=';
	}
	if (isset($_POST['llave'])){
		$llave  = $_POST['llave'];
	}else{
		$llave='malena';
	}

	echo ( $maestro->desencriptar($cadena,$llave) );

?>