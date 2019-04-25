<?php

class Maestro{

	private $key_constant = 'sl13336.a';
	private $key_ws;
	private static $instancia;

  private function __construct(){
  	// declarar el constructor privado para que sea un SINGLETON
  }

	public static function instanciar($llave = ""){
    if (!isset(self::$instancia)) {
      self::$instancia = new Maestro();
    }
    self::$instancia->setLlave($llave);
    return self::$instancia;
	}

  function validarDisponibilidad () {

  	include_once('../../admin/modelo/config_mdl.php');

  	$config_mdl 			= new Configuraciones_mdl;
  	$configuracion    = $config_mdl->get_config($_SESSION["IdCliente"]);

  	if ( $configuracion->Disponible == 1 ) {
  		return (true);
  	}else{
  		return (false);
  	}  	

  }

  function setLlave($llave){
  	$this->key_ws = $llave;
  }

	function encriptar ($cadena,$llave) {
		if (empty($cadena)||empty($llave)){
			return '';
		}else{
			$llave  = md5($llave . $this->key_constant);
			$cadena = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $llave, $cadena, MCRYPT_MODE_ECB)));
			return($cadena);	
		}
	}

	function desencriptar ($cadena,$llave) {
		if (empty($cadena)||empty($llave)){
			return '';
		}else{
			$llave  = md5($llave . $this->key_constant);
			$cadena = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $llave, base64_decode($cadena), MCRYPT_MODE_ECB));
			return($cadena);
		}
	}

	function EncryptDecryptDesp ($mensaje,$encripta_decripta) {

		$retorno  = '';
		$pos_key  = -1;

		// recorrer mensaje recibido para encriptar por algoritmo de desplazamiento ...

		for ($recorre=0; $recorre < strlen($mensaje) ; $recorre++) { 

			// analizar caracter ...

			$caracter 	  = substr ( $mensaje , $recorre , 1 );
			$caracterASCI = ord($caracter);

			// determinar si corresponde encriptar (sólo números o letras)

			if ( ( $caracterASCI >= 48 && $caracterASCI <= 57  ) || 
					 ( $caracterASCI >= 65 && $caracterASCI <= 90  ) || 
					 ( $caracterASCI >= 97 && $caracterASCI <= 122 ) ){

				// avanzar en la pos_key ...

				if ( $pos_key == ( strlen ($this->key_ws ) ) - 1 ) {
					$pos_key = 0;
				} else {
					$pos_key ++;
				}

				$indice_key = intval ( substr ($this->key_ws, $pos_key , 1 ) );

				// determinar topes según caracter analizado ...

				switch (true) {
					case ($caracterASCI >= 48 && $caracterASCI <= 57):
						# numeros ...
						$inicio_cadena  = 48;
						$tope_cadena    = 57;
						$cant_elementos = 10;
						break;
					case ($caracterASCI >= 65 && $caracterASCI <= 90):
						# letras mayúsculas ...																			
						$inicio_cadena  = 65;
						$tope_cadena    = 90;
						$cant_elementos = 26;
						break;
					case ($caracterASCI >= 97 && $caracterASCI <= 122):
						# letras minúsculas ...																			
						$inicio_cadena  = 97;
						$tope_cadena    = 122;
						$cant_elementos = 26;
						break;
				}

				if ($encripta_decripta==1){
					if ($caracterASCI + $indice_key > $tope_cadena){ 
						$indice_key = $caracterASCI + $indice_key - $cant_elementos;
						$caracter   = chr($indice_key);
					}else{
						$caracter   = chr($caracterASCI + $indice_key);
					}
				}else{
					if ( $caracterASCI - $indice_key < $inicio_cadena ){
						$indice_key = $caracterASCI - $indice_key + $cant_elementos;
						$caracter   = chr($indice_key);
					}else{
						$caracter   = chr($caracterASCI - $indice_key);
					}
				}

			}

			// sumar caracter para devolver ...																			
	
			$retorno = $retorno . $caracter;

		}

		return $retorno;

	}

	function desencriptarXML($xml){
			$nro_fila = 0;

			foreach ($xml as $fila ) {

				foreach ($fila as $columna) {				
					$etiqueta = $columna->getName();
					$find     = 'awa_encr_';
					$pos      = strpos( $etiqueta , $find );
					$nuevaEtiqueta = substr($etiqueta,9);

					if ( $pos !== false ){

						$nuevoValor = $this->EncryptDecryptDesp($xml->results_row[$nro_fila]->$etiqueta,2);

						if (!is_numeric($nuevoValor)) {
							// BUSCAR ACENTOS SOLO EN VALORES NO NUMÉRICOS...
							$nuevoValor = $this->reemplazaCaracteresEspeciales($nuevoValor);
						}

						$nuevoValor = htmlspecialchars($nuevoValor);
						$xml->results_row[$nro_fila]->addChild($nuevaEtiqueta,$nuevoValor);

					}

				}
				$nro_fila++;
			}

			return $xml;
	}

	function reemplazaCaracteresEspeciales($cadena){
	  $cadena = str_replace('Ã¡','á',$cadena);
	  $cadena = str_replace('Ã©','é',$cadena);
	  $cadena = str_replace('Ã­','í',$cadena);
	  $cadena = str_replace('Ã³','ó',$cadena);
	  $cadena = str_replace('Ãº','ú',$cadena);
	  $cadena = str_replace('Ã±','ñ',$cadena);

	  $cadena = str_replace("Ã","Á",$cadena);
	  $cadena = str_replace("Ã‰","É",$cadena);
	  $cadena = str_replace("Ã","Í",$cadena);
	  $cadena = str_replace("Ã“","Ó",$cadena);
	  $cadena = str_replace("Ãš","Ú",$cadena);
	  $cadena = str_replace("Ã‘","Ñ",$cadena);
	  //$cadena = str_replace("Â",'',$cadena);

	  return $cadena;
	}

}


?>