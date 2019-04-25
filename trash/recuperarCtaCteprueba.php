<?php

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

		$ipVisitante = getRealIP();

		try{
			$client 	 	 = new SoapClient ( $_SESSION['UrlCliente'] . "/awa_ws/n_awa_ws.asmx?WSDL" );
		}catch(Exception $e){
			$mensaje = '<?xml version="1.0" encoding="UTF-8"?> <results> <results_row> <an_error_id>0</an_error_id> <as_error_msg>Error en la conexión con el Web Service. Verifique la disponibilidad del servidor del cliente.</as_error_msg> </results_row> </results>';
	    return simplexml_load_string($mensaje);
	    die();
		}

		$params 	 	 = array( 'an_loguea_parametros'=>1,
		                      'as_ip_visitante'=>$ipVisitante,
		                      'as_url_servidor_ws'=>$_SESSION["UrlCliente"],
		                      'as_camino_awa_dl'=>$_SESSION["CaminoAwaDownload"],
		                      'as_camino_awa_br'=>$_SESSION["caminoAwaBR"], 
		                      'an_rol_login'=>$_SESSION["rol"], 
		                      'as_usuario_login'=>$_SESSION["IdLogin"],
		                      'as_pass_login'=>$_SESSION["pass"],
		                      'as_servidor_cliente'=>$_SESSION["ServidorCliente"], 
		                      'as_bd_cliente'=>$_SESSION["BDCliente"], 
		                      'an_empresa_cliente'=>$_SESSION["IdEmpCliente"], 
		                      'an_sucursal_cliente'=>$_SESSION["IdSucCliente"], 
		                      'an_modulo'=>$modulo, 
		                      'as_comando'=>$comando) ;

		try {
		  $result = $client->nvf_enviacomando($params)->nvf_enviacomandoResult;
		}catch(Exception $e){
			$mensaje = '<?xml version="1.0" encoding="UTF-8"?> <results> <results_row> <an_error_id>0</an_error_id> <as_error_msg>Error en la ejecución del Web Service.</as_error_msg> </results_row> </results>';
		  return simplexml_load_string($mensaje);
		  die();
		}


		return ($result);

	}


  include("../includes/iniciar_sesion.php");

  // inicializar variables ...

  $codCliente = '100';
  $fechaDesde = date_create('2000-01-01');
  $fechaHasta = date_create('2017-11-01');
  $orden = '1';
  $exclAnulados = '0';
  $exclCancelados = '0';

	if (isset($_POST['cod_cliente'])){
		$codCliente	 = (string)$_POST['cod_cliente'];
	}
	if (isset($_POST['fecha_desde'])){
		$fechaDesde	 = date_create((string)$_POST['fecha_desde']);
	}
	if (isset($_POST['fecha_hasta'])){
		$fechaHasta	 = date_create((string)$_POST['fecha_hasta']);
	}
	if (isset($_POST['orden'])){
		$orden	 = (string)$_POST['orden'];
	}
	if (isset($_POST['excl_anul'])){
		$exclAnulados	 = (string)$_POST['excl_anul'];
	}
	if (isset($_POST['excl_cancel'])){
		$exclCancelados	 = (string)$_POST['excl_cancel'];
	}
	
	$modulo = 3;

	//$comandoCtaCte = "CTACTECLI(" . $codCliente . "," . $orden . "," . date_format ( $fechaDesde , "d/m/Y" ) . "," . date_format ( $fechaHasta , "d/m/Y" ) . "," . $exclAnulados . "," . $exclCancelados . ")"; 
	//$comandoCtaCte = "CLIENTE(100)";
	$comandoCtaCte = 'LISTADOSALDOSCLIENTES(2018-09-28,3,1,1,0,0,0)';

  $resultado     = conexionWS ( $modulo , $comandoCtaCte ); 
  
  echo ($resultado);
  

/*


$plaintext = 'My secret message 1234';
$password = '3sc3RLrpd17';
$method = 'aes-256-cbc';

// Must be exact 32 chars (256 bit)
$password = substr(hash('sha256', $password, true), 0, 32);
echo "Password:" . $password . "\n";

// IV must be exact 16 chars (128 bit)
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));

// My secret message 1234
$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $password, OPENSSL_RAW_DATA, $iv);

echo 'plaintext=' . $plaintext . "\n";
echo 'cipher=' . $method . "\n";
echo 'encrypted to: ' . $encrypted . "\n";
echo 'decrypted to: ' . $decrypted . "\n\n";
*/
?>
