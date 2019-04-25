<?php

  include("../../includes/iniciar_sesion.php");

  // Ante todo se debe validar que si el rol es CLIENTE, se deben setear variables iniciales ... //////////////////////////////////////////

  If ( $_SESSION["rol"] == 2 ){
    $codClienteLogIn   = intval($_SESSION["IdLogin"]);
  }

  If ( $_SESSION["rol"] == 3 ){
    $codVendedorLogIn   = intval($_SESSION["IdLogin"]);
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

    <title>NeoSistemas SRL | Generación de Pedidos</title>



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
    <script src="../../js/notify.js"></script>

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
  <style type="text/css">
    .form-control[disabled], fieldset[disabled] .form-control {
      cursor: default;
    }
    .btn.disabled, .btn[disabled], fieldset[disabled] .btn {
    cursor: default;
    }

    @media (max-width: 992px) {
     .estilo1 {
        padding-right: 0px !important; 
        padding-left: 0px !important; 
        text-align: left !important;
    }
  </style>

  </head>
  <body id="bodyCtaCte" style="background-color:#F3F3F4; ">
    <?php
      include("../../ventas/ventanas/consultaCbtes.php");
      include("../../ventas/ventanas/consultaRecibos.php");
      include("../../ventas/ventanas/buscadorClientes.php");
      include("../../comercial/ventanas/buscadorArticulos.php");
    ?>
    <div id="cargandoPedido" class="loading" style="visibility: hidden;">Loading&#8230;</div>
    <div class="row">
      <div class="panel-group" id="accordion" style="margin-bottom: 1px" >
        <div class="panel panel-default" style="border-color: #A7BEE7; background-color: #A7BEE7; border-radius: 0px 0px 0px 0px " >
          <div class="ibox-title" style="background-color:#2F4050;" data-toggle="collapse" data-parent="#accordion" href="#collapse1">          
            <h5 style="color:#DFE4ED;">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="color: #DFE4ED">
                Generación de Pedidos
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
                    <div id="opciones" class="col-xs-12 col-sm-12 col-md-11 col-lg-11 b-r" style="padding-top:0px; padding-bottom:0px; padding-right:0px;padding-left:0px">
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' <?php if($_SESSION['rol']==2){echo "style='display: none'";}; ?>>
                        <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6' style="padding: 0!important; margin: 0">
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
                              <p id="razonSocial" style="padding: 4px 0px 0px 0px; margin: 0px" class="protected"><i id="cargandoDatosCli" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: hidden"></i></p>
                            </div>
                          </div>
                        </div>
    <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                        <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6' style="padding: 0; margin: 0">
                          <div class='col-xs-1 col-sm-1 col-md-1 col-lg-1' style='padding:0px 4px 0px 0px; text-align: left' >
                            <label style="color: black; font-size:9pt; vertical-align: -webkit-baseline-middle" class="protected">Vendedor</label>
                          </div>                     
                          <div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 estPedido2' style="padding-right: 4px">
                            <select id = "listaVendedores" 
                                    value = "" 
                                    class ="form-control" 
                                    style = "padding-top: 0; padding-bottom: 0;height: 22px; font-size: 9pt;"
                                    <?php
                                      if ($_SESSION["rol"] == 2 || $_SESSION["rol"] == 3){
                                        echo "readonly='readonly' disabled = 'disabled'";
                                      }
                                    ?>
                                    >
                            </select>
                          </div>
                        </div>
                      </div>
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding-top: 5px">
                        <hr style="padding: 0; margin-top: 0; margin-bottom: 10px <?php if($_SESSION['rol']==2){echo '; display: none';}; ?> ">
                        <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6' style="padding:0px">

                          <div class='col-xs-12 col-sm-12 col-md-1 col-lg-1' style='text-align: left; width: 50px; padding-left: 0px; padding-right: 2px' >
                            <label style="color: black; font-size: 9pt; vertical-align: -webkit-baseline-middle" class="protected">Artículo</label>
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 estilo1' style="padding-left: 2px; padding-right: 2px">
                            <div class='input-group col-xs-12 col-sm-12 col-md-12 col-lg-12 estilo1' style=" padding-left: 2px; padding-right: 2px" > 
                              <input  id    = "articCodAdmin" 
                                      name  = "articCodAdmin"
                                      class ="form-control"
                                      type  ="text" 
                                      autocomplete="off" 
                                      style = "height: 22px; font-size: 9pt; padding: 1px" 
                                      onChange ="onChangeArticulos()"
                                      disabled="disabled">
                              <span class="input-group-btn">
                                <button type='button' 
                                        id='buscaArtic'
                                        name='buscaArtic'
                                        class='btn btn-xs btn-primary'
                                        data-toggle="modal" 
                                        data-target="#buscarArticulos"
                                        disabled="">
                                  <span class="fa fa-search" ></span>
                                </button>
                              </span>
                            </div>
                          </div>
                           <div class='col-xs-12 col-sm-12 col-md-7 col-lg-7 estilo1' style = "padding-left: 4px; padding-right: 4px; height: 22px; font-size: 9pt; ">
                            <div class='input-group col-xs-12 col-sm-12 col-md-12 col-lg-12 estilo1' style="height: 22px; font-size: 9pt; background-color: #dce6f7; border-color: #dce6f7">
                              <p id="articDesc" style="padding: 4px 0px 0px 0px; margin: 0px" class="protected"><i id="cargandoDatosArtic" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: hidden"></i></p>
                            </div>
                          </div>
                        </div>
                        <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6' style="padding:0px">
                          <div class='col-xs-12 col-sm-12 col-md-11 col-lg-11' style="padding-left: 0px; padding-right: 4px">
                            <div class='col-xs-1 col-sm-1 col-md-1 col-lg-1' style='padding:0px 2px 0px 0px; margin: 0; text-align: left;' >
                              <label style="color: black; font-size: 9pt; vertical-align: -webkit-baseline-middle" class="protected">Precio</label>
                            </div>
                            <div class='col-xs-12 col-sm-12 col-md-1 col-lg-1 estPedido1' style = "padding: 0px 2px 0px 2px; padding-left: 2px; padding-right: 2px; height: 22px; font-size: 9pt; background-color: #dce6f7; border-color: #dce6f7">
                              <p id="articPrecVta" style="padding: 3px 0px 0px 0px; text-align: right" class="protected"> 0.00  </p>
                              <p id="alicIvaCod" style="padding: 3px 0px 0px 0px; text-align: right; display: none" class="protected"> 0.00  </p>
                            </div>
                            <div class='col-xs-1 col-sm-1 col-md-1 col-lg-1 estilo1' style='margin: 0; text-align: right' >
                              <label style="color: black; font-size: 9pt; vertical-align: -webkit-baseline-middle" class="protected">Cant.</label>
                            </div>
                            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 estilo1' style="padding-right: 2px">
                              <input  id    = "cantidad" 
                                      name  = "cantidad"
                                      class ="form-control"
                                      type  ="number" 
                                      pattern="[0-9]*" 
                                      inputmode="numeric"
                                      style = "height: 22px; font-size: 9pt; text-align: right; padding-left: 2px; padding-right: 2px"
                                      onChange ="calcularTotal()"
                                      onKeyPress =""
                                      disabled = "disabled">
                            </div>
                            <div class='col-xs-1 col-sm-1 col-md-1 col-lg-1 estilo1' style='margin: 0; text-align: right; <?php if($_SESSION['rol']==2){echo "display: none";};?>' >
                              <label style="color: black; font-size: 9pt; vertical-align: -webkit-baseline-middle; margin-right: 2px;" class="protected">%Dto.</label>
                            </div>
                            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 estilo1' style="padding-right: 2px; text-align: right; <?php if($_SESSION['rol']==2){echo "display: none";};?>">
                              <input  id    = "descuento" 
                                      name  = "descuento"
                                      class ="form-control"
                                      type  ="number" 
                                      pattern="[0-9]*" 
                                      inputmode="numeric"
                                      style = "height: 22px; font-size: 9pt; text-align: right; padding-left: 2px; padding-right: 2px" 
                                      onChange ="calcularTotal()"
                                      onKeyPress =""
                                      disabled = "disabled"
                                      <?php
                                      if (isset($codClienteLogIn)){
                                        echo "onfocus='this.blur()'' readonly='readonly'";
                                      }
                                      ?>
                                      >
                            </div>
                            <div class='col-xs-1 col-sm-1 col-md-1 col-lg-1 estilo1' style='padding:0px 4px 0px 0px; margin: 0; text-align: right' >
                              <label style="color: black; font-size: 9pt; vertical-align: -webkit-baseline-middle" class="protected">Total</label>
                            </div>
                            <div class='col-xs-12 col-sm-12 col-md-1 col-lg-1 estPedido1' style = "padding: 0px 2px 0px 2px; padding-left: 2px; padding-right: 2px; height: 22px; font-size: 9pt; background-color: #dce6f7; border-color: #dce6f7">
                              <p id="artiMontoTotal" style="padding: 3px 0px 0px 0px; text-align: right" class="protected"> 0.00  </p>
                            </div>
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-1 col-lg-1' style="padding-left: 4px; padding-right: 4px">
                            <button id="agregar" 
                                    name="agregar" 
                                    class="btn btn-xs btn-primary btn-block descarto" 
                                    type="button" 
                                    disabled="disabled"
                                    onclick="agregarItem(<?php echo $_SESSION["rol"]; ?>)">
                              <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                    <div id="botones" class="col-xs-12 col-sm-12 col-md-1 col-lg-1">

                        <button id="agregarMobile" 
                                name="agregarMobile" 
                                disabled="disabled"
                                style="padding: 5px 0px 5px 0px; margin-top: 10px" 
                                class="btn btn-xs btn-primary btn-block soloMobile" 
                                type="button" 
                                onclick="agregarItem(<?php echo $_SESSION["rol"]; ?>)">
                          <strong> Agregar</strong>
                        </button>
                        <hr class="soloMobile" style="padding: 0; margin-top: 0; margin-bottom: 10px">
                        <button id="aceptar" 
                                name="aceptar" 
                                style="padding: 5px 0px 5px 0px;" 
                                class="btn btn-xs btn-primary btn-block" 
                                type="button" 
                                onclick="generarPedido()">
                          <strong> Aceptar</strong>
                        </button>
                        <button id="cancelar" 
                                name="cancelar" 
                                style="padding: 5px 0px 5px 0px; <?php if($_SESSION['rol']==2){echo "display: none";};?>" 
                                class="btn btn-xs btn-primary btn-block" 
                                type=""
                                <?php
                                  if (isset($codClienteLogIn)){
                                    echo "readonly='readonly' disabled = 'disabled'";
                                  }
                                ?>>
                          <strong> Cancelar</strong>
                        </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div clas="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="col-xs-12 col-sm-12 col-md-6" style="padding-right: 0px;">
          <table class="table-condensed">
            <tbody>
              <tr>
                <th><strong>Dto. General:</strong></th>
                <th id="descuentoGeneral" >0.00</th>
                <th><strong>Monto Neto:</strong></th>
                <th id="subtotal">0.00</th>
                <th><strong>Total:</strong></th>
                <th id="montoFinal">0.00</th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>    
    </div>
    <div id="" clas="row">
      <div class="container-fluid" style="padding-right: 0px; padding-left: 0px">
        <div id="menu" class="row collapse" style="height: 200px;">
        </div>
        <div class="row">
          <table class="table table-hover tablaGeneral" id="detallePedido">
            <thead style="background-color: lightgrey;">
            <tr>
              <th class="text-center descarto protected" id="t_codAdmin"      > <strong>Cód. Artículo </strong></th>
              <th class="text-center descarto protected" id="t_descripcion" colspan="3"> <strong> Descripción </strong> </th>
              <th class="text-center descarto protected" id="t_precioUnitario"> <strong> Precio Unitario </strong> </th>
              <th class="text-center descarto protected" id="t_cantidad"      > <strong> Cantidad </strong></th>
              <th class="text-center descarto protected" id="t_descuento"     > <strong> % Descuento </strong></th>
              <th class="text-center descarto protected" id="t_total"         > <strong> Subtotal </strong></th>
              <th class="text-center descarto protected" id="t_total"         > <strong> IVA </strong></th>
              <th class="text-center descarto protected" id="t_total"         > <strong> Total </strong></th>
              <th class="text-center descarto protected"></th>

              <th class="text-center soloMobile" style="font-size: 12px"> <strong>Cód. </strong></th>
              <th class="text-center soloMobile" colspan="3" style="font-size: 12px"> <strong> Descripción </strong> </th>
              <th class="text-center soloMobile" style="font-size: 12px"> <strong> Cant. </strong></th>
              <th class="text-center soloMobile" style="font-size: 12px"> <strong> Subtotal </strong></th>
              <th class="text-center soloMobile" style="font-size: 12px"> <strong> IVA </strong></th>
              <th class="text-center soloMobile" style="font-size: 12px"> <strong> Total </strong></th>
              <th class="text-center soloMobile" style="font-size: 12px"></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          </br>
        </div>
      </div>
    </div>
<!-- ______________________________________________________________CONCEPTO______________________________________________________________ -->
<!-- ______________________________________________________________CONCEPTO______________________________________________________________ -->
<!-- ______________________________________________________________CONCEPTO______________________________________________________________ -->
<!-- ______________________________________________________________CONCEPTO______________________________________________________________ -->

    <div class="modal fade" id="agregarConcepto" name="agregarConcepto" role="dialog">
      <div class="modal-dialog" style="overflow-y: initial;">
        <div class="modal-content">
          <form id="busqueda"
                name="busqueda" 
                action="<?php echo $_SERVER['PHP_SELF'];?>"
                method="POST">
            <div class="modal-header" style="padding:10px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff !important; text-shadow: none !important; opacity:1;">&times;</button>
                <h4><span class="glyphicon glyphicon-pencil"></span> Agregar Concepto</h4>
            </div>
            <div class="modal-body" style="padding:10px 10px 10px; overflow-y: initial">            
              <div class="col-sm-12">
                <div class="form-group">
                  <textarea class="form-control" 
                            rows="5"  
                            id = "descripcionConcepto" 
                            placeholder = "Descripci&oacute;n"></textarea>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <input type="number" step="0.01"
                         class = "form-control" 
                         id    = "precioUnitConcepto" 
                         name  = "precioUnitConcepto" 
                         placeholder = "Precio Unit." 
                         onChange="calcularTotalConcepto()"
                         style="text-align: left">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <input type="number" step="0.01"
                         class = "form-control" 
                         id    = "cantidadConcepto" 
                         name  = "cantidadConcepto" 
                         placeholder = "Cantidad" 
                         onChange="calcularTotalConcepto()"
                         style="text-align: left">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <select id = "alicuotaConcepto" value = "" class ="form-control" style = "padding-top: 0; padding-bottom: 0; padding-left: 2px">
                    <option value="1">IVA 21.00 %</option>
                    <option value="4">IVA 10.50 %</option>
                    <option value="5">IVA 27.00</option>
                    <option value="6">IVA 2.50</option>
                    <option value="3">IVA Exento</option>

                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <input type  = "number" 
                         class = "form-control" 
                         id    = "totalConcepto" 
                         name  = "totalConcepto" 
                         placeholder = "Total" 
                         readonly="readonly"
                         style="text-align: left">
                </div>
              </div>

              <button id="" name="" style="padding: 5px 30px 5px 30px; margin-left: 15px; position: center" class="btn btn-xs btn-primary" type="button" onclick="agregarConcepto()"><span class="glyphicon glyphicon-plus"></span><strong> Agregar</strong></button>
            </div>
          </form>
        </div>
      </div>
    </div>

<!-- ______________________________________________________________CONCEPTO______________________________________________________________ -->
<!-- ______________________________________________________________CONCEPTO______________________________________________________________ -->
<!-- ______________________________________________________________CONCEPTO______________________________________________________________ -->
<!-- ______________________________________________________________CONCEPTO______________________________________________________________ -->

    <div class="modal fade" id="generandoPedido" name="generandoPedido" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="tituloMensajePedido" class="modal-title">Procesando</h4>
          </div>
          <div class="modal-body">
            <p id="mensajePedido">Estamos generando su pedido. Por favor aguarde... 
              <p id="procesandoPedido" style="text-align: center; position: center">
                <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
              </p>
            </p>
          </div>
          <div class="modal-footer" style="display: none" id="botonMensajePedido">
            <button id="finalizar" 
                    name="finalizar" 
                    style="padding: 5px 0px 5px 0px;" 
                    class="btn btn-xs btn-primary btn-block" 
                    onClick="location.reload();">
              <strong> Aceptar</strong>
            </button>
          </div>
        </div>
      </div>
    </div>

    <footer class="navbar-default navbar-fixed-bottom">
      <div class="container-fluid">
        <div class="row">
        </div>
      </div>
    </footer>

    <script src="../../js/funcionesComunes.js"></script>
    <script src="../../ventas/js_ventas/funcionesPedidos.js"></script>
    <?php
    if ( isset ( $codClienteLogIn ) ){
      echo '<script type="text/javascript">onChangeCliente();</script>';
    }
    ?>
    <script type="text/javascript">      
    <?php
      if ($_SESSION["rol"] == 1){
        // ADMINISTRADOR - USUARIO DEL SISTEMA
        echo "recuperarVendedores()";
      }elseif($_SESSION["rol"] == 2){
        // CLIENTE
        echo "recuperarVendedorCliente(" . $codClienteLogIn . ")";
      }elseif($_SESSION["rol"] == 3){
        // VENDEDOR
        echo "recuperarVendedorActual(" . $codVendedorLogIn . ")";
      }
    ?>
    </script>

    <script type="text/javascript">

    // PREVENIR SUBMIT DE FORMULARIO CUANDO SE PRESIONA ENTER DESDE ALGUNOS CONTROLES...

    $(document).ready(function() {
      $("#codCliente").keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
           $("#articCodAdmin").focus();
          return false;
        }
      });
      $("#articCodAdmin").keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          $("#cantidad").focus();
          return false;
        }
      });
      $("#cantidad").keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          $("#descuento").focus();
          return false;
        }
      });
      $("#descuento").keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          $("#agregar").focus();
          return false;
        }
      });
    });

    </script>

  </body>
</html>