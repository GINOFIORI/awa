<!DOCTYPE HTML>

<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Buscar Usuario</title>

<link rel="stylesheet" type="text/css" href="css/estilo.css" />

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php 
		include("includes/conexion.php");

		session_start();
		
		$pass      = $_POST['password'];
		$rol       = $_POST['rol'];
		$usuario   = $_POST['usuario'];
		
		$usu       = explode ('@', $usuario);
		
		$IdLogin   = $usu[0];
		$IdCliente = $usu[1];

		$_SESSION["usuario"]  = $usuario;
		$_SESSION["password"] = $pass;
		$_SESSION['rol']      = $rol;
	
		$consulta  = "Select * from awa_config where IdCliente = '$IdCliente'";
		
		$result    = mysqli_query($link,$consulta) or die (mysqli_error($link));
		$fila      = mysqli_fetch_array($result);
		
		if(!mysqli_num_rows($result)== 1)
			{ ?>
				<div class="alert alert-danger errores">
					<h2><span style="font-size:10pt; color:#CC3300"><b>Advertencia</b></span></h2>
					<h2><span style="font-size:10pt; color:#CC3300"><b>El usuario y contrase&ntilde;a no coinciden o usted a&uacute;n no tiene una cuenta.</b></span></h2>			
					<h2><span style="font-size:10pt; color:#CC3300"><a href='index.php'>Volver al menu</a></span></h2>
				</div>
		<?php	}
		else
			{
				$urlempresa      = $fila['UrlCliente'];
				$servidorCliente = $fila['ServidorCliente'];
				$bdCliente       = $fila['BDCliente'];
				$IdEmpCliente    = $fila['IdEmpCliente'];
				$IdSucCliente    = $fila['IdSucCliente'];
				$caminoAwaBR     = $fila['CaminoAwaBR']; 
				
				$modulo 		 = 9999;
				$comando         = 'LOGIN()';
				
				include ("includes/conexionWS.php");
				
				$xml = conexionWS ($urlempresa,
								   $caminoAwaBR,
								   $rol,
								   $IdLogin,
								   $pass,
								   $servidorCliente,
								   $bdCliente,
								   $IdEmpCliente,
								   $IdSucCliente,
								   $modulo,
								   $comando);
				
				$mensaje_id   = $xml[0] ;
				$mensaje_info = $xml[1] ;

				if ( $mensaje_info != '**PASS**' && $mensaje_id < 0 ){
					// mensaje de advertencia de contraseña o usuario no habilitado
					echo $mensaje_info ;
					die();
				}elseif ( $mensaje_info == '**PASS**' ){ 
					//cambiar contraseña original 
					header ("Location: cambiarPass.php?"); 						
				}else{
					//todo ok
					header ("Location: principal.php");
				}

				?>
		<?php			
			} 
					
		mysqli_free_result($result);
		mysqli_close($link);
		
	?>

</body>
</html>
