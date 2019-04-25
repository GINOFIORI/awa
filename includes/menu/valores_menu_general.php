<?php

	$menu_general = array();
	if ( ( $_SESSION["rol"]  == 1 ) or ( $_SESSION["rol"] == 3 ) ){
		$menu_general['Consulta de cat&aacute;logo de art&iacute;culos'] = './comercial/ventanas/catalogoArticulos.php';
		$menu_general['Consulta de Tableros de BI'] = './comercial/ventanas/tablerosBI.php';
	}elseif( $_SESSION["rol"] == 2 ) {
		$menu_general['Consulta de cat&aacute;logo de art&iacute;culos'] = './comercial/ventanas/catalogoArticulos.php';
	}
	
?>

