<?php

class Administradores_mdl{

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

	public function listar_administradores(){

		$consulta = "Select * from administradores";
		
		$query    = mysqli_query($this->bd,$consulta);

		if ( mysqli_error($this->bd) != '' ) {
			$this->errores = mysqli_error($this->bd);
			return $this->errores;
		}

		$lista_administradores = array();

    /* obtener el array de objetos */
    while ($administrador = $query->fetch_object()) {
    	$lista_administradores[] = $administrador;
    }

    /* liberar el conjunto de resultados */
    $query->close();

		return $lista_administradores;

	}

	public function set_admin($administrador){

		$NombreUsuario = mysqli_real_escape_string($this->bd,$administrador->NombreUsuario);
		$Nombre 			 = mysqli_real_escape_string($this->bd,$administrador->Nombre);
		$Apellido 		 = mysqli_real_escape_string($this->bd,$administrador->Apellido);

		$consulta = "Insert Into administradores values ( '$NombreUsuario' , '$administrador->PassUsuario' , '$Nombre' , '$Apellido' )";

		$query    = mysqli_query($this->bd,$consulta);

		$this->errores = mysqli_error($this->bd);

		if ($this->errores !== '') { 
				$this->errores = 'Error interno al intentar insertar registro: ' . $this->errores; 
		}

	}

	public function get_admin($NombreUsuario){

		$NombreUsuario = mysqli_real_escape_string($this->bd,$NombreUsuario);

		$consulta = "Select * From administradores Where NombreUsuario = '$NombreUsuario'";

		$query    = mysqli_query($this->bd,$consulta);

		$this->errores = mysqli_error($this->bd);

		if ($this->errores !== '') { 
				$this->errores = 'Error en la consulta con la base de datos: ' . $this->errores; 
		}

		$administrador = $query->fetch_object();

		return $administrador;

	}

	public function del_admin($NombreUsuario){

		$NombreUsuario = mysqli_real_escape_string($this->bd,$NombreUsuario);

		$consulta 		 = "Delete From administradores Where NombreUsuario = '$NombreUsuario'";

		$query 				 = mysqli_query($this->bd,$consulta);

		$this->errores = mysqli_error($this->bd);

		if ($this->errores !== '') {
			$this->errores = 'Error en la consulta con la base de datos: ' . $this->errores;
		}

		return;

	}

	public function update_admin($administrador){

		$NombreUsuario = mysqli_real_escape_string($this->bd,$administrador->NombreUsuario);
		$Nombre 			 = mysqli_real_escape_string($this->bd,$administrador->Nombre);
		$Apellido 		 = mysqli_real_escape_string($this->bd,$administrador->Apellido);

		$consulta ="Update administradores Set Nombre = '$Nombre',
																					 Apellido = '$Apellido',
																					 PassUsuario = '$administrador->PassUsuario'
								WHERE NombreUsuario = '$NombreUsuario'";

		$query    = mysqli_query($this->bd,$consulta);

		$this->errores = mysqli_error($this->bd);

		if ($this->errores !== '') {
				$this->errores = 'Error interno al intentar modificar registro: ' . $this->errores; 
		}

	}

}


?>