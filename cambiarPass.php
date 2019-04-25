<?php
	session_start();
	ob_start();
?>

<!DOCTYPE HTML>

<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Allways ERP Software de Gesti&oacute;n para Empresas</title>

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

</head>

<body>	

<div class="limiter">
		<div class="container-login100" style="background-color:#33CCCC !important">
			<div class="wrap-login100" style="padding-top:35px !important; text-align: center;" >
				<form  method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="login-form" class="form-horizontal"  name="formularioCambioPass">
					<p class="w3-wide" style=" text-align: center"><span style="font-size: 15pt; color:	#666666">Bienvenidos al portal de acceso web de <strong></strong></span></p> 
					<span class="login100-form-title p-b-16">
						<img style="width: 95%; height: 95%" class="img" src="img/logofinal2.png" height="60" />
					</span>

					<div class="wrap-input100 validate-input" data-validate ="Ingresar contraseña anterior" style="text-align: left !important;">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="ContraseniaAnterior" id="ContraseniaAnterior" >
						<span class="focus-input100" data-placeholder="Contraseña Actual"></span>
					</div>


					<div class="wrap-input100 validate-input" data-validate ="Ingresar contraseña nueva" style="text-align: left !important;">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="ContraseniaNueva" id="ContraseñaNueva">
						<span class="focus-input100" data-placeholder="Contraseña Nueva"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate ="Repetir contraseña nueva" style="text-align: left !important;">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="RepetirContraseniaNueva" id="RepetirContraseniaNueva">
						<span class="focus-input100" data-placeholder="Repetir Contraseña Nueva"></span>
					</div>


					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="cambiar" value="Cambiar" type="submit" value="Ingresar">
								Cambiar
							</button>
						</div>
					</div>						

					<?php
				if ( isset($_POST['cambiar'] ) ) {
					$contraseniaAnterior 	 = $_POST['ContraseniaAnterior'];
					$contraseniaNueva 	 	 = $_POST['ContraseniaNueva'];
					$repetirContraseniaNueva = $_POST['RepetirContraseniaNueva'];
					if ( $_SESSION["pass"] != $contraseniaAnterior ) { ?>
						<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
							<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>La contrase&ntilde;a ingresada no coincide con la actual.</b></span></p>
						</div>
					<?php }
					elseif ( $contraseniaAnterior == $contraseniaNueva ) { ?>
						<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
							<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>La contrase&ntilde;a anterior y la nueva son iguales.</b></span></p>
						</div>
					<?php }
					elseif ( $contraseniaNueva != $repetirContraseniaNueva ) { ?>
						<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
							<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>Las nuevas contrase&ntilde;as ingresadas no son iguales.</b></span></p>
						</div>
					<?php }
					else {
						// validaciones ok, cambiar contraseña
						include("includes/conexionWS.php");							
						$modulo    = 9999;
						$comando   = "RESETPASS(" . $_SESSION["pass"] . "," . $contraseniaAnterior . "," . $contraseniaNueva . "," . $repetirContraseniaNueva . ")";
						$resultado = conexionWS ( $modulo , $comando );
						$mensaje_id   = $resultado[0];
						$mensaje_info = $resultado[1];
						if ( $mensaje_info != '**OK**' ){ ?>
							<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
								<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b><?php echo $mensaje_info ; ?></b></span></p>
							</div>
						<?php }
						else{ ?>
							<script>
							alert('La clave ha sido modificada correctamente');
							window.location.href='index.php';
							</script>
						<?php }
					}
				}
			?>
				</form>
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
