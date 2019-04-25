<?php

  session_start();
  include("includes/conexionWS.php");

  // Ante todo se debe validar que si el rol es CLIENTE, se deben setear variables iniciales ... ////////////////////

  If ( $_SESSION["rol"] == 2 ){
    $codClienteLogIn   = $_SESSION["IdLogin"];
    // Las fecha desde y hasta por default son el primer dia del año y la fecha actual respectivamente ...
    $arrayFechaHasta   = getdate();
    $fechaDesde = date_create ( $arrayFechaHasta['year'] . '-01-01' );
    $fechaHasta = date_create ( $arrayFechaHasta['year'] . '-' . $arrayFechaHasta['mon'] . '-' . $arrayFechaHasta['mday']  );
  }

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  function recuperarValor ($nombreCampo){

    $valor = '';
    if ( array_key_exists($nombreCampo, $_REQUEST) ) {
      $valor = $_REQUEST[$nombreCampo];
      if ( $nombreCampo == 'fechaDesde' || $nombreCampo == 'fechaHasta' ) {
        $valor = date_create($valor);
      }
    }
    return $valor;
  } 

  $haySolicitud = ( sizeof($_REQUEST) > 0 || ( $_SESSION["rol"] == 2 ) );

  if ($haySolicitud){

    if ( !(isset ($codClienteLogIn)) ) { 
      $codCliente = recuperarValor ('codCliente');
    }else{
      $codCliente = $codClienteLogIn;
    }

    if ( !(isset ($fechaDesde)) ) {
      $fechaDesde = recuperarValor ('fechaDesde');
    }

    if ( !(isset ($fechaHasta)) ) {
      $fechaHasta = recuperarValor ('fechaHasta');
    }

    $orden  = recuperarValor ('orden');

    $modulo = 3;

    // Recuperar datos del cliente ...  //////////////////////////////////////////////////////////////////////////////////////////////

    $comandoCliente = "CLIENTE(" . $codCliente . ")";

    $datosCliente   = conexionWS ( $modulo , $comandoCliente );

    If ( gettype($datosCliente)=='array' ){
?>
      <div class="alert alert-danger errores">
        <p><span style="font-size:10pt; color:#CC3300"><b><?php echo 'Mensaje Info: ' . $datosCliente[1] ; ?></b></span></p>
      </div>
<?php
      die();
    }


    // Recuperar datos de cta cte ...  //////////////////////////////////////////////////////////////////////////////////////////////

    $excl_anulados   = "0";
    $excl_cancelados = "0";

    $comandoCtaCte  = "CTACTECLI(" . $codCliente . "," . $orden . "," . date_format( $fechaDesde , "d/m/Y" ) . "," . date_format ( $fechaHasta , "d/m/Y" ) . "," . $excl_anulados . "," . $excl_cancelados . ")"; 
    $resultado = conexionWS ( $modulo , $comandoCtaCte );

    If ( gettype($resultado)=='array' ){
?>
      <div class="alert alert-danger errores">
        <p><span style="font-size:10pt; color:#CC3300"><b><?php echo 'Mensaje Info: ' . $resultado[1] ; ?></b></span></p>
      </div>
<?php
      die();
    }
  }
?>

