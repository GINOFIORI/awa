<?php


	$_POST['$IdCliente'] = 'malena';
  $_POST['UrlCliente'] = 'http://julian';
  $_POST['ServidorCliente'] = 'Produccion\allways2008';
  $_POST['BDCliente'] = 'malena_srl';
  $_POST['IdEmpCliente'] = '1';
  $_POST['IdSucCliente'] = '1';
  $_POST['CaminoAwaDownload'] = '/awa_ws_root/file/session/_webservice_/c/downloads';
  $_POST['CaminoAwaBR'] = 'E:\primate\awa_br\app';
  $_POST['DescripcionEmp'] = 'MALENA MDQ';
  $_POST['UsuarioAdm'] = 'adm@malena';
  $_POST['PassAdm'] = '123';


  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax_admin.php");

	if (isset($_POST['IdCliente'])){
		$IdCliente	 = (string)$_POST['IdCliente'];
	}
	if (isset($_POST['UrlCliente'])){
		$UrlCliente	 = (string)$_POST['UrlCliente'];
	}
	if (isset($_POST['ServidorCliente'])){
		$ServidorCliente = (string)$_POST['ServidorCliente'];
	}
	if (isset($_POST['BDCliente'])){
		$BDCliente	 = (string)$_POST['BDCliente'];
	}
	if (isset($_POST['IdEmpCliente'])){
		$IdEmpCliente	 = (string)$_POST['IdEmpCliente'];
	}
	if (isset($_POST['IdSucCliente'])){
		$IdSucCliente	 = (string)$_POST['IdSucCliente'];
	}
	if (isset($_POST['CaminoAwaDownload'])){
		$CaminoAwaDownload	 = (string)$_POST['CaminoAwaDownload'];
	}
	if (isset($_POST['CaminoAwaBR'])){
		$CaminoAwaBR	 = (string)$_POST['CaminoAwaBR'];
	}
	if (isset($_POST['DescripcionEmp'])){
		$DescripcionEmp	 = (string)$_POST['DescripcionEmp'];
	}
	

	$IdCliente = 'malena';
  $UrlCliente = 'http://julian';
  $ServidorCliente = 'Produccion\allways2008';
  $BDCliente = 'malena_srl';
  $IdEmpCliente = '1';
  $IdSucCliente = '1';
  $CaminoAwaDownload = '/awa_ws_root/file/session/__webservice__/c/downloads';
  $CaminoAwaBR = 'E:\primate\awa_br\app';
  $DescripcionEmp = 'MALENA MDQ';


	$modulo 		 = 9999;
	/*$comandoTest_2 = "DUMMY(malena,http://julian,Produccionallways2008,malena_srl,1,1,/awa_ws_root/file/session/__webservice__/c/downloads,E:primateawa_brapp,MALENA MDQ)";*/
	$comandoTest = "DUMMY(" . $IdCliente . "," . $UrlCliente . "," . $ServidorCliente . "," . $BDCliente . "," . $IdEmpCliente . "," . $IdSucCliente . "," . $CaminoAwaDownload . "," . $CaminoAwaBR . "," . $DescripcionEmp . ")"; 

	
  $resultado = conexionWS ( $modulo , $comandoTest );

	echo json_encode($resultado);



?>