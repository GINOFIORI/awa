<?php

  include ("valores_menu_ventas.php");
  include ("valores_menu_compras.php");
  include ("valores_menu_stock.php");
  include ("valores_menu_fondos.php");
  include ("valores_menu_contabilidad.php");
  include ("valores_menu_general.php");

  $menu_principal = array();

  if ( $_SESSION["rol"] == 1 ){

    $menu_principal['Ventas'] 	  					          = $menu_ventas;
    $menu_principal['Compras'] 	 					            = $menu_compras;
    $menu_principal['Gesti&oacute;n de Existencias']  = $menu_stock;
    $menu_principal['Fondos'] 	  					          = $menu_fondos;
    $menu_principal['Contabilidad']                   = $menu_contab;
    $menu_principal['Generales']                      = $menu_general;

  }elseif( $_SESSION["rol"] == 2 ) {

    $menu_principal['Ventas']                         = $menu_ventas;
    $menu_principal['Generales']                      = $menu_general;

  }elseif ($_SESSION["rol"] == 3) {

    $menu_principal['Ventas']                         = $menu_ventas;
    $menu_principal['Generales']                      = $menu_general;

  }elseif ($_SESSION["rol"] == 4) {

    $menu_principal['Compras']                        = $menu_compras;

  }


  $menu_principal_iconos = array();
  
  $menu_principal_iconos['Ventas']                         = "fa fa-credit-card fa-lg";
  $menu_principal_iconos['Compras']                        = "fa fa-cart-arrow-down fa-lg";
  $menu_principal_iconos['Gesti&oacute;n de Existencias']  = "fa fa-line-chart fa-lg";
  $menu_principal_iconos['Fondos']                         = "fa fa-money fa-lg";
  $menu_principal_iconos['Contabilidad']                   = "fa fa-calculator fa-lg";
  $menu_principal_iconos['Generales']                      = "fa fa-puzzle-piece fa-lg";

?>

