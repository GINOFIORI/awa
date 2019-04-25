<?php

  session_start();
  include("includes/conexionWS.php");

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

  $haySolicitud = sizeof($_REQUEST) > 0;

  if ($haySolicitud){
    $codCliente = recuperarValor ('codCliente');
    $fechaDesde = recuperarValor ('fechaDesde');
    $fechaHasta = recuperarValor ('fechaHasta');
    $orden      = recuperarValor ('orden');
    $modulo     = 3;
    $comando    = "CTACTECLI(" . $codCliente . "," . 1 . "," . date_format( $fechaDesde , "d/m/Y" ) . "," . date_format ( $fechaHasta , "d/m/Y" ). ")"; 

    $resultado = conexionWS ( $modulo , $comando );

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
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

  </head>
  <body style="background-color:#F3F3F4;">
    <div class="row">
      <div class="ibox float-e-margins" >
        <div class="ibox-title" style="background-color:#2F4050;">          
          <h5 style="color:#DFE4ED;">Cuenta Corriente de Clientes</h5>
        </div>
        <div class="ibox-content" style="background-color: #A7BEE7;">
          <form id="filtros"
                name="filtros" 
                action="<?php echo $_SERVER['PHP_SELF'];?>"
                method="POST">
            <div class="row">
              <div class="col-sm-6 b-r">
                <div class='col-md-12'> 
                  <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style="text-align: left;" >
                    <label for="codCliente" style="color: black; font-size: 8pt">Cliente</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-10 col-lg-10'>
                    <form class='navbar-form'>
                      <div class='input-group'> 
                        <input  id = "codCliente" 
                                name = "codCliente"
                                value ="<?php if(isset($codCliente)) echo $codCliente; ?>"
                                class ="form-control"
                                type ="text" 
                                placeholder="Ingresar Código"
                                style = "height: 22px; font-size: 9pt;" >
                        <span class="input-group-btn">
                          <button type='submit' class='btn btn-xs btn-primary' >
                            <span class="fa fa-search"></span>
                          </button>
                        </span>
                      </div>
                    </form>
                  </div>
                </div>
                <div class='col-md-12' style="padding-bottom: 4px;">
                  <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style="text-align: left;">
                    <label for="fechaDesde" style="color: black; font-size: 8pt">Fecha Desde</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'>
                    <input  id="fechaDesde"
                            name="fechaDesde"
                            value="<?php if(isset($fechaDesde)) echo $_REQUEST['fechaDesde']; ?>"
                            style = "height: 22px; font-size: 9pt;" 
                            type="Date" 
                            class="form-control">
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style="text-align: left;">
                    <label for="fechaHasta" style="color: black; font-size: 8pt">Fecha Hasta</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'>
                    <input  id="fechaHasta"
                            name="fechaHasta"
                            value="<?php if(isset($fechaHasta)) echo $_REQUEST['fechaHasta']; ?>"
                            style = "height: 22px; font-size: 9pt; "    type="Date" 
                            class="form-control">
                  </div>
                </div>
                <div class='col-md-12'>
                  <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style="text-align: left;">
                    <label style="padding-top: 5px; color: black; font-size: 9pt">Orden</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-10 col-lg-10'>
                      <select style="font-size: 9pt; height: 22px; padding-top: 0; padding-bottom: 0;" name="orden" class="form-control" id="orden">
                        <option <?php if((isset($orden)) && ($orden=="1"))echo 'selected="selected"'; ?>
                                value="1">
                          Cronol&oacute;gico
                        </option>
                        <option <?php if((isset($orden)) && ($orden=="2"))echo 'selected="selected"'; ?>
                                value="2">
                          Imputaci&oacute;n
                        </option>
                      </select>
                    <span class="input-group-btn">
                    </span>
                  </div>
                </div>
                <div class='col-md-12'>
                  <div class='col-xs-2 col-sm-2 col-md-2 col-lg-2' style="text-align: left;">
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-5 col-lg-5'>
                    <div class="checkbox" style="text-align: left;">
                      <label><input type="checkbox" value="">Excluir anulados</label>
                    </div>  
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-5 col-lg-5'>
                    <div class="checkbox" style="text-align: left;">
                      <label><input type="checkbox" value="">Excluir sin saldo</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div style="padding-top: 15px; text-align: left; font-size: 9pt; color: black;">- Razón Social: </div>
                <div style="padding-top: 5px; text-align: left; font-size: 9pt; color: black;">- Domicilio: </div>
                <div style="padding-top: 5px; text-align: left; font-size: 9pt; color: black;">- Localidad: </div>
                <div class="form-group col-sm-12">
                </div>
                <div>
                  <button style="padding: 5px 30px 5px 30px;" class="btn btn-sm btn-primary" type="submit"><strong>Recuperar</strong></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
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

  if ( !$haySolicitud ) {
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
  </body>
</html>