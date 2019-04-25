<?php

  include ("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");

  $modulo = 7;
 
  $comandoFamilias    = "FAMILIAS()";
  $datosFamilias      = conexionWS ( $modulo , $comandoFamilias );

  $comandoGrupos      = "GRUPOS(0)";
  $datosGrupos        = conexionWS ( $modulo , $comandoGrupos ); 

  if ( isset ( $datosFamilias->results_row->as_error_msg_js ) ) {
    echo '<script type="text/javascript"> alert("' . $datosFamilias->results_row->as_error_msg_js . '");</script>';
    die();
  }elseif ( isset ( $datosGrupos->results_row->as_error_msg_js ) ) {
    echo '<script type="text/javascript"> alert("' . $datosGrupos->results_row->as_error_msg_js . '");</script>';
    die();
  }

  $DatosGruposCodFam  = array();
  $DatosGruposCodGrp  = array();
  $DatosGruposDescGrp = array();
  $DatosGruposActGrp  = array();

  $recorre = 0;

  foreach($datosGrupos->results_row as $item){
    $DatosGruposCodFam[$recorre]  = (integer) $item->familartcod;
    $DatosGruposCodGrp[$recorre]  = (integer) $item->gruposartcod;
    $DatosGruposDescGrp[$recorre] = (string)  $item->gruposartdesc;
    $DatosGruposActGrp[$recorre]  = (integer) $item->gruposartactivo;
    $recorre++; 
  }

  // Ante todo se debe validar que si el rol es CLIENTE, se deben setear variables iniciales ... //////////////////////////////////////////

  $codRol   = $_SESSION["rol"];
 
?>

