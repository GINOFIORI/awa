<?php

  include ("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

  $codRol   = $_SESSION["rol"];

?>

</script>

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

    <title>NeoSistemas SRL | Reporte Global de Saldo de Clientes </title>
 
    <link href="../../css/estilo.css" rel="stylesheet" type="text/css" />
    <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../../css/navbar-fixed-top.css" rel="stylesheet">
    <link href="../../css/custom.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="../../css/bootstrap-toggle2.css" rel="stylesheet">
    <link href="../../css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="../../css/resaltador.css" rel="stylesheet" type="text/css">

    <style type="text/css">
      
      td {
        font-size: 10pt;
      }

    </style>

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
  <body class="bodyReporte" style="background-color: #f3f3f4 !important;">
    <?php
      include("../../ventas/ventanas/buscadorClientes.php");
    ?>
   <div id="cargandoReporte" class="loading" style="visibility: hidden;">Loading&#8230;</div>
   <div class="panel-group" id="accordion">
      <div class="panel panel-default" style="border-color: #A7BEE7; background-color: #A7BEE7; border-radius: 0px 0px 0px 0px " >
        <div class="ibox-title" style="background-color:#2F4050;" data-toggle="collapse" data-parent="#accordion" href="#collapse1">          
          <h5 style="color:#DFE4ED;">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="color: #DFE4ED">Reporte Global de Saldo de Clientes</a>
          </h5>
        </div>
        <div id="collapse1" class="panel-collapse collapse in">
          <div class="ibox float-e-margins" style="margin-bottom: 0">        
            <div class="ibox-content" style="background-color: #A7BEE7; padding-left:0px; padding-right: 0px; padding-bottom: 0px; padding-top: 10px; height: auto;">
              <form id="filtros" name="filtros" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
                <div class="row" style="height: auto;">
                  <div class="height_1 col-xs-12 col-sm-5 col-md-5 col-lg-5 b-r"  style=" padding: 0px; line-height: 2;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding: 0px;">
                        <div class='col-xs-12 col-sm-5 col-md-5 col-lg-5' style='text-align: left; padding-left: 0; padding-right: 0;'>
                          <label style="color: black; font-size: 9pt;">Fecha Ref.</label>
                        </div>
                        <div class='col-xs-12 col-sm-7 col-md-7 col-lg-7 estSaldo1' style=" padding-right: 0; text-align: left;">
                          <div class='input-group col-xs-12 col-sm-11 col-md-11 col-lg-11' style="display: inline-block;" > 
                            <input id    = "fechaReferencia"
                                   name  = "fechaReferencia"
                                   value = "<?php if(!isset($fechaReferencia)) echo  date("Y-m-d"); ?>"
                                   style = "height: 22px; font-size: 9pt;  padding-bottom: 0px !important; padding-top: 0px !important;"
                                   type  = "Date" 
                                   class = "form-control unstyled">
                            </div>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding: 0px;">
                        <div class='padMargen col-xs-12 col-sm-5 col-md-5 col-lg-4 estSaldo2' style='text-align: left; padding-right: 0;'>
                          <label style="color: black; font-size: 9pt;">Tipo Listado</label>
                        </div>
                        <div class='col-xs-12 col-sm-7 col-md-7 col-lg-8' style="padding-left: 0px; padding-right: 0; text-align: left;">
                          <div class="input-group col-xs-12 col-sm-11 col-md-11 col-lg-11" style="padding-left: 1px;">
                           <select style="font-size: 9pt; height: 22px; padding-top: 0; padding-bottom: 0;" name="tipoListado" class="form-control" id="tipoListado">
                              <option <?php if((isset($tipoListado)) && ($tipoListado=="1"))echo 'selected="selected"'; ?> value="2">Resumido</option>
                              <option <?php if((isset($tipoListado)) && ($tipoListado=="2"))echo 'selected="selected"'; ?> value="3">Detallado</option>
                          </select>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="pad16 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding: 0px;">
                        <div class='col-xs-12 col-sm-5 col-md-5 col-lg-5' style='text-align: left; padding-left: 0; padding-right: 0;'>
                          <label style="color: black; font-size: 9pt;">Orden Listado</label>
                        </div>
                        <div class='col-xs-12 col-sm-7 col-md-7 col-lg-7 estSaldo1' style="padding-right: 0; text-align: left;">
                          <div class="input-group col-xs-12 col-sm-11 col-md-11 col-lg-11">
                           <select style="font-size: 9pt; height: 22px; padding-top: 0; padding-bottom: 0;" name="tipoOrden" class="form-control" id="tipoOrden">
                              <option <?php if((isset($tipoOrden)) && ($tipoOrden=="1"))echo 'selected="selected"'; ?> value="1">Código cliente</option>
                              <option <?php if((isset($tipoOrden)) && ($tipoOrden=="2"))echo 'selected="selected"'; ?> value="2">Descripción Cliente</option>
                          </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding: 0px;">
                        <div class='padMargen col-xs-12 col-sm-5 col-md-5 col-lg-4 estSaldo2' style='text-align: left; padding-right: 0;'>
                          <label style="color: black; font-size: 9pt;">Tipo Saldos</label>
                        </div>
                        <div class='col-xs-12 col-sm-7 col-md-7 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left;">
                          <div class="input-group col-xs-12 col-sm-11 col-md-11 col-lg-11" style="padding-right: 1px;">
                           <select style="font-size: 9pt; height: 22px; padding-top: 0; padding-bottom: 0;" name="tipoSaldos" class="form-control" id="tipoSaldos">
                              <option <?php if((isset($tipoSaldos)) && ($tipoSaldos=="1"))echo 'selected="selected"'; ?> value="1">Saldos positivos y negativos</option>
                              <option <?php if((isset($tipoSaldos)) && ($tipoSaldos=="2"))echo 'selected="selected"'; ?> value="2">Saldos positivos</option>
                              <option <?php if((isset($tipoSaldos)) && ($tipoSaldos=="3"))echo 'selected="selected"'; ?> value="3">Saldos negativos</option>
                          </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="height_1 pad8 col-xs-12 col-sm-5 col-md-5 col-lg-5  b-r" style="padding: 0px; ">
                    <div class="col-xs-12 col-sm-12">
                      <div class='est1 col-xs-12 col-sm-6 col-md-6 col-lg-6' style="text-align: left; padding-left: 0; display: inline-flex; padding-right: 5px;">
                        <div class='pad18 col-xs-1 col-sm-2 col-md-2 col-lg-2' >
                           <div class="switch__container" style="margin: 0px !important;" >
                            <input id="seleccionarCliente" class="switch switch--shadow" type="checkbox" name="seleccionarCliente" onchange="buscadorCliente(this.checked)">
                            <label for="seleccionarCliente"></label>
                          </div>
                        </div>
                        <div class='pad4 col-xs-4 col-sm-5 col-md-6 col-lg-5' style="float: left;"  >
                          <label for="seleccionarCliente" style="padding-top: 5px; color: black; font-size: 9pt;">Un Cliente</label>
                        </div>
                        <div class='pad6 col-xs-7 col-sm-6 col-md-6 col-lg-6'>
                          <form class='navbar-form'>
                             <div class='input-group col-xs-12 col-sm-12 col-md-12 col-lg-12'> 
                                    <input  id       = "codCliente" 
                                            name     = "codCliente"
                                            disabled ="true"
                                            value    ="<?php if(isset($codClienteLogIn)) echo $codClienteLogIn; ?>"
                                            class    ="form-control"
                                            type     ="number" 
                                            style    = "height: 22px; font-size: 9pt; padding: 1px" 
                                            onChange ="onChangeCliente()";>
                                    <span class="input-group-btn">
                                      <button type='button' 
                                              id='buscarCli'
                                              name='buscarCl' 
                                              disabled="true" 
                                              class='btn btn-xs btn-primary'
                                              data-toggle="modal" 
                                              data-target="#buscarClientes"
                                              style="height: 22px;"
                                              >
                                    <span class="fa fa-search"></span>
                                  </button>
                                </span>
                              </div>
                          </form>
                        </div>
                      </div>
        <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                      <div class='pad7 col-xs-12 col-sm-6 col-md-6 col-lg-6' style = "height: 22px;font-size: 9pt;">
                        <div class='input-group col-xs-12 col-sm-12 col-md-12 col-lg-12' style="height: 22px; font-size: 9pt; background-color: #dce6f7; border-color: #dce6f7">
                          <p id="razonSocial" style="padding: 4px 0px 0px 0px; margin: 0px"><i id="cargandoDatosCli" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: hidden"></i></p>
                        </div>
                      </div>
                    </div>

                    <div class="pad9 col-xs-12 col-sm-12 ">
                      <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3' style="text-align: left; padding-left: 0; padding: 0;">
                        <div class='est6 col-xs-1 col-sm-2 col-md-2 col-lg-2' style="padding: 0; width: 25%;  display: inline-block; padding-right: 15px;float: left;">
                          <div class="switch__container" style="margin: 0px !important;" >
                            <input id="separarVendedores" class="switch switch--shadow"  type="checkbox" name="separarVendedores" onchange="checkbox_vendedores(this.checked);"
                            <?php
                                  if ($_SESSION["rol"] == 3){
                                    echo "readonly='readonly' disabled = 'disabled'";
                                  }
                                ?> >
                            <label for="separarVendedores"></label>
                          </div>
                        </div>
                        <div class='est5 col-xs-3 col-sm-6 col-md-8 col-lg-8' style="float: left; "  >
                          <label for="separarVendedores" style="padding-top: 5px; color: black; font-size: 9pt;">Separar Vendedores</label>
                        </div>                  
                      </div>
                     <!-- <div > -->
                        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' style='text-align: center; padding-left: 18px; padding-right: 0px; '>
                          <div class='col-xs-12 col-sm-12 col-md-9 col-lg-9' style="padding: 0; float: left; margin-left: -6px; ">
                            <div class="custom-control custom-checkbox">
                              <input id="todosVendedores" type="checkbox" checked="true" class="custom-control-input" disabled="disabled" onchange="habilitarVendedores(this.checked);" style="vertical-align: middle;">
                              <label class="custom-control-label" for="todosVendedores" style="color:black; font-size: 9pt; vertical-align: sub;">Todos</label>
                            </div>
                          </div>
                        </div>

                        <div class='col-xs-9 col-sm-6 col-md-6 col-lg-6' style = "font-size: 9pt; padding: 0; display: inline-block;">
                          <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding: 0;" >
                            <select id = "listaVendedores" value = "" class ="form-control" disabled="true" style = "padding-top: 0; padding-bottom: 0;height: 22px; font-size: 9pt;"></select>
                          </div>
                        </div>
                   <!-- </div> -->
                 
                  </div>

                </div> <!--cierra div pad8 de filtros-->
             
                <div class="control-group pad15" >
                  <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" id="recuperar"> 
                    <button id="recuperar" 
                            name="recuperar" 
                            style="padding: 5px 30px 5px 30px;" 
                            class="btn btn-xs btn-primary btn-block" 
                            type="button"
                            onclick="recuperarSaldo(<?php echo $codRol; ?>)" >
                      <strong> Recuperar</strong>
                    </button>
                  </div>
                </div>
              </div>  
            </div> 
          </form>            
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
if (!(isset($tipoListado))) { ?>
<div class="row">
  <table class="table table-hover tablaGeneral" id="reporteSaldoCLi">
    <thead style="background-color: lightgrey;">
      <tr style="height: 33.33px;">
        <th class="text-center" id="encabezado1"> <strong></strong></th>
        <th class="text-center" id="encabezado2"> <strong></strong></th>
        <th class="text-center" id="encabezado3"> <strong></strong></th>
        <th class="text-center" id="encabezado4"> <strong></strong></th>
        <th class="text-center" id="encabezado5"> <strong></strong></th>
        <th class="text-center" id="encabezado6"> <strong></strong></th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>    
<?php } ?>

<script type="text/javascript" src="../../js/funcionesComunes.js"></script>
<script type="text/javascript" src="../../ventas/js_ventas/funcionesReporteSaldosCli.js"></script>
<script type="text/javascript">recuperarVendedores()</script>
<script type="text/javascript">
  
// PREVENIR SUBMIT DE FORMULARIO CUANDO SE PRESIONA ENTER DESDE ALGUNOS CONTROLES...

$(document).ready(function() {
  $("#codCliente").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
       $("#recuperar").focus();
      return false;
    }
  });
});

</script>
<?php
    if ( isset ( $codClienteLogIn ) ){
      echo '<script type="text/javascript">onChangeCliente();</script>';
    }else{
      echo '<script type="text/javascript">document.getElementById("codCliente").focus();</script>';
    }
?>

</body>
</html>