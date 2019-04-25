<?php
	error_reporting(E_ALL ^ E_NOTICE);
  // CONEXIÓN A BD DESDE DON WEB ///////////////////////////////////////// 
  //if(!($link=mysqli_connect("localhost","nc000361_adm","Sl13336a"))) //
	if(!($link=mysqli_connect("127.0.0.1","root","")))
	{
		$link=null;
	}
        // CONEXIÓN A BD DESDE DON WEB //////////////////
	//if(!mysqli_select_db($link,"nc000361_awa"))//
	if(!mysqli_select_db($link,"awa"))
	{
		$link=null;
	}
?>

