<?php

  include("../../includes/iniciar_sesion.php");

  // Ante todo se debe validar que si el rol es CLIENTE, se deben setear variables iniciales ... //////////////////////////////////////////

  If ( $_SESSION["rol"] == 2 ){
    $codClienteLogIn   = intval($_SESSION["IdLogin"]);
  }

?>

<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>NeoSistemas SRL | Cuenta Corriente Clientes</title>

    <link rel="stylesheet" type="text/css" href="../../css/estilo.css">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.css" rel="stylesheet">

    <!-- Hoja de estilo de cuenta corriente -->
    <link href="../../css/ctacte-style.css" rel="stylesheet">

    <link href="../../css/custom.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../css/font-awesome.css" rel="stylesheet" type="text/css">

    <link href="../../css/input-decorations.css" rel="stylesheet">
    <link href="../../css/resaltador.css" rel="stylesheet">    
    <link href="../../css/estiloCtaCte.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/jquery-1.10.2.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../css/all.min.css" />
    <script type="text/javascript" src="../../js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="../../js/jszip.min.js"></script>

    <?php

    if (isset($_REQUEST['buscar'])){ // BUSCAR CLIENTES /////////////////////////////////////////////////

    // SI BUSCO CLIENTES, LA VENTANA DE BUSQUEDA DEBE PERMANECER ABIERTA ... ////////////////////////////

      echo "
        <script>
          $(function(){
            $('#buscarClientes').attr('class','modal');
            $('#buscarClientes').modal('show');
          });
        </script>
        ";

    }else{

      echo "
        <script>
          $(function(){
            $('#buscarClientes').attr('class','modal fade');
          });
        </script>
        ";
      }
    ?>

  </head>
  <body id="bodyCtaCte" style="background-color:#F3F3F4; ">
    <?php
      include("../../ventas/ventanas/consultaCbtes.php");
      include("../../ventas/ventanas/consultaRecibos.php");
      include("../../ventas/ventanas/buscadorClientes.php");
    ?>
    <div id="cargandoCtaCte" class="loading" style="visibility: hidden;">Loading&#8230;</div>
    <div class="row">
      <div class="panel-group" id="accordion" >
        <div class="panel panel-default" style="border-color: #A7BEE7; background-color: #A7BEE7; border-radius: 0px 0px 0px 0px " >
          <div id="mostrarOcultarFiltros" class="ibox-title" style="background-color:#2F4050;" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
            <h5 style="color:#DFE4ED;">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="color: #DFE4ED">
                Cuenta Corriente de Clientes
              </a>
            </h5>
          </div>
          <div id="collapse1" class="panel-collapse collapse in">
            <div class="ibox float-e-margins" style="margin-bottom: 0">
              <div id="menu" class="ibox-content" style="background-color: #A7BEE7; padding-left:0px; padding-right: 0px; padding-bottom: 3px; padding-top: 6px">
                <form id="filtros"
                      name="filtros" 
                      action="<?php echo $_SERVER['PHP_SELF'];?>"
                      method="POST">
                  <div class="row">
                    <div class="col-sm-4 b-r" style="padding-top:10px; padding-bottom:0px;">
                      <div class="col-md-12" style="padding: 0px;">
                          <div class='col-xs-12 col-sm-12 col-md-1 col-lg-1' style='text-align: left; width: 50px; padding-left: 0px; padding-right: 2px;' >
                            <label style="color: black; font-size: 9pt; vertical-align: -webkit-baseline-middle" class="protected">Cliente</label>
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 estilo1' style="padding-left: 2px; padding-right: 2px">
                            <div class='input-group col-xs-12 col-sm-12 col-md-12 col-lg-12 estilo1' style=" padding-left: 2px; padding-right: 2px" > 
                              <input  id    = "codCliente" 
                                      name  = "codCliente"
                                      value ="<?php if(isset($codClienteLogIn)) echo $codClienteLogIn; ?>"
                                      class ="form-control"
                                      type  ="number" 
                                      style = "height: 22px; font-size: 9pt; padding: 1px" 
                                      onChange ="onChangeCliente()"
                                      <?php
                                        if (isset($codClienteLogIn)){
                                          echo "onfocus='this.blur()'' readonly='readonly'";
                                        }
                                      ?>
                                      >
                              <span class="input-group-btn">
                                <button type='button' 
                                        id='abrirBuscador'
                                        name="abrirBuscador"
                                        class='btn btn-xs btn-primary'
                                        <?php
                                        if (isset($codClienteLogIn)){
                                          echo "readonly='readonly' disabled = 'disabled'";
                                        }
                                        ?>
                                        data-toggle="modal" 
                                        data-target="#buscarClientes"
                                        >
                                  <span class="fa fa-search" ></span>
                                </button>
                              </span>
                            </div>
                          </div>
    <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                          <div class='col-xs-12 col-sm-12 col-md-7 col-lg-7 estilo1' style = "padding-left: 4px; padding-right: 4px; height: 22px; font-size: 9pt; ">
                            <div class='input-group col-xs-12 col-sm-12 col-md-12 col-lg-12' style="height: 22px; font-size: 9pt; background-color: #dce6f7; border-color: #dce6f7">
                              <p id="razonSocial" style="padding: 4px 0px 0px 0px; margin: 0px; white-space: nowrap; width: inherit;" class="protected">
                                <i id="cargandoDatosCli" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: hidden" ></i>
                              </p>
                            </div>
                          </div>
                      </div>
                      <div class='col-md-12' style="padding: 0px;">
                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='text-align: left; padding-right: 0px; padding-top: 8px; padding-left: 0px'>
                          <label style="vertical-align: top; text-align: left; font-size: 9pt; color: dark-grey;">- Domicilio: </label>
                          <p id="domicilioCliente" style="text-align: left; font-size: 9pt; color: dark-grey; margin-bottom: 0px"></p>
                        </div>
                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='text-align: left; padding-right: 0px; padding-left: 0px'>
                          <label style="vertical-align: top; padding-top: 5px; text-align: left; font-size: 9pt; color: dark-grey;">- Teléfonos: </label>
                          <p id="clientVtasTelef" style="padding-top: 5px; text-align: left; font-size: 9pt; color: dark-grey; margin-bottom:0px"></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4 b-r" style="padding-bottom: 0px; padding-right:0px; padding-left:0px">
                      <div class="col-sm-12" style="padding-bottom: 4px; padding-top: 10px; padding-right: 0px; padding-left: 0px;">
                        <div class='col-xs-12 col-sm-12 col-md-4 col-lg-3' style="text-align: left;">
                          <label style="color: black; font-size: 9pt; padding-top: 3px; margin-bottom: 4px">Fecha Desde</label>
                        </div>
                        <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'><input id    = "fechaDesde"
                                                                                  name  = "fechaDesde"
                                                                                  value = ""
                                                                                  style = "height: 22px; font-size: 9pt; padding-top: 0px !important; padding-bottom: 0px !important; border-top: 0px !important; border-bottom: 0px !important"
                                                                                  type  = "Date" 
                                                                                  class = "form-control">
                        </div>
                      </div>
                      <div class="col-sm-12" style="padding-bottom: 4px; padding-right: 0px; padding-left: 0px;">
                        <div class='col-xs-12 col-sm-12 col-md-4 col-lg-3' style="text-align: left;">
                          <label style="color: black; font-size: 9pt; padding-top: 3px; margin-bottom: 4px">Fecha Hasta</label>
                        </div>
                        <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'><input id    = "fechaHasta"
                                                                                  name  = "fechaHasta"
                                                                                  value = ""
                                                                                  style = "height: 22px; font-size: 9pt; padding-top: 0px !important; padding-bottom: 0px !important; border-top: 0px !important; border-bottom: 0px !important"    
                                                                                  type  = "Date" 
                                                                                  class = "form-control">
                        </div>
                      </div>
                      <div class="col-sm-12" style="padding-bottom: 15px; padding-right: 0px; padding-left: 0px;">
                        <div class='col-xs-12 col-sm-12 col-md-4 col-lg-3' style="text-align: left;">
                          <label style="padding-top: 5px; color: black; font-size: 9pt; padding-top: 3px; margin-bottom: 4px">Orden</label>
                        </div>
                        <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'>
                          <select style="font-size: 9pt; height: 22px; padding-top: 0; padding-bottom: 0;" name="orden" class="form-control" id="orden">
                            <option value="1" selected="selected">Cronol&oacute;gico</option>
                            <option value="2">Imputaci&oacute;n</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2 b-r" style="padding-left: 15px; padding-right: 0px">
                      <div class="estiloCtaCte1 col-sm-12" style="padding-top: 15px;">
                        <div class="marginLabel_3 col-md-4" style="text-align: left; padding-left: 0; padding-right: 0; display: inline-flex;">
                          <div class="switch__container" style="margin: 0 !important;">
                            <input id="noAnulados" class="switch switch--shadow" type="checkbox" name="noAnulados">
                            <label for="noAnulados"></label>
                          </div>
                        </div>
                        <div class="marginLabel_2 col-md-8" style="text-align: left; font-size: 12px; padding-left: 2px; padding-right: 0; ">
                          <label for="noAnulados" class="noAnulados" style="padding-top: 3px; color: black; font-size: 9pt;">Excluir anul.</label>
                        </div>
                      </div>
                      <div class="col-sm-12" style="padding-left: 0; padding-right: 0; padding-bottom: 15px">
                      </div>
                      <div class="col-sm-12 estiloCtaCte1" style="padding-bottom: 19px">
                        <div class="marginLabel_3 col-md-4" style="text-align: left; padding-left: 0; padding-right: 0; display: inline-flex;">
                          <div class="switch__container" style="margin: 0 !important;">
                            <input id="noCancelados" class="switch switch--shadow" type="checkbox" name="noCancelados">
                            <label for="noCancelados"></label>
                          </div>
                        </div>
                        <div class="marginLabel_2 col-md-8" style="text-align: left; font-size: 12px; padding-left: 2px; padding-right: 0; ">
                          <label for="noCancelados" class="noCancelados" style="padding-top: 3px; color: black; font-size: 9pt;">Excluir cancel.</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button id="recuperar" 
                                name="recuperar" 
                                style="padding: 5px 0px 5px 0px;" 
                                class="btn btn-xs btn-primary btn-block" 
                                type="button" 
                                onclick="recuperarCuentaCorriente()">
                          <strong> Recuperar</strong>
                        </button>
                        <button id="cancelar" 
                                name="cancelar" 
                                style="padding: 5px 0px 5px 0px;" 
                                class="btn btn-xs btn-primary btn-block" 
                                type="submit"
                                <?php
                                  if (isset($codClienteLogIn)){
                                    echo "readonly='readonly' disabled = 'disabled'";
                                  }
                                ?>>
                          <strong> Cancelar</strong>
                        </button>
                        <button id="exportaPDF" 
                                name="exportaPDF"
                                style="padding: 5px 0px 5px 0px;" 
                                class="btn btn-xs btn-primary btn-block" 
                                type="button"
                                onclick="imprimirCtaCte()">
                          <strong> Imprimir</strong>
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="divHeaderDeImpresion" style="display: none; text-align: center">
        <p id="headerDeImpresion"></p>
      </div>
    </div>
    <div id="filasCtaCte" clas="row"> 
      <div class="container-fluid" style="padding-right: 0px; padding-left: 0px">
        <div id="menu" class="row collapse" style="height: 200px;">
        </div>
        <div class="row">
          <table class="table table-hover tablaGeneral" id="cuentaCorriente" name="cuentaCorriente">
            <thead style="background-color: lightgrey;">
              <tr>
                <th class="text-center descarto">   <strong>Fecha </strong></th>
                <th class="text-center soloMobile"> <strong>Fecha </strong></th>
                <th class="text-center descarto" colspan="3"> <strong> Comprobante </strong> </th>
                <th class="text-center soloMobile"> <strong> Comprobante </strong> </th>
                <th class="text-center descarto">   <strong>Fecha Vto. </strong></th>
                <th class="text-center descarto">   <strong>Debe </strong></th>
                <th class="text-center descarto">   <strong>Haber </strong></th>
                <th class="text-center soloMobile"> <strong>Monto </strong></th>
                <th class="text-center descarto">   <strong>Saldo </strong></th>
                <th class="text-center soloMobile"> <strong>Saldo </strong></th>
                <th class="text-center descarto" colspan="3"> <strong>Cancelado </strong></th>
                <th class="text-center descarto">   <strong>Ajuste</strong></th>
                <th class="text-center"></th>
              </tr>
            </thead>
            <tbody id="cuentaCorrienteBody" name="cuentaCorrienteBody">

            </tbody>
          </table>
          </br>
        </div>
      </div>
    </div>
    <script src="../../js/funcionesComunes.js"></script>
    <script src="../../ventas/js_ventas/funcionesCtaCte.js"></script>
    <script type="text/javascript">
      
    // PREVENIR SUBMIT DE FORMULARIO CUANDO SE PRESIONA ENTER DESDE ALGUNOS CONTROLES...

    $(document).ready(function() {
      $("#codCliente").keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
           $("#fechaDesde").focus();
          return false;
        }
      });
    });

    </script>
    <?php
    if ( isset ( $codClienteLogIn ) ){
      echo '<script type="text/javascript">onChangeCliente();document.getElementById("fechaDesde").focus();</script>';
    }else{
      echo '<script type="text/javascript">document.getElementById("codCliente").focus();</script>';
    }
    ?>
  </body>
</html>