<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>NeoSistemas SRL | Cuenta Corriente Clientes</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">

    <!-- Hoja de estilo de cuenta corriente -->
    <link href="css/ctacte-style.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />

    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  </head>
  <body style="background-color:#F3F3F4;">
 <!--<nav class="navbar navbar-default navbar-fixed-top" style="padding-left: 0; padding-right: 0;">-->
    <div class="row">
      <div class="ibox float-e-margins" >

        <div class="ibox-title" style="background-color:#2F4050;">          
          <h5 style="color:#DFE4ED;">Cuenta Corriente de Clientes</h5>
        </div>
        
        <div id="menu" class="ibox-content" style="background-color: #A7BEE7; padding-left:0px; padding-right: 0px; ">
          <form id="filtros"
                name="filtros" 
                action="<?php echo $_SERVER['PHP_SELF'];?>"
                method="POST">
            <div class="row">
              <!--col-xs-12 col-sm-12 col-md-5 b-r col-lg-5 b-r-->
              <div class="col-sm-5 b-r">
                <div class="col-md-12">
                  <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style='text-align: left'>
                    <label style="color: black; font-size: 8pt;">Cliente</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'>
                    <form class='navbar-form'>
                      <div class='input-group col-xs-12 col-sm-12 col-md-8 col-lg-8' > 
                        <input  id    = "codCliente" 
                                name  = "codCliente"
                                value ="<?php if(isset($codCliente)) echo $codCliente; ?>"
                                class ="form-control"
                                type  ="text" 
                                placeholder ="Ingresar Código"
                                style = "height: 22px; font-size: 8pt" 
                                <?php
                                if (isset($codClienteLogIn)){
                                  echo "onfocus='this.blur()'' readonly='readonly'";
                                }
                                ?>
                                >
                        <span class="input-group-btn">
                          <button type='submit' 
                                  class='btn btn-xs btn-primary'
                                  <?php
                                  if (isset($codClienteLogIn)){
                                    echo "readonly='readonly' disabled = 'disabled'";
                                  }
                                  ?>
                                  >
                            <span class="fa fa-search" ></span>
                          </button>
                        </span>
                      </div>
                    </form>
                  </div>
                </div>
                <div class='col-md-12'>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='text-align: left'>
                    <label style="padding-top: 5px; text-align: left; font-size: 8pt; color: dark-grey;">- Razón Social: </label>
                    <?php if ( isset($datosCliente)) {
                            echo $datosCliente->results_row->clientvtasnomb;
                          } ?>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='text-align: left'>
                    <label style="padding-top: 5px; text-align: left; font-size: 8pt; color: dark-grey;">- Domicilio: </label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='text-align: left'>
                    <label style="padding-top: 5px; text-align: left; font-size: 8pt; color: dark-grey;">- Localidad: </label>
                  </div>
                </div>
              </div>
              <div class="col-sm-5 b-r" style="padding-bottom: 0px">
                <div class="col-sm-12" style="padding-bottom: 4px;">
                  <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style="text-align: left;">
                    <label style="color: black; font-size: 8pt">Fecha Desde</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'><input id="fechaDesde"
                                                                            name="fechaDesde"
                                                                            value="<?php if(isset($fechaDesde)) echo date_format($fechaDesde , 'Y-m-d') ; ?>"
                                                                            style= "height: 22px; font-size: 8pt;" 
                                                                            type="Date" 
                                                                            class="form-control">
                  </div>
                </div>
                <div class="col-sm-12" style="padding-bottom: 4px;">
                  <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style="text-align: left;">
                    <label style="color: black; font-size: 8pt">Fecha Hasta</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'><input id="fechaHasta"
                                                                            name="fechaHasta"
                                                                            value="<?php if(isset($fechaHasta)) echo date_format($fechaHasta , 'Y-m-d') ; ?>"
                                                                            style= "height: 22px; font-size: 8pt;"    
                                                                            type="Date" 
                                                                            class="form-control">
                  </div>
                </div>
                <div class="col-sm-12" style="padding-bottom: 4px;">
                  <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style="text-align: left;">
                    <label style="padding-top: 5px; color: black; font-size: 8pt;">Orden</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>
                    <select style="font-size: 8pt; height: 22px; padding-top: 0; padding-bottom: 0;" name="orden" class="form-control" id="orden">
                      <option <?php if((isset($orden)) && ($orden=="1"))echo 'selected="selected"'; ?>
                              value="1">
                        Cronol&oacute;gico
                      </option>
                      <option <?php if((isset($orden)) && ($orden=="2"))echo 'selected="selected"'; ?>
                              value="2">
                        Imputaci&oacute;n
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-5" style="text-align: left">
                    <label class="checkbox-inline"><input type="checkbox" value="">Excluir anulados</label>
                  </div>  
                  <div class="col-sm-5" style="text-align: left">  
                    <label class="checkbox-inline"><input type="checkbox" value="">Excluir sin saldo</label>
                  </div>
                  <br/>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="col-sm-12">
                  <button style="padding: 5px 30px 5px 30px;" class="btn btn-xs btn-primary btn-block" type="submit"><strong>&nbsp Recuperar</strong></button>
                  <button style="padding: 5px 30px 5px 30px;" class="btn btn-xs btn-primary btn-block" type="submit"><strong>&nbsp Cancelar</strong></button>
                  <button style="padding: 5px 30px 5px 30px;" class="btn btn-xs btn-primary btn-block" type="submit"><strong>&nbsp PDF</strong></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <!--</nav>-->
  <div clas="row"> 

  <div class="container-fluid">
    <div id="menu" class="row collapse" style="height: 200px;">
    </div>
    <div class="row">
    <table class="table table-striped" id="table-1">
      <thead style="background-color: lightgrey;">
      <tr>
        <th class="text-center"> <strong>Fecha </strong></th>
        <th class="text-center" colspan="3"> <strong> Comprobante </strong> </th>
        <th class="text-center"> <strong>Fecha Vto. </strong></th>
        <th class="text-center"> <strong>Debe </strong></th>
        <th class="text-center"> <strong>Haber </strong></th>
        <th class="text-center"> <strong>Saldo </strong></th>
        <th class="text-center" colspan="3" width=15px> <strong>Cancelado </strong></th>
        <th class="text-center" colspan="2" widht=15px> <strong>Anulado </strong></th>
        <th class="text-center"> <strong>Ajuste</strong></th>
      </tr>
      </thead>
  <?php

  $inicio = true;

  if ( !(isset($resultado)) ) {
  ?>
    </table>
  <?php
  } else {
    foreach($resultado->results_row as $item){
      if ($inicio){
    ?>
        <tbody style="overflow-y: scroll">  
        <tr>
          <td class="text-right" colspan="15"> 
          <strong> Saldo Inicial:
            <?php
              echo (string)$item->adec_saldo_inicial;
              $inicio = false;
            ?> 
          </strong> 
          </td>
          </td>
        </tr>
    <?php
      }
    ?>
        <tr>
          <td class="text-center">
              <?php
                $fechaCbte = new DateTime((string)$item->adt_fecha_cbte);
                echo $fechaCbte->format('d/m/y');
              ?> 
          </td>
          <td class="text-center">
              <?php 
                $tipo_cbte=(string)$item->an_tipo_cbte;
                switch ($tipo_cbte) {
                  case '1':
                    $nombreCbte='FC Vtas.';
                    break;
                  case '2':
                    $nombreCbte='NC Vtas.';
                    break;
                  case '3':
                    $nombreCbte='ND Vtas.';
                    break;
                  case '6':
                    $nombreCbte='Recibo';
                    break;
                };
                echo $nombreCbte; 
              ?>  
          </td>
          <td class="text-center"> <?php echo $item->as_clase_cbte; ?> </td>
          <td class="text-center"> <?php echo $item->as_numero_cbte; ?> </td>
          <td class="text-center">
              <?php 
                $fechaVto = new DateTime((string)$item->adt_fecha_vto);
                if ($fechaVto){
                  echo $fechaVto->format('d/m/y'); 
                }
              ?> 
          </td>
          <td class="text-right"> 
              <?php 
                if ( $item->adec_monto_debe <> 0 ) {
                  echo (string)$item->adec_monto_debe;
                }
              ?>
          </td>
          <td class="text-right"> 
                <?php 
                  if ( $item->adec_monto_haber <> 0 ) {
                    echo (string)$item->adec_monto_haber;
                  }
                ?>
          </td>
          <td class="text-right">
                <?php 
                  echo (string)$item->adec_saldo_acum;
                ?> 
          </td>
          <td class="text-center"> 
                <?php 
                  if ($item->an_pago_ctdo==1) {; 
                ?> 
                  <span class="glyphicon glyphicon-check" aria-hidden="false"></span>
                <?php 
                } else {?>
                  <span class="glyphicon glyphicon-unchecked" aria-hidden="false"></span>
                <?php }; ?>
          </td>
          <td class="text-center">
                <?php 
                  if ($item->an_cbte_canc=='1') {; 
                ?> 
                  <span class="glyphicon glyphicon-check" aria-hidden="false"></span>
                <?php 
                } else {?>
                  <span class="glyphicon glyphicon-unchecked" aria-hidden="false"></span>
                <?php }; ?>
          </td>
          <td class="text-center"> 
                <?php 
                  if ($item->adt_fecha_canc!=''){
                    $fechaCancel = new DateTime((string)$item->adt_fecha_canc);
                    echo $fechaCancel->format('d/m/y');
                  }
                ?> 
          </td>
          <td class="text-center">
                <?php 
                  if ($item->an_cbte_anul==1) {; 
                ?> 
                  <span class="glyphicon glyphicon-check" aria-hidden="false"></span>
                <?php 
                } else {?>
                  <span class="glyphicon glyphicon-unchecked" aria-hidden="false"></span>
                <?php }; ?>
          </td>
          <td class="text-center"> 
                <?php
                  if ($item->fec_anul_cbte!=''){
                    $fechaAnul = new DateTime((string)$item->fec_anul_cbte);
                    echo $fechaAnul->format('d/m/y'); 
                  }
                ?> 
          </td>
          <td class="text-center">
                <?php 
                  if ($item->an_ajuste_cbte==1) {; 
                ?> 
                  <span class="glyphicon glyphicon-check" aria-hidden="false"></span>
                <?php 
                } else {?>
                  <span class="glyphicon glyphicon-unchecked" aria-hidden="false"></span>
                <?php }; ?>
          </td>
        </tr>
    <?php
    }
  }
  ?>
    </tbody>
    </table>
    </br>
    </div>
  </div>
  </div>
  </body>
</html>