<?php

class Configuraciones_mdl{

	private $link;

	private $errores;

	public function __construct(){

			require_once("conexion.php");

			$this->bd=Conexion::conectar();

			if ( gettype($this->bd) == 'string' ){
				$this->errores = $this->bd;
			}

	}

	public function get_errores(){

		return $this->errores;
		
	}

	public function listar_configuraciones(){

		$consulta = "Select * from awa_config";
		
		$query    = mysqli_query($this->bd,$consulta);

		if ( mysqli_error($this->bd) != '' ) {
			$this->errores = mysqli_error($this->bd);
			return $this->errores;
		}

		$lista_configuraciones = array();

    /* obtener el array de objetos */
    while ($configuracion = $query->fetch_object()) {
    	$lista_configuraciones[] = $configuracion;
    }

    /* liberar el conjunto de resultados */
    $query->close();

		return $lista_configuraciones;

	}

	public function set_config($configuracion){

		$consulta = "Insert Into awa_config 
								 values ( '$configuracion->IdCliente',
													'$configuracion->UrlCliente',
													'$configuracion->ServidorCliente',
													'$configuracion->BDCliente',
													'$configuracion->IdEmpCliente',
													'$configuracion->IdSucCliente',
													'$configuracion->CaminoAwaDownload',
													'$configuracion->CaminoAwaBR',
													'$configuracion->DescripcionEmp',
													'$configuracion->UsuarioAdm',
													'$configuracion->PassAdm',
													'$configuracion->Disponible',
													'$configuracion->Llave' )";

		$query    = mysqli_query($this->bd,$consulta);

		$this->errores = mysqli_error($this->bd);

		if ($this->errores !== '') {
				$this->errores = 'Error interno al intentar insertar registro: ' . $this->errores; 
		}

	}

	public function get_config($IdCliente){

		$consulta = "Select * From awa_config Where IdCliente = '$IdCliente'";

		$query    = mysqli_query($this->bd,$consulta);

		$this->errores = mysqli_error($this->bd);

		if ($this->errores !== '') { 
				$this->errores = 'Error en la consulta con la base de datos: ' . $this->errores; 
		}

		$configuracion = $query->fetch_object();

		return $configuracion;

	}

	public function del_config($IdCliente){

		$IdCliente = mysqli_real_escape_string($this->bd,$IdCliente);

		$consulta 		 = "Delete From awa_config Where IdCliente = '$IdCliente'";

		$query 				 = mysqli_query($this->bd,$consulta);

		$this->errores = mysqli_error($this->bd);

		if ($this->errores !== '') {
			$this->errores = 'Error en la consulta con la base de datos: ' . $this->errores;
		}

		return;

	}

	public function update_config($configuracion){

		$consulta = "Update awa_config 
								 Set    UrlCliente 				= '$configuracion->UrlCliente',
												ServidorCliente 	= '$configuracion->ServidorCliente',
												BDCliente 				=	'$configuracion->BDCliente',
												IdEmpCliente		 	=	'$configuracion->IdEmpCliente',
												IdSucCliente 			=	'$configuracion->IdSucCliente',
												CaminoAwaDownload =	'$configuracion->CaminoAwaDownload',
												CaminoAwaBR 			=	'$configuracion->CaminoAwaBR',
												DescripcionEmp	 	=	'$configuracion->DescripcionEmp',
												UsuarioAdm				= '$configuracion->UsuarioAdm',
												PassAdm					  = '$configuracion->PassAdm',
												Disponible			  = '$configuracion->Disponible',
												Llave							= '$configuracion->Llave'
								Where IdCliente = '$configuracion->IdCliente'";

		$query    = mysqli_query($this->bd,$consulta) or die(mysqli_error($this->bd));

		$this->errores = mysqli_error($this->bd);

		if ($this->errores !== '') {
				$this->errores = 'Error interno al intentar modificar registro: ' . $this->errores; 
		}

	}


}


?>