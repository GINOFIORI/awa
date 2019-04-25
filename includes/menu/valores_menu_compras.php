<?php

	$menu_compras = array();
	
	 if ( $_SESSION["rol"] == 1 ){ 

	$menu_compras['Generaci&oacute;n de orden de compra']	  	= '';
	$menu_compras['Consulta de cuenta corriente proveedores']	= '';
	$menu_compras['Reporte global de saldos de proveedores'] 	= '';
	$menu_compras['Reporte de compras de productos'] 			    = '';
	$menu_compras['Reporte de compras y pagos'] 				      = '';

	}elseif ($_SESSION["rol"] == 4) {

	$menu_compras['Consulta de cuenta corriente proveedores']	= '';

	}

  
?>

