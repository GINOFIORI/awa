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

  $maestro = Maestro::instanciar($_SESSION['Llave']);

  if ( ( ! isset ( $_SESSION ) ) ) {
      session_start();
  }

  $ipVisitante = getRealIP();

  try {
      $client = new SoapClient ( $_SESSION["UrlCliente"] . "/awa_ws/n_awa_ws.asmx?WSDL" );
  } catch (Exception $e) {
    $mensaje_id   = -1;
    $mensaje_info = '<b>Advertencia:</b></br>No se pudo establecer la conexión con el servidor del cliente (1).';
    $info         = [$mensaje_id,$mensaje_info];
    return $info;
    die();
  }

  try {
      $client->__setLocation ( $_SESSION["UrlCliente"] . "/awa_ws/n_awa_ws.asmx" );
  } catch (Exception $e) {
    $mensaje_id   = -1;
    $mensaje_info = '<b>Advertencia:</b></br>No se pudo establecer la conexión con el servidor del cliente (2).';
    $info         = [$mensaje_id,$mensaje_info];
    return $info;
    die();
  }

  $params  = array( 'an_prueba_consola'=>0,
                    'an_loguea_parametros'=>1,
                    'as_ip_visitante'=>$maestro->EncryptDecryptDesp($ipVisitante,1),
                    'as_url_servidor_ws'=>$maestro->EncryptDecryptDesp($_SESSION["UrlCliente"],1),
                    'as_camino_awa_dl'=>$maestro->EncryptDecryptDesp($_SESSION["CaminoAwaDownload"],1),
                    'as_camino_awa_br'=>$maestro->EncryptDecryptDesp($_SESSION["caminoAwaBR"], 1),
                    'an_rol_login'=>$_SESSION["rol"],
                    'as_usuario_login'=>$maestro->EncryptDecryptDesp($_SESSION["IdLogin"],1),
                    'as_pass_login'=>$maestro->EncryptDecryptDesp($_SESSION["pass"],1),
                    'as_servidor_cliente'=>$maestro->EncryptDecryptDesp($_SESSION["ServidorCliente"], 1),
                    'as_bd_cliente'=>$maestro->EncryptDecryptDesp($_SESSION["BDCliente"], 1),
                    'an_empresa_cliente'=>$_SESSION["IdEmpCliente"],
                    'an_sucursal_cliente'=>$_SESSION["IdSucCliente"],
                    'as_usuario_adm'=>$maestro->EncryptDecryptDesp($_SESSION['UsuarioAdm'],1),
                    'as_pass_adm'=>$maestro->EncryptDecryptDesp($_SESSION['PassAdm'],1),
                    'an_modulo'=>$modulo,
                    'as_comando'=>$maestro->EncryptDecryptDesp($comando,1)) ;

  try {
      $result = $client->nvf_enviacomando($params)->nvf_enviacomandoResult;
  }catch(Exception $e){

    ob_start();
    var_dump($params);
    $detalleComando = ob_get_clean();

    $mensaje_id   = -1;
    $mensaje_info = '<b>Advertencia:</b></br>Falla en funci&oacute;n "conexionWS"</br>Comando: '. $detalleComando;
    $info         = [$mensaje_id,$mensaje_info];

    return $info;

    die();

  }

  $xml = simplexml_load_string($result);

  $xml = $maestro->desencriptarXML($xml);

  foreach ($xml->results_row as $recorre){
    $mensaje_error = (string) ($recorre->as_error_msg);
    $mensaje_info  = (string) ($recorre->as_return_msg);
    $mensaje_id    = (integer) ($recorre->an_mensaje_id);
    if ($mensaje_error){
      $mensaje_id   = -1;
      $mensaje_info = '<b>Advertencia:</b></br>'. $mensaje_error . '</br>Falla en funci&oacute;n "conexionWS"';
      $info         = [$mensaje_id,$mensaje_info];
      return $info;
      die();
    }elseif ($mensaje_info){
      $info = [$mensaje_id,$mensaje_info];
      return $info;
    }else{
      return $xml ;
    }
  }

}

    
?>