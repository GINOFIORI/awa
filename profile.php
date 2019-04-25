<?php

session_start();
$datosLogin =  $_SESSION["datosLogin"];

include ("includes/descrip_roles.php");

if ( $_SESSION["rol"] == 2 ){
    $codClienteLogIn   = intval($_SESSION["IdLogin"]);
  }


?>


<!DOCTYPE HTML>

<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Perfil</title>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
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

<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

<style type="text/css">
.wrap-input100 {
  margin-bottom: 25px !important;
}
@media (min-width: 992px) {

  .profile {
    float: right !important;
  }

  .fila1 {
    padding-right: 4px !important; 
    padding-left: 0px !important
  }

  .fila2 {
  padding-right:0px !important; 
  padding-left: 4px !important
  }

}

@media (max-width:992px) and (min-width:768px) {

  .fila1 {
    padding-right: 4px !important; 
    padding-left: 0px !important
  }

  .fila2 {
  padding-right:0px !important; 
  padding-left: 4px !important
  }
 
  .bloque {
    max-width: 100% !important;
    }

  .bloque2 {
    padding-top: 200px !important;
  }


}

@media (max-width: 768px) {

   .fila1 {
    padding-right: 0px !important; 
    padding-left: 0px !important
  }

  .fila2 {
  padding-right:0px !important; 
  padding-left: 0px !important
  }

  
}
  
</style>

</head>

<body>  

<nav class ="navbar navbar-default navbar-fixed-top" style="padding:0px;">
  <div class ="container-fluid" style="margin: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
      <div class="navbar-header">
        <a class="img-responsive" style="margin: 0 auto;" href="http://www.neosistemassrl.com/" target="_blank"><img src="img\allways.png" alt="Allways ERP" width="183" height="51" /></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
      <div class="navbar-header profile" style= " font-family: open sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 13px;">
        <ul class="masthead-nav navbar-right" style="list-style: none;">
          <li><span class="Estilo3"><b>Allways ERP Software de Gesti&oacute;n para Empresas</b></span></li>
          <li><span class="Estilo3"><b>M&oacute;dulo de Acceso Web</b></span></li>
        </ul>
      </div>
    </div>
    </div>
</nav>
        

