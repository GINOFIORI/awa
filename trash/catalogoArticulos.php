<?php

  include ("includes/iniciar_sesion.php");
  include("includes/conexionWS.php");

  $modulo = 7;
 
  $comandoFamilias    = "FAMILIAS()";
  $datosFamilias      = conexionWS ( $modulo , $comandoFamilias );

  $comandoGrupos      = "GRUPOS(0)";
  $datosGrupos        = conexionWS ( $modulo , $comandoGrupos ); 

  $DatosGruposCodFam  = array();
  $DatosGruposCodGrp  = array();
  $DatosGruposDescGrp = array();
  $DatosGruposActGrp  = array();

  $recorre = 0;

  foreach($datosGrupos->results_row as $item){
    $DatosGruposCodFam[$recorre]  = (integer) $item->familartcod;
    $DatosGruposCodGrp[$recorre]  = (integer) $item->gruposartcod;
    $DatosGruposDescGrp[$recorre] = (string) $item->gruposartdesc;
    $DatosGruposActGrp[$recorre]  = (integer) $item->gruposartactivo;
    $recorre++;       
  }

  if ( isset ( $_POST['submit'] ) ) {

    if (isset($_POST['codArticulo'])) {
      
      $codigoArticulo = $_POST['codArticulo'];
      
    }

      if (isset($_POST['descripArticulo'])) {
    
      $descripcionArticulo = $_POST['descripArticulo']; 
      
    }

    if (isset($_POST['ddlb_familias'])) {

      $familiaSeleccionada = $_POST['ddlb_familias'];
      
    }else{
      $familiaSeleccionada = '0';
    }
    
    if (isset($_POST['ddlb_grupos'])) {
    
      $grupoSeleccioado = $_POST['ddlb_grupos']; 
      
    }else {
      $grupoSeleccioado = '0';
    }

     $comandoArticulos = "BUSCARARTICULOS(" . $codigoArticulo . "," . $descripcionArticulo . "," . $familiaSeleccionada . "," . $grupoSeleccioado .  ")"; 
     $resultadoArt     = conexionWS ( $modulo , $comandoArticulos );

    }   
?>


<script type="text/javascript">

var DatosGruposCodFam=<?php echo json_encode($DatosGruposCodFam);?>;
var DatosGruposCodGrp=<?php echo json_encode($DatosGruposCodGrp);?>;
var DatosGruposDescGrp=<?php echo json_encode($DatosGruposDescGrp);?>;
var DatosGruposActGrp=<?php echo json_encode($DatosGruposActGrp);?>; 