<script type="text/javascript">  

    var DatosGruposCodFam=<?php echo json_encode($DatosGruposCodFam);?>;
    var DatosGruposCodGrp=<?php echo json_encode($DatosGruposCodGrp);?>;
    var DatosGruposDescGrp=<?php echo json_encode($DatosGruposDescGrp);?>;
    var DatosGruposActGrp=<?php echo json_encode($DatosGruposActGrp);?>; 
 
    function CargarGrupos(familia_sel) 
    {

      var DatosGruposCodFam=<?php echo json_encode($DatosGruposCodFam);?>;
      var DatosGruposCodGrp=<?php echo json_encode($DatosGruposCodGrp);?>;
      var DatosGruposDescGrp=<?php echo json_encode($DatosGruposDescGrp);?>;
      var DatosGruposActGrp=<?php echo json_encode($DatosGruposActGrp);?>; 
      var cantgrupos = 1;

      if (familia_sel==0)
      {
          // desactivamos el ddlb de grupos
          document.getElementById("ddlb_grupos").disabled=true; 
      }else{
          // eliminamos todos los posibles valores que contenga el ddlb de grupos
          document.getElementById("ddlb_grupos").options.length=0;
            // añadimos los nuevos valores al ddlb de grupos
          document.getElementById("ddlb_grupos").options[0]=new Option("Sub-Rubro", "0");
          for(recorre=0;recorre<DatosGruposCodFam.length;recorre++)
          {
              // unicamente añadimos las opciones que pertenecen a la familia seleccionada
              if((DatosGruposCodFam[recorre]==familia_sel)&&(DatosGruposActGrp[recorre]==1))
              {
                document.getElementById("ddlb_grupos").options[cantgrupos]=new Option(DatosGruposDescGrp[recorre], DatosGruposCodGrp[recorre]);
                cantgrupos ++;
              }
          }
      }
  }

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

    <title>NeoSistemas SRL | Catálogo Artículos</title>

    <style type="text/css">


    @media (max-width: 992px) {

       .estilo1 {
        padding-right: 0px !important; 
        padding-left: 0px !important; 
      }
  }
    </style>

    <style type='text/css' media='print'> 
    .noimprimir { display: none } 
    @page {
      transform: scale(0.7);
    }
    </style>
 
    <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../../css/estilo.css" rel="stylesheet" type="text/css" />
    <link href="../../css/navbar-fixed-top.css" rel="stylesheet">
    <link href="../../css/custom.css" rel="stylesheet">
    <link href="../../css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="../../css/bootstrap-toggle2.css" rel="stylesheet">
    <link href="../../css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="../../css/resaltador.css" rel="stylesheet" type="text/css">
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/jquery-1.10.2.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/all.min.css" />
    <script type="text/javascript" src="../../js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="../../js/jszip.min.js"></script>

  </head>
  <body class="bodyReporte" style="background-color: #f3f3f4 !important;" >
    <div id="cargandoCatalogo" class="loading" style="visibility: hidden;">Loading&#8230;</div>
    <div class="panel-group noimprimir" id="accordion">
      <div class="panel panel-default" style="border-color: #A7BEE7; background-color: #A7BEE7; border-radius: 0px 0px 0px 0px " >
        <div class="ibox-title" style="background-color:#2F4050;" data-toggle="collapse" data-parent="#accordion" href="#collapse1">          
          <h5 style="color:#DFE4ED;">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="color: #DFE4ED">Catálogo de Artículos</a>
          </h5>
        </div>
        <div id="collapse1" class="panel-collapse collapse in">
          <div class="ibox float-e-margins" style="margin-bottom: 0"> 
            <div class="ibox-content" style="background-color: #A7BEE7; padding-left:0px; padding-right: 0px; padding-bottom: 5px; padding-top: 10px;">
              <form id="filtros" name="filtros" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="margin: 0;" >
                <div class="row" style="height: auto;">
                  <div class="col-sm-5 b-r">
                    <div class="col-sm-12 estilo1">
                      <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style='text-align: left; padding-left: 0; padding-right: 0;'>
                        <label style="color: black; font-size: 9pt;">Código Artículo</label>
                      </div>
                      <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left; ">
                        <div class='input-group col-xs-12 col-sm-12 col-md-8 col-lg-8'  > 
                          <input  id          = "codArticulo" 
                                  name        = "codArticulo"
                                  class       = "form-control"
                                  type        = "text" 
                                  placeholder = "Código"
                                  style       = "height: 22px; font-size: 9pt" 
                                  value       = "<?php  if(isset($_POST['codArticulo'])) echo $_POST['codArticulo']; ?>"  >
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 estilo1" style="padding-top: 15px;">
                      <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style='text-align: left; padding-left: 0; padding-right: 0;'>
                        <label style="color: black; font-size: 9pt;">Descripción Artículo</label>
                      </div>
                      <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left;">
                        <div class="input-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
                          <input id          = "descripArticulo"
                                 name        = "descripArticulo"
                                 class       = "form-control"
                                 type        = "text" 
                                 placeholder = "Descripción"
                                 style       = "height: 22px; font-size: 9pt;"
                                 value       = "<?php  if(isset($_POST['descripArticulo'])) echo $_POST['descripArticulo']; ?>" >   
                        </div>
                      </div>
                    </div>          
                  </div> <!-- Se cierra col-sm-5 b-r -->
                  <div class="col-sm-5 b-r pad" style="height: auto">
                    <div class="col-sm-12 estilo1">
                      <div class='col-xs-12 col-sm-12 col-md-6 col-lg-4' style="text-align: left; padding-left: 0; padding: 0; display: inline-flex;">
                        <div class='col-xs-6 col-sm-6 col-md-2 col-lg-2' style="padding: 0; width: 14%;  display: inline-block;">
                          <div class="switch__container" >
                            <input id="cbx_familias" class="switch switch--shadow" type="checkbox" name="rubro" onChange ="checkbox_familias(this.checked)";>
                              <label for="cbx_familias"></label>
                          </div>
                        </div>
                        <div class='pad2 col-xs-6 col-sm-6 col-md-10 col-lg-10' style="float: left; padding-right: 0; "  >
                          <label for="cbx_familias" style="padding-top: 5px; color: black; font-size: 9pt;"> Seleccionar Familia</label>
                        </div>
                      </div>
                      <div>
                        <div class='col-xs-12 col-sm-12 col-md-6 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left;">
                          <select style="font-size: 9pt; height: 22px; padding-top: 0; padding-bottom: 0; display: block;" name="ddlb_familias" class="form-control"        id="ddlb_familias" disabled="true"  onchange="CargarGrupos(this.value)">
                            <option value='' disabled selected>Familia</option>
                                <?php if ( isset($datosFamilias)) {
                                        foreach ($datosFamilias as $item ) {
                                          if  ( ( $item->familartactiva == 1) ) {  
                                            echo (string)'<option value="'.$item->familartcod.'">'.$item->familartdesc.'</option>'; 

                                          }  
                                        }
                                      }
                                ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 estilo1" style="padding-top: 10px;">
                      <div class='col-xs-12 col-sm-12 col-md-6 col-lg-4' style='text-align: left; padding:0; display: inline-flex'>
                        <div class='col-xs-6 col-sm-12 col-md-2 col-lg-2' style="padding: 0; width: 14%; display: inline-block; ">
                          <div class="switch__container">
                            <input id="cbx_grupos" class="switch switch--shadow" type="checkbox" disabled="disabled" name="subrubro" onchange="checkbox_grupos(this.checked);" >
                            <label for="cbx_grupos"></label>
                          </div>
                        </div>
                        <div class='pad2 col-xs-6 col-sm-12 col-md-10 col-lg-10' style="float: left; padding-right: 0;  " >
                          <label for="cbx_grupos" style="padding-top: 5px; color: black; font-size: 9pt;">Seleccionar Grupo</label>
                        </div>                  
                      </div>
                      <div class="">
                        <div class='col-xs-12 col-sm-12 col-md-6 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left;">
                          <select style="font-size: 9pt; height: 22px; padding-top: 0; padding-bottom: 0; display: block;" name="ddlb_grupos" class="form-control"        id="ddlb_grupos" disabled="true">
                            <option value='' disabled selected>Grupo</option>
                          </select>
                        </div>
                      </div> 
                    </div>
                  </div> <!-- Se cierra col-sm-5 b-r -->
                  <div class="control-group pad" >
                    <div class="col-sm-2" id="recuperar"> 
                      <button id="recuperar" 
                              name="recuperar" 
                              style="padding: 5px 30px 5px 30px;" 
                              class="btn btn-xs btn-primary btn-block" 
                              type="button" 
                              onclick="recuperarArticulos(<?php echo $codRol; ?>)"><strong> Recuperar</strong>
                      </button>
                       <button id="imprimir" 
                              name="imprimir" 
                              style="padding: 5px 30px 5px 30px;" 
                              class="btn btn-xs btn-primary btn-block" 
                              type="button" 
                              onclick="window.print();"><strong> Imprimir</strong>
                      </button> 

                    </div>
                  </div>
                </div><!-- Se cierra row -->        
              </form>
            </div><!-- Se cierra ibox-content -->  
          </div><!-- Se cierra ibox float-e-margins --> 
        </div><!-- Se cierra collapse1--> 
      </div><!-- Se cierra panel panel-default --> 
    </div><!-- Se cierra panel-group --> 

    <div class="row">
      <table class="table table-condensed sortable tablaGeneral" id="resultadoBusqueda">
        <thead style="background-color: lightgrey;">
          <tr>
            <th class="text-center fontsize imprimir"><strong>Familia</strong></th>
            <th class="text-center fontsize imprimir"><strong>Grupo</strong> </th>
            <th class="text-center fontsize imprimir" ><strong>Artículo</strong></th>
            <?php 
            if ( $_SESSION["rol"] == 2 ){
            ?>  
              <th class="text-center descarto " > <strong>Precio</strong></th>
              <th class="text-center descarto" > <strong>Precio Final</strong></th>
            <?php 
              }
             else{ 
              ?>  
              <th class="text-center descarto imprimir" > <strong>Precio 1</strong></th>
              <th class="text-center descarto imprimir" > <strong>Precio 2</strong></th>
              <th class="text-center descarto noimprimir"> <strong>Precio 3</strong></th>
              <th class="text-center descarto noimprimir" style="width: 100px;"> <strong>Precio 4</strong></th> 

            <?php  
                } 
              ?>
          </tr>
        </thead>

        <tbody style="font-size: 12px;">
        </tbody>
      </table>

      <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #2F4050; color:white; text-align: center; font-size: 30px">
              <button type="button" class="close" onclick="" data-dismiss="modal" aria-label="Close" style="color: #fff !important; text-shadow: none !important; opacity:1;"> 
                <span aria-hidden="true">&times;</span>
              </button>
              <h4><span class="glyphicon glyphicon-th-large"></span> Catálogo de Artículos</h4>
            </div>
            <div class="modal-body">
              <h4>Familia</h4>
              <div style="text-align: left;" id="filaFamilia"> 
              </div>  
              <h4>Grupo</h4>
              <div style="text-align: left;" id="filaGrupo">                      
              </div>    
              <h4>Artículo</h4>
              <div style="text-align: left;" id="filaArticulo">   
              </div>  
               <?php 
                if ( $_SESSION["rol"] == 2 ){
                ?> 
                  <h4>Precio Venta</h4>
                  <div style="text-align: left;" id="filaPrecioVenta1">   
                  </div>
                  <h4>Precio Final</h4>
                  <div style="text-align: left;" id="filaPrecioFinal1">   
                  </div>
                
              <?php
              } else {
                 ?> 
                 <div>
                  <div style="display: inline-block;">    
                    <h4>Precio Venta 1</h4>
                    <div style="text-align: left;" id="filaPrecioVenta1">   
                    </div>
                  </div>
                  <div style="float: right; padding-left: 0; margin-left: 0; width:50%;"> 
                    <h4>Precio Final 1</h4>
                    <div style="text-align: left;" id="filaPrecioFinal1">   
                    </div>
                  </div>
                 </div> 

                 <div>
                  <div style="display: inline-block;">    
                    <h4>Precio Venta 2</h4>
                    <div style="text-align: left;" id="filaPrecioVenta2">   
                    </div>
                  </div>
                  <div style="float: right; padding-left: 0; margin-left: 0; width:50%;"> 
                    <h4>Precio Final 2</h4>
                    <div style="text-align: left;" id="filaPrecioFinal2">   
                    </div>
                  </div>
                 </div> 

                  <div>
                  <div style="display: inline-block;">    
                    <h4>Precio Venta 3</h4>
                    <div style="text-align: left;" id="filaPrecioVenta3">   
                    </div>
                  </div>
                  <div style="float: right; padding-left: 0; margin-left: 0; width:50%;"> 
                    <h4>Precio Final 3</h4>
                    <div style="text-align: left;" id="filaPrecioFinal3">   
                    </div>
                  </div>
                 </div> 

                  <div>
                  <div style="display: inline-block;">    
                    <h4>Precio Venta 4</h4>
                    <div style="text-align: left;" id="filaPrecioVenta4">   
                    </div>
                  </div>
                  <div style="float: right; padding-left: 0; margin-left: 0; width:50%;"> 
                    <h4>Precio Final 4</h4>
                    <div style="text-align: left;" id="filaPrecioFinal4">   
                    </div>
                  </div>
                 </div> 
                  
                 <?php 
                  }
                 ?>  
            </div><!-- Se cierra modal body --> 
          </div><!-- Se cierra modal-content --> 
        </div><!-- Se cierra modal-dialog --> 
      </div><!-- Se cierra modal fade--> 
    </table>  
    </div><!-- Se cierra row-->

    <script src="../../comercial/js_comercial/funcionesCatalogoArticulos.js" type="text/javascript"></script>

  </body>
</html>