<div class="container-">
  <div class="col-sm-2 col-md-2">
  </div>
  <div class="col-sm-12 col-md-8 bloque2" >
    <div class="col-sm-12 col-md-12" style="border-width: 1px ; border-style: solid; border-color: lightgrey; background: #f1f3f6; border-radius: 10px;padding-top: 10px;">
      <p class="w3-wide" style=" text-align: center;padding-bottom: 30px; font-family: Verdana, Geneva, sans-serif">
      <span style="font-size: 15pt; color: #666666;"> <i class="fa fa-user-circle"></i> Mi Perfil <strong></strong></span>
  </p> 
      <div class="col-sm-12 col-md-8 col-md-offset-2 bloque">
        <div class="control-group form-group">
           <?php 
            if ( $_SESSION["rol"] == 2 ){
            ?>  
          <div  class="col-sm-12 col-md-12" style="padding: 0px !important;">  
            <div  class="col-sm-6 col-md-6 fila1">
              <div class="wrap-input100 validate-input" style="text-align: left !important; "required="required" >
                <span class="focus-input100" data-placeholder="Usuario" style="margin-top: -30px;"></span>
                <input class="input100" disabled="true" type="text"  id="user_firstName"  name="user[firstName]" value="<?php echo $_SESSION["datosLogin"]; ?>" data-parsley-required="true" data-parsley-trigger="change">
              </div>
            </div>
            <div  class="col-sm-6 col-md-6 fila2">
              <div class="wrap-input100 validate-input" style="text-align: left !important; "required="required" >
                <span class="focus-input100" data-placeholder="Vendedor Asignado" style="margin-top: -30px;"></span>
                <input class="input100" disabled="true" type="text"  id="vendedorCliente"  name="vendedorCliente" data-parsley-required="true" data-parsley-trigger="change">
              </div>
            </div>
          </div>
          <?php 
          }else{
          ?>
          <div class="wrap-input100 validate-input" style="text-align: left !important; "required="required" >
            <span class="focus-input100" data-placeholder="Usuario" style="margin-top: -30px;"></span>
            <input class="input100" disabled="true" type="text"  id="user_firstName"  name="user[firstName]" value="<?php echo $_SESSION["datosLogin"]; ?>" data-parsley-required="true" data-parsley-trigger="change">
          </div>
        <?php } ?> 
          <div  class="col-sm-12 col-md-12" style="padding: 0px !important;">  
            <div  class="col-sm-6 col-md-6 fila1" >
              <div class="wrap-input100 validate-input"style="text-align: left !important; "required="required" >
                <span class="focus-input100" data-placeholder="Empresa" style="margin-top: -30px;"></span>
                <input class="input100" disabled="true" type="text" id="user_lastName" value="<?php echo $_SESSION["DescripcionEmp"]; ?>" data-parsley-required="true" data-parsley-trigger="change">
              </div>
            </div>
            <div  class="col-sm-6 col-md-6 fila2" > 
              <div class="wrap-input100 validate-input" style="text-align: left !important; "required="required" >
                <span class="focus-input100" data-placeholder="Rol" style="margin-top: -30px;"></span>
                <input class="input100" disabled="true" type="text" id="rol" value="<?php echo $descrip_roles[$_SESSION["rol"]]; ?>" data-parsley-required="true" data-parsley-trigger="change">
              </div>
            </div>
          </div>
          <form  method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="login-form" class="form-horizontal"  name="formularioCambioPass">

          <?php if ( $_SESSION["IdLogin"] == 'adm' ){
            ?>
            <div  class="col-sm-12 col-md-12" style="padding: 0px !important; margin-bottom: 25px;"> 
              <div  class="col-sm-12 col-md-12 fila2"> 
                <div class="container-login100-form-btn">
                  <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                      <button type="submit" name="volver" value="volver" class="login100-form-btn">Volver</button>
                  </div>
                </div>
              </div>
            </div>
        <?php
          } else { 
            ?>
          <div class="col-sm-12 col-md-12" style="padding: 0px;">
            <div class="wrap-input100 validate-input" data-validate ="Ingresar contraseña actual" style="text-align: left !important;">
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
            </div>

            <div  class="col-sm-12 col-md-12" style="padding: 0px !important; margin-bottom: 25px;">  
              <div  class="col-sm-6 col-md-6 fila1">
                <div class="container-login100-form-btn">
                  <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                    <button class="login100-form-btn" name="cambiar" value="Cambiar" type="submit" value="Cambiar">
                      Cambiar
                    </button>
                  </div>
                </div> 
              </div>        

              <div  class="col-sm-6 col-md-6 fila2"> 
                <div class="container-login100-form-btn">
                  <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                      <button type="submit" name="volver" value="volver" class="login100-form-btn">Volver</button>
                  </div>
                </div>
              </div>
            </div>

            <?php
          }
          if (isset($_POST['volver'])) { ?>
            <script>
             window.location.href='principal.php';
            </script>
            <?php  } 

          if ( isset($_POST['cambiar'] ) ) {
            $contraseniaAnterior   = $_POST['ContraseniaAnterior'];
            $contraseniaNueva      = $_POST['ContraseniaNueva'];
            $repetirContraseniaNueva = $_POST['RepetirContraseniaNueva'];
            if ( $_SESSION["pass"] != $contraseniaAnterior ) { ?>
              <div class="col-md-12 alert alert-danger errores" style="text-align: center; margin-top: 0px; margin-bottom: 2px !important; padding-top: 0px; padding-bottom: 2px">
                <p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>La contrase&ntilde;a ingresada no coincide con la actual.</b></span></p>
              </div>
            <?php }
            elseif ( $contraseniaAnterior == $contraseniaNueva ) { ?>
              <div class="col-md-12 alert alert-danger errores" style="text-align: center; margin-top: 0px; margin-bottom: 2px !important; padding-top: 0px; padding-bottom: 2px">
                <p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>La contrase&ntilde;a anterior y la nueva son iguales.</b></span></p>
              </div>
            <?php }
            elseif ( $contraseniaNueva != $repetirContraseniaNueva ) { ?>
              <div class="col-md-12 alert alert-danger errores" style="text-align: center; margin-top: 0px; margin-bottom: 2px !important; padding-top: 0px; padding-bottom: 2px">
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
                <div class="col-md-12 alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
                  <p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b><?php echo $mensaje_info ; ?></b></span></p>
                </div>
              <?php }
              else{ ?>
                <script>
                alert('La clave ha sido modificada correctamente');
                window.location.href='cerrar_sesion.php';
                </script>

              <?php }
            }
          }
        ?>
              </form>
            </div><!--cierra control-group form-group"-->
          </div>
        </div>
      </div>
    </div> <!--cierra col-md-12 -->
  </div> <!--cierra col-md-8 -->
</div> <!--cierra container fluid -->

<script type="text/javascript">

<?php 

  if($_SESSION["rol"] == 2){
          // CLIENTE
          echo "recuperarVendedorCliente(" . $codClienteLogIn . ")";
  }

?>

  function recuperarVendedorCliente(codCliente){
  $.post("ventas/nv_ventas/selClienteBuscador.php", 
    { cod_cliente: codCliente }, 
    function(data) {
      cliente = JSON.parse(data);
      if ( cliente.results_row.as_error_msg_js ){
        alert ("Error en la conexión con el servidor del cliente: " + cliente.results_row.as_error_msg_js );          
        return;
      };
      if ( cliente.results_row.as_return_msg_js ){
        alert ("Alerta!: " + cliente.results_row.as_return_msg_js );
        return;
      };

      var vendedor = document.getElementById("vendedorCliente");

      vendedor.value = cliente.results_row.vendvtasapell + " " + cliente.results_row.vendvtasnomb

    }
  );
}

</script>

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