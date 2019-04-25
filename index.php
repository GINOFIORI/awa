<?php

session_start();
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
ob_start();

include_once('includes/maestro.php');

// si hay sesion iniciada, redirigir hacia principal

if(array_key_exists("datosLogin", $_SESSION) && !isset($_POST['submit']) ){
	echo '<script>window.top.location.href="principal.php";</script>';
}


?>

<!DOCTYPE HTML>

<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Allways ERP Software de Gestión para Empresas</title>

<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="img/favicon.ico"/>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/util.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<link href="../../css/font-awesome.css" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
	<style type="text/css">
	@media (max-width: 768px) {
		.descarto {display:none;}
	}
	</style>

</head>

<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-color:#33CCCC !important">
			<div class="wrap-login100" id="wrap-login100" style="padding-top:35px !important; text-align: center;" >
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="login-form" class="form-horizontal"  name="formulariologin">
					<p class="w3-wide" id="w3-wide" style=" text-align: center"><span style="font-size: 15pt; color:	#666666">Bienvenidos al portal de acceso web de <strong></strong></span></p> 
					<span class="login100-form-title p-b-16">
						<img style="width: 95%; height: 95%" class="img" src="img/logofinal2.png" height="60" />
					</span>

					<div class="wrap-input100 validate-input" data-validate ="Formato usuario: a@b" style="text-align: left !important; "required="required" >
						<input class="input100" type="text" name="usuario" autocomplete="off">
						<span class="focus-input100" data-placeholder="Usuario"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate ="Ingresar contraseña" style="text-align: left !important;">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password" autocomplete="off" required="required">
						<span class="focus-input100" data-placeholder="Contraseña"></span>
					</div>

					<div class="input100" data-validate ="Seleccionar rol" style="margin-bottom: 30px; padding: 0px;">
						<select name="rol" class="input100" >			
								<option value="1">Usuario Allways ERP</option>
								<option value="2">Cliente</option>
								<option value="3">Vendedor</option>
								<option value="4">Proveedor</option>
						</select>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="submit" type="submit" value="Ingresar">
								Ingresar
							</button>
						</div>
					</div>
				
				  <?php

						if ( isset ( $_POST['submit'] ) ) {


							if(array_key_exists("datosLogin", $_SESSION)){
								// SESIÓN YA INICIADA
								header("Refresh:0");
							}else{
								include("includes/conexionBD.php");
								if(is_null($link)) {
									?>
									<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
										<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>Error en la conexión con la base de datos.</b></span></p>			
									</div>
									<?php
									die();
								}

								$pass      = $_POST['password'];
								$rol       = $_POST['rol'];
								$usuario   = $_POST['usuario'];
								
								$usu       = explode ( '@' , $usuario );
								
								$IdLogin   = $usu[0];
								if ($rol==2){
									$IdLogin = str_pad($IdLogin , 8 , '0' , STR_PAD_LEFT);
								}elseIf($rol==3){
									$IdLogin = str_pad($IdLogin , 5 , '0' , STR_PAD_LEFT);
								}
								$IdCliente             = $usu[1];
								$_SESSION["IdCliente"] = $IdCliente;

// DETERMINAR SI ES USUARIO DE AWA O SI ES ADMINISTRADOR DE CONFIGURACIONES
								if (isset($IdCliente)){

									// ES USUARIO DE AWA

									$consulta  = "Select * from awa_config where IdCliente = '$IdCliente'";
									
									$result    = mysqli_query($link,$consulta) or die (mysqli_error($link));
									$fila      = mysqli_fetch_array($result);

									if ( mysqli_num_rows($result) != 1 ) { ?>

										<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
											<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>La empresa no tiene cuenta asignada.</b></span></p>			
										</div>

									<?php 
									}else{

										if ( $fila['Disponible']==0 ){
										?>

										<div class="alert alert-info errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
											
											<p><span style="font-size:8pt; color: darkblue; padding-top: 2px; padding-bottom: 2px !important" ><b>El acceso a esta cuenta se encuentra temporalmente suspendido. Intente nuevamente más tarde.</b></span></p>			
										</div>
										<?php 

										}else{

											$maestro = Maestro::instanciar();

											$UrlCliente        = $maestro->desencriptar($fila['UrlCliente'],$fila['IdCliente']);
											$ServidorCliente   = $maestro->desencriptar($fila['ServidorCliente'],$fila['IdCliente']);
											$BDCliente         = $maestro->desencriptar($fila['BDCliente'],$fila['IdCliente']);
											$IdEmpCliente      = $fila['IdEmpCliente'];
											$IdSucCliente      = $fila['IdSucCliente'];
											$CaminoAwaDownload = $maestro->desencriptar($fila['CaminoAwaDownload'],$fila['IdCliente']);
											$caminoAwaBR       = $maestro->desencriptar($fila['CaminoAwaBR'],$fila['IdCliente']);
											$DescripcionEmp    = $fila['DescripcionEmp'];
											$UsuarioAdm				 = $maestro->desencriptar($fila['UsuarioAdm'],$fila['IdCliente']);
											$PassAdm					 = $maestro->desencriptar($fila['PassAdm'],$fila['IdCliente']);
											$Llave					 	 = $maestro->desencriptar($fila['Llave'],$fila['IdCliente']);

											$modulo  = 9999;
											$comando = 'LOGIN()';

											$_SESSION["UrlCliente"]  	   	 = $UrlCliente;
											$_SESSION["CaminoAwaDownload"] = $CaminoAwaDownload;
											$_SESSION["caminoAwaBR"] 	   	 = $caminoAwaBR;
											$_SESSION["rol"]         	   	 = (int) $rol;
											$_SESSION["IdLogin"]     	   	 = $IdLogin;
											$_SESSION["pass"]    	 	   		 = $pass;
											$_SESSION["ServidorCliente"]   = $ServidorCliente;
											$_SESSION["BDCliente"]         = $BDCliente;
											$_SESSION["IdEmpCliente"]      = (int) $IdEmpCliente;
											$_SESSION["IdSucCliente"]      = (int) $IdSucCliente;
											$_SESSION["DescripcionEmp"]    = $DescripcionEmp;
											$_SESSION["UsuarioAdm"]    		 = $UsuarioAdm;
											$_SESSION["PassAdm"]					 = $PassAdm;
											$_SESSION["Llave"]					 	 = $Llave;

											include("includes/conexionWS.php");			

											$xml = conexionWS ( $modulo , $comando );	

											$mensaje_id   = $xml[0];
											$mensaje_info = $xml[1];

											if ( $mensaje_info != '**PASS**' && $mensaje_id < 0 ){ 
												?>
												<script type="text/javascript">
													document.getElementById("w3-wide").style.width  = '280px';
												</script>

												<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; width: 100%; padding-left: 0px; padding-right: 0px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
													<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b><?php echo trim($mensaje_info);?></b></span></p>			
												</div>
											<?php 
												session_destroy();
											}elseif ( $mensaje_info == '**PASS**' ){ 
												//cambiar contraseña 
												?>
												<script>
												window.location.href='cambiarPass.php';
												</script>
												<?php
											}else{  
												//todo ok
												$_SESSION["datosLogin"] = $mensaje_info ;
												?>
												<script>
												window.location.href='principal.php';
												</script>
											<?php }

										}

									}

									mysqli_free_result($result) ;
									mysqli_close($link) ;
								}else{

									// ES ADMINISTRADOR 


									$consulta  = "Select * from administradores where NombreUsuario= '$IdLogin'";
									
									$result    = mysqli_query($link,$consulta) ;

									if ( mysqli_error($link) != '' ) { 
										?>
										<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
											<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>Error en consulta BD SQL: <?php echo (mysqli_error($link)); ?></b></span></p>			
										</div>
										<?php
									}else{

										$fila      = mysqli_fetch_array($result);

										if ( mysqli_num_rows($result) != 1 ){ 
											?>
											<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
												<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important"><b>El usuario especificado no existe</b></span></p>			
											</div>
											<?php
										}else{
											if ( !(password_verify($pass,$fila['PassUsuario']) ) ) {
												?>
												<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px;">
											<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px;" ><b>Usuario o contraseña incorrectos</b></span></p>			
								<!--
													<p><?php //echo ("Pass Usuario: " . password_hash($fila['PassUsuario'],PASSWORD_DEFAULT)); ?></p>
													<p><?php //echo ("Pass Ingresada: " . password_hash($pass,PASSWORD_DEFAULT)); ?></p>
								-->
												</div>
												<?php
											}else{
												$_SESSION["admin"] 			= $fila['NombreUsuario'];
												$_SESSION["datosLogin"] = $fila['NombreUsuario'];
												$_SESSION["IdLogin"]    = $fila['NombreUsuario'];
												$_SESSION["pass"]    	  = $fila['PassUsuario'];
												$_SESSION["rol"]    	  = 0;
												?>
												<script>
													window.location.href='admin.php';
												</script>
												<?php
											}

										}

									}

								}

							}

						}

					?>

				</form>
			</div>
			<div class="col-md-12 descarto" style="text-align: center; position: initial;">
				<a href="https://itunes.apple.com/ar/app/allways-erp/id1456009864" target="_blank"><img style="width: 150px; padding-right: 10px" class="img" src="img/boton_apple_store.svg" height="60"></a>
				<a href="https://play.google.com/store/apps/details?id=com.awa.awa.com" target="_blank"><img style="width: 150px; padding-left: 10px" class="img" src="img/boton_google_play.svg" height="60"></a>
			</div>
		</div>
	</div>


<div id="dropDownSelect1"></div>
					
				
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>


</body>

</html>

<?php
ob_end_flush();
?>