<?php

include_once('maestro.php');

function getRealIP(){

  if (isset($_SERVER["HTTP_CLIENT_IP"]))
  {
      return $_SERVER["HTTP_CLIENT_IP"];
  }
  elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
  {
      return $_SERVER["HTTP_X_FORWARDED_FOR"];
  }
  elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
  {
      return $_SERVER["HTTP_X_FORWARDED"];
  }
  elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
  {
      return $_SERVER["HTTP_FORWARDED_FOR"];
  }
  elseif (isset($_SERVER["HTTP_FORWARDED"]))
  {
      return $_SERVER["HTTP_FORWARDED"];
  }
  else
  {
      return $_SERVER["REMOTE_ADDR"];
  }
  
}

function conexionWS ($modulo, $comando){

	include_once('conexionBD.php');

	$ipVisitante = getRealIP();

	$consulta = "Select * from awa_config where IdCliente = '" . $_POST["IdCliente"] . "'";

	$result   = mysqli_query($link,$consulta);

	if ( mysqli_num_rows($result) != 1 ) {
		$mensaje = '<?xml version="1.0" encoding="UTF-8"?> <results> <results_row> <an_error_id>0</an_error_id> <as_error_msg> ERROR EN LA SELECT </as_error_msg> <as_error_msg_js> ERROR EN LA SELECT: ' . $consulta . ' </as_error_msg_js></results_row> </results>';
    return simplexml_load_string($mensaje);
    die();
	}

	$fila     = mysqli_fetch_array($result);

	$maestro  = Maestro::instanciar();

	$llave    = $maestro->desencriptar ( $fila['Llave'] , $fila['IdCliente'] );

	$maestro->setLLave($llave);

	try{
		$client = new SoapClient ( $_POST['UrlCliente'] . "/awa_ws/n_awa_ws.asmx?WSDL" );
	}catch(Exception $e){
		$mensaje = '<?xml version="1.0" encoding="UTF-8"?> <results> <results_row> <an_error_id>0</an_error_id> <as_error_msg>Error en la conexión con el Web Service. Verifique la disponibilidad del servidor del cliente (1).</as_error_msg> <as_error_msg_js>Error en la conexión con el Web Service. Verifique la disponibilidad del servidor del cliente (1).</as_error_msg_js> </results_row> </results>';
        return simplexml_load_string($mensaje);
        die();
    }
    
    try{
		$client->__setLocation ( $_POST['UrlCliente'] . "/awa_ws/n_awa_ws.asmx" );
	}catch(Exception $e){
		$mensaje = '<?xml version="1.0" encoding="UTF-8"?> <results> <results_row> <an_error_id>0</an_error_id> <as_error_msg>Error en la conexión con el Web Service. Verifique la disponibilidad del servidor del cliente (2).</as_error_msg> <as_error_msg_js>Error en la conexión con el Web Service. Verifique la disponibilidad del servidor del cliente (2).</as_error_msg_js> </results_row> </results>';
        return simplexml_load_string($mensaje);
        die();
    }    
	
	$params  = array( 'an_prueba_consola'=>0,
             		  'an_loguea_parametros'=>1,
	                  'as_ip_visitante'=>$maestro->EncryptDecryptDesp($ipVisitante,1),
                      'as_url_servidor_ws'=>$maestro->EncryptDecryptDesp($_POST["UrlCliente"],1),
                      'as_camino_awa_dl'=>$maestro->EncryptDecryptDesp($_POST["CaminoAwaDownload"],1),
                      'as_camino_awa_br'=>$maestro->EncryptDecryptDesp($_POST["CaminoAwaBR"], 1),
                      'an_rol_login'=>'1', 
                      'as_usuario_login'=>$maestro->EncryptDecryptDesp($_POST["UsuarioAdm"],1),
                      'as_pass_login'=>$maestro->EncryptDecryptDesp($maestro->desencriptar($_POST["PassAdm"],$_POST["IdCliente"]),1),
                      'as_servidor_cliente'=>$maestro->EncryptDecryptDesp($_POST["ServidorCliente"], 1),
                      'as_bd_cliente'=>$maestro->EncryptDecryptDesp($_POST["BDCliente"], 1),
                      'an_empresa_cliente'=>$_POST["IdEmpCliente"], 
                      'an_sucursal_cliente'=>$_POST["IdSucCliente"], 
                      'as_usuario_adm'=>$maestro->EncryptDecryptDesp($_POST["UsuarioAdm"],1),
                      'as_pass_adm'=>$maestro->EncryptDecryptDesp($maestro->desencriptar($_POST["PassAdm"],$_POST["IdCliente"]),1),
                      'an_modulo'=>$modulo, 
                      'as_comando'=>$maestro->EncryptDecryptDesp($comando,1));

	try {
	  $result = $client->nvf_enviacomando($params)->nvf_enviacomandoResult;
	}catch(Exception $e){
		$mensaje = '<?xml version="1.0" encoding="UTF-8"?> <results> <results_row> <an_error_id>0</an_error_id> <as_error_msg>Error en la ejecución del Web Service.</as_error_msg> <as_error_msg_js>Error en la ejecución del Web Service.</as_error_msg_js> </results_row> </results>';
        return simplexml_load_string($mensaje);
        die();
	}

	$result  = simplexml_load_string($result);

	$result  = $maestro->desencriptarXML($result);

	return $result;
}

?>