function CargarGrupos(familia_sel) 
{
    
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

function checkbox_familias(value)
{
  if(value==true)
  {
    // habilitamos
    document.getElementById("ddlb_familias").disabled=false;
    document.getElementById("cbx_grupos").disabled=false;
  }else if(value==false){
    // deshabilitamos
    document.getElementById("ddlb_familias").disabled=true;
    document.getElementById("ddlb_grupos").disabled=true;
    document.getElementById("cbx_grupos").checked=false;
    document.getElementById("cbx_grupos").disabled=true;
  }
}

function checkbox_grupos(value)
{
  if(value==true)
  {
    document.getElementById("ddlb_grupos").disabled=false;
  }else if(value==false){
    document.getElementById("ddlb_grupos").disabled=true;
  }
}

function iconoProcesandoDatos() {
  document.getElementById("cargando").style.visibility = "visible";
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
 
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="css/bootstrap-toggle2.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/resaltador.css" rel="stylesheet" type="text/css">

    <script src="js/bootstrap-toggle.min.js"></script>
    <script src="js/bootstrap-toggle2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/sorttable.js"></script>


  
  </head>
  <body style="background-color:#F3F3F4;">
    <div class="row" style="margin-bottom: 0; padding-bottom: 0;" >
      <div class="ibox float-e-margins" >
        <div class="ibox-title" style="background-color:#2F4050;">          
          <h5 style="color:#DFE4ED;">Catálogo de Artículos</h5>
        </div>
        <div class="ibox-content" style="background-color: #A7BEE7; padding-left:0px; padding-right: 0px; padding-bottom: 5px; padding-top: 10px;">
          <form id="filtros" name="filtros" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
            <div class="row" style="height: auto;">
              <div class="col-sm-5 b-r">
                <div class="col-sm-12">
                  <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style='text-align: left; padding-left: 0; padding-right: 0;'>
                    <label style="color: black; font-size: 8pt;">Código Artículo:</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left; ">
                    <div class='input-group col-xs-12 col-sm-12 col-md-8 col-lg-8'  > 
                      <input  id          = "codArticulo" 
                              name        = "codArticulo"
                              class       = "form-control"
                              type        = "text" 
                              placeholder = "Código"
                              style       = "height: 22px; font-size: 8pt" 
                              value       = "<?php  if(isset($_POST['codArticulo'])) echo $_POST['codArticulo']; ?>"  >
                      </div>
                  </div>
                </div>

                <div class="col-sm-12" style="padding-top: 15px;">
                  <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style='text-align: left; padding-left: 0; padding-right: 0;'>
                    <label style="color: black; font-size: 8pt;">Descripción Artículo:</label>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left;">
                    <div class="input-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
                      <input id          = "descripArticulo"
                             name        = "descripArticulo"
                             class       = "form-control"
                             type        = "text" 
                             placeholder = "Descripción"
                             style       = "height: 22px; font-size: 8pt;"
                             value       = "<?php  if(isset($_POST['descripArticulo'])) echo $_POST['descripArticulo']; ?>" >   
                    </div>
                  </div>
                </div>          
  
              </div>

              <div class="col-sm-5 b-r pad" style="height: auto">
                <div class="col-sm-12">
                  <div class='col-xs-12 col-sm-12 col-md-6 col-lg-4' style="text-align: left; padding-left: 0; padding: 0;">
                    <div class='col-xs-6 col-sm-6 col-md-2 col-lg-2' style="padding: 0; width: 25%;  display: inline-block;">
                      <div class="switch__container" >
                        <input id="cbx_familias" class="switch switch--shadow" type="checkbox" name="rubro"  onchange="checkbox_familias(this.checked);" >
                        <label for="cbx_familias"></label>
                      </div>
                    </div>
                    <div class='pad2 col-xs-6 col-sm-6 col-md-10 col-lg-10' style="float: left; padding-left: 0; "  >
                      <label for="cbx_familias" style="padding-top: 5px; color: black; font-size: 8pt;">Seleccionar Familia</label>
                    </div>
                  </div>
                  <div>
                    <div class='col-xs-12 col-sm-12 col-md-6 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left;">
                        <select style="font-size: 8pt; height: 22px; padding-top: 0; padding-bottom: 0; display: block;" name="ddlb_familias" class="form-control"             id="ddlb_familias" disabled="true" onchange="CargarGrupos(this.value)">
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
                <div class="col-sm-12" style="padding-top: 10px;">
                  <div class='col-xs-12 col-sm-12 col-md-6 col-lg-4' style='text-align: left; padding:0;'>
                    <div class='col-xs-6 col-sm-12 col-md-2 col-lg-2' style="padding: 0; width: 25%; display: inline-block; ">
                       <div class="switch__container">
                        <input id="cbx_grupos" class="switch switch--shadow" type="checkbox" disabled="disabled" name="subrubro" onchange="checkbox_grupos(this.checked);" >
                        <label for="cbx_grupos"></label>
                      </div>
                    </div>
                    <div class='pad2 col-xs-6 col-sm-12 col-md-10 col-lg-10' style="float: left; padding-left: 0; " >
                      <label for="cbx_grupos" style="padding-top: 5px; color: black; font-size: 8pt;">Seleccionar Grupo</label>
                    </div>                  
                  </div>
                  <div class="">
                    <div class='col-xs-12 col-sm-12 col-md-6 col-lg-8' style="padding-left: 0; padding-right: 0; text-align: left;">
                        <select style="font-size: 8pt; height: 22px; padding-top: 0; padding-bottom: 0; display: block;" name="ddlb_grupos" class="form-control" id="ddlb_grupos" disabled="true">
                          <option value='' disabled selected>Grupo</option>
                        </select>
                    </div>
                  </div> 
                </div>
              </div>
              <div class="control-group pad" >
                <div class="col-sm-2" id="recuperar"> 
                  <input type="submit" class="btn btn-primary login-button" name="submit" id="recuperar" value="Recuperar" style="padding: 5px 30px 5px 30px;" onclick="iconoProcesandoDatos()"  />
                </div>
              </div>
            </div>           
          </form>
        </div>
      </div>
    </div>

    <div class="row">
     <table class="table table-condensed sortable" id="resultadoBusqueda">
      <thead style="background-color: lightgrey;">
      <tr>
        <th class="text-center"> <strong>Familia</strong></th>
        <th class="text-center"> <strong>Grupo</strong> </th>
        <th class="text-center" > <strong>Código</strong></th>
        <th class="text-center" > <strong>Descripción</strong></th>
        <?php 
        if ( $_SESSION["rol"] == 2 ){
        ?>  
          <th class="text-center descarto" > <strong>Precio</strong></th>
          <th class="text-center descarto" > <strong>Precio Final</strong></th>
        <?php 
          }
         else{ 
          ?>  
          <th class="text-center descarto" > <strong>Precio 1</strong></th>
          <th class="text-center descarto" > <strong>Precio 2</strong></th>
          <th class="text-center descarto"> <strong>Precio 3</strong></th>
          <th class="text-center descarto" style="width: 100px;"> <strong>Precio 4</strong></th> 

        <?php  
            } 
          ?>
      </tr>
      </thead>

      <div id="cargando" class="text-center indicadorCargando" style="padding-top: 100px; visibility: hidden;">
        <i class="fa fa-spinner fa-spin fa-fw fa-4x fa fa-align-center"></i>
      </div>
      
      <?php
      if ( !(isset($resultadoArt)) ) {
      ?>
        </table>
      <?php
      } else {
        if ( gettype($resultadoArt)=='array' ){
          ?>
           <tbody style="align-items: center;">
            <tr  style="align-items: center;">
              <td style="width: 100%; display: inline-block;">
                <div class="alert alert-danger errores" style="display: inline-block; text-align: center;">
                  <p><span style="font-size:10pt; color:#CC3300"><b><?php echo 'Mensaje Info: ' . $resultadoArt[1]  ; ?></b></span></p>
                </div>
              </td>
             </tr>
          </tbody>
          <?php
                die();
              }
        ?>
         <tbody style="overflow-y: scroll" class="resaltador fontsize">      
        <?php 
          foreach($resultadoArt->results_row as $item){
            
            ?>
        <div class="contenedor-modal">
          <tr style="overflow-y: scroll" href="#"  data-toggle="modal" data-target="#miModal" class="resaltador" >
           <td class="text-center consultaArticulo">  
              <?php 
              $descripcionFamilia = (string) $item->familartdesc;  
              echo $descripcionFamilia; 
              ?>       
            </td>

            <td class="text-center consultaArticulo">   
            <?php
              $descripcionGrupo = (string) $item->gruposartdesc;  
              echo $descripcionGrupo;
            ?>               
            </td>

            <td class="text-center consultaArticulo">
            <?php
              $codigoArticulo = (string) $item->articcodadmin;  
              echo $codigoArticulo;
            ?>     
            </td>

            <td class="text-center consultaArticulo">
            <?php
              $descripcionArticulo = (string) $item->articdesc;  
              echo $descripcionArticulo;
             ?> 
            </td>

            <?php 
            if ( $_SESSION["rol"] == 2 ){
            ?>
              <td class="text-center descarto consultaArticulo">
              <?php
                $precio1Articulo = (string) $item->articprecvta;  
                echo ($precio1Articulo);
               ?>
              </td>

               <td  style="display: none;">
              <?php
                $precio2Articulo = (string) $item->articprecvta2;
                echo $precio2Articulo;
              ?> 
              </td>

               <td  style="display: none;">
              <?php
                $precio3Articulo = (string) $item->articprecvta3;  
                echo $precio3Articulo;
              ?> 
              </td>

               <td  style="display: none;">
              <?php
                $precio4Articulo = (string) $item->articprecvta4; 
                echo $precio4Articulo;
              ?> 
              </td>

              <td class="text-center descarto consultaArticulo">
              <?php
                $precio1Final = (string) $item->artic_prec_final;  
                echo $precio1Final;
               ?> 
              </td>

              <td  style="display: none;">
              <?php
                $precio2Final = (string) $item->artic_prec_final_2;
                echo $precio2Final;  
              ?> 
              </td>

              <td style="display: none;">
              <?php 
                $precio3Final = (string) $item->artic_prec_final_3;
                echo $precio3Final;
              ?>
              </td>

               <td style="display: none;">
              <?php
                $precio4Final = (string) $item->artic_prec_final_4; 
                echo $precio4Final;
               ?>
              </td> 

            <?php
            }
            else{ 
            ?>  

              <td class="text-center descarto consultaArticulo">
              <?php
                $precio1Articulo = (string) $item->articprecvta;  
                echo $precio1Articulo;
               ?> 
              </td>

              <td class="text-center descarto consultaArticulo">
              <?php
                $precio2Articulo = (string) $item->articprecvta2;  
                echo $precio2Articulo;
               ?> 
              </td>
              
              <td class="text-center descarto consultaArticulo">
              <?php
                $precio3Articulo = (string) $item->articprecvta3;  
                echo $precio3Articulo;
               ?> 
              </td>

              <td class="text-center descarto consultaArticulo">
              <?php
                $precio4Articulo = (string) $item->articprecvta4;  
                echo $precio4Articulo;
               ?> 
              </td>
              
              <td  style="display: none;">
              <?php
                $precio1Final = (string) $item->artic_prec_final; 
                echo $precio1Final;
              ?> 
              </td>

              <td  style="display: none;">
              <?php
              $precio2Final = (string) $item->artic_prec_final_2;
              echo $precio2Final;
              ?> 
              </td>

              <td style="display: none;">
              <?php 
                $precio3Final = (string) $item->artic_prec_final_3;
                echo $precio3Final;
              ?>
              </td>

               <td style="display: none;">
              <?php
                $precio4Final = (string) $item->artic_prec_final_4; 
                echo $precio4Final;
               ?>
              </td> 

              <?php
              }

            }  
          }    
              ?>
            <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2F4050; color:white; text-align: center; font-size: 30px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff !important; text-shadow: none !important; opacity:1;"> 
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4><span class="glyphicon glyphicon-th-large"></span> Catálogo de Artículos</h4>
                  </div>
                  <div class="modal-body">
                    <h4>Familia:</h4>
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

                  </div>
                </div>
              </div>
            </div>
          </tr>
        </div>      
    </tbody>
  </table>  
</div> 

<script>
                           
  $(".consultaArticulo").click(function(){

      var valores= new Array;
      var contador = 0;

      // Obtenemos todos los valores contenidos en los <td> de la fila
      // seleccionada
      $(this).parents("tr").find("td").each(function(){
        contador++;
        valores[contador]=$(this).html();
      });
      
       document.getElementById("filaFamilia").innerHTML         = (valores[1]);
       document.getElementById("filaGrupo").innerHTML           = (valores[2]);
       document.getElementById("filaArticulo").innerHTML        = (valores[3]) + ' - ' + (valores[4]);
       document.getElementById("filaPrecioVenta1").innerHTML    = (valores[5]);
       document.getElementById("filaPrecioFinal1").innerHTML    = (valores[9]);
       document.getElementById("filaPrecioVenta2").innerHTML    = (valores[6]);
       document.getElementById("filaPrecioFinal2").innerHTML    = (valores[10]);
       document.getElementById("filaPrecioVenta3").innerHTML    = (valores[7]);
       document.getElementById("filaPrecioFinal3").innerHTML    = (valores[11]);
       document.getElementById("filaPrecioVenta4").innerHTML    = (valores[8]);
       document.getElementById("filaPrecioFinal4").innerHTML    = (valores[12]);

  });
</script>   

</body>
</html>