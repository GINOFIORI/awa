<?php

	$menu_ventas = array();

	if ( ( $_SESSION["rol"]  == 1 ) or ( $_SESSION["rol"] == 3 ) ){
	 	$menu_ventas['Generación de pedidos'] 				       = './ventas/ventanas/pedidos.php';
		$menu_ventas['Consulta de cuenta corriente'] 	       = './ventas/ventanas/ctaCteClientes.php';
		$menu_ventas['Reporte global de saldos de clientes'] = './ventas/ventanas/reporteSaldosClientes.php';
		$menu_ventas['Reporte de ventas de productos'] 	     = './ventas/ventanas/reporteVentasProductos.php';
		$menu_ventas['Reporte de facturacion y cobranza'] 	 = './ventas/ventanas/reporteFactyCobranza.php';
		$menu_ventas['Histórico de pedidos'] 		             = '';
  }elseif( $_SESSION["rol"] == 2 ) {
		$menu_ventas['Generación de pedidos'] 	     		     = './ventas/ventanas/pedidos.php';
		$menu_ventas['Consulta de cuenta corriente']         = './ventas/ventanas/ctaCteClientes.php';
}



?>

