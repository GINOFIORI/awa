<!DOCTYPE HTML>

<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Administración</title>

<link rel="stylesheet" type="text/css" href="css/log_css.css" />

<link rel="stylesheet" type="text/css" href="css/estilo.css" />

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />

<link href="css/dashboard.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<link href="css/jquery.gritter.css" rel="stylesheet" type="text/css" />

<link href="css/style.css" rel="stylesheet" type="text/css" />

<link href="css/animate.css" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

<script src="js/bootstrap.min.js"></script>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<style type="text/css" name="estilo-para-arreglar-efecto-visual-cuando-muestra-modal">
  body { padding-right: 0 !important }
  @media (min-width: 768px) {
    .descartoWeb {
      display: none !important;
    }
  }
  /* On screens that are 600px or less, set the background color to olive */
  @media (max-width: 768px) {
    .disponible {
      text-align: center !important; 
      padding-top: 10px !important;
    }
  }

</style>

<body style="background-color: transparent;">
  <?php
  if ($alertaErrores!==''){
    echo '<script type="text/javascript"> alert("' . $alertaErrores . '");</script>';
  }
  
  include_once('include/admin_header.php');

  ?>
<div class="container-fluid" id="contenido">
  <div class='row'>

    <buttom  class="btn btn-default" data-toggle="modal" data-target="#detalle" style="float: left; margin-top: 7px" onClick="nuevo()">Nuevo</buttom> 

    <table class="table table-hover small" style="border-color: #f3f3f4">
      <thead>
        <tr>
          <th scope="col">ID Cliente</th>
          <th scope="col">Descripcion</th>
          <th class="descarto" scope="col">URL Cliente</th>
          <th class="descarto"scope="col">Servidor Cliente</th>
          <th class="descarto"scope="col">BD Cliente</th>
          <th class="descarto"scope="col">Emp. Cliente</th>
          <th class="descarto"scope="col">Suc. Cliente</th>
          <th class="descarto"scope="col">Camino AWA Download</th>
          <th class="descarto"scope="col">Camino AWA BR</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($lista_config as $key => $configuracion) {
            echo '<tr>';
            echo '<td>' . $configuracion->IdCliente         . '</td>';
            echo '<td>' . $configuracion->DescripcionEmp    . '</td>';
            echo '<td class="descarto">' . $configuracion->UrlCliente        . '</td>';
            echo '<td class="descarto">' . $configuracion->ServidorCliente   . '</td>';
            echo '<td class="descarto">' . $configuracion->BDCliente         . '</td>';
            echo '<td class="descarto" style="text-align: center">' . $configuracion->IdEmpCliente . '</td>';
            echo '<td class="descarto" style="text-align: center">' . $configuracion->IdSucCliente . '</td>';
            echo '<td class="descarto">' . $configuracion->CaminoAwaDownload . '</td>';
            echo '<td class="descarto">' . $configuracion->CaminoAwaBR       . '</td>';
            echo '<td class="descarto">' . $configuracion->DescripcionEMP    . '</td>';
            echo '<td style="width: 15px">  <button style="width:38; height:34" class="btn btn-default" data-toggle="modal" data-target="#detalle" onClick="modificar('. "'" . $configuracion->IdCliente                     . "'" . ' , '
                                  . "'" . $configuracion->UrlCliente                    . "'" . ' , '  
                                  . "'" . addslashes($configuracion->ServidorCliente)   . "'" . ' , '  
                                  . "'" . $configuracion->BDCliente                     . "'" . ' , '  
                                  . "'" . $configuracion->IdEmpCliente                  . "'" . ' , '  
                                  . "'" . $configuracion->IdSucCliente                  . "'" . ' , '  
                                  . "'" . $configuracion->CaminoAwaDownload             . "'" . ' , '  
                                  . "'" . addslashes($configuracion->CaminoAwaBR)       . "'" . ' , '  
                                  . "'" . $configuracion->DescripcionEmp                . "'" . ' , '  
                                  . "'" . $configuracion->UsuarioAdm                    . "'" . ' , '  
                                  . "'" . $configuracion->PassAdm                       . "'" . ' , '  
                                  . "'" . $configuracion->Disponible                    . "'" . ' , '  
                                  . "'" . $configuracion->Llave                         . "'" . ')">
                          <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                  </td>';
            echo '<td style="width: 15px">  <button style="width:38; height:34" class="btn btn-default" data-toggle="modal" data-target="#detalle"    onClick="borrar(' . "'" . $configuracion->IdCliente                       . "'" . ' , '
                                . "'" . $configuracion->UrlCliente                      . "'" . ' , '  
                                . "'" . addslashes($configuracion->ServidorCliente)     . "'" . ' , '  
                                . "'" . $configuracion->BDCliente                       . "'" . ' , '  
                                . "'" . $configuracion->IdEmpCliente                    . "'" . ' , '  
                                . "'" . $configuracion->IdSucCliente                    . "'" . ' , '  
                                . "'" . $configuracion->CaminoAwaDownload               . "'" . ' , '  
                                . "'" . addslashes($configuracion->CaminoAwaBR)         . "'" . ' , '  
                                . "'" . $configuracion->DescripcionEmp                  . "'" . ' , '  
                                . "'" . $configuracion->UsuarioAdm                      . "'" . ' , '  
                                . "'" . $configuracion->PassAdm                         . "'" . ' , '  
                                . "'" . $configuracion->Disponible                      . "'" . ' , '  
                                . "'" . $configuracion->Llave                           . "'" . ')">
                          <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button> 
                  </td>';
            echo '<td style="width: 15px">  <button style="width:38; height:34" class="btn btn-default" onClick="test('. "'" . $configuracion->IdCliente         . "'" . ' , '
                                . "'" . $configuracion->UrlCliente                    . "'" . ' , '  
                                . "'" . addslashes($configuracion->ServidorCliente)   . "'" . ' , '  
                                . "'" . $configuracion->BDCliente                     . "'" . ' , '  
                                . "'" . $configuracion->IdEmpCliente                  . "'" . ' , '  
                                . "'" . $configuracion->IdSucCliente                  . "'" . ' , '  
                                . "'" . $configuracion->CaminoAwaDownload             . "'" . ' , '  
                                . "'" . addslashes($configuracion->CaminoAwaBR)       . "'" . ' , '  
                                . "'" . $configuracion->UsuarioAdm                    . "'" . ' , '  
                                . "'" . $configuracion->PassAdm                       . "'" . ' , '  
                                . "'" . $configuracion->Llave                         . "'" . ')">
                          <i id="testing_' . $configuracion->IdCliente . '" class="fa fa-refresh"></i>
                        </button>
                  </td>';
            echo '</tr>';
          }

        ?>
      </tbody>
    </table>

    <div class="modal fade" id="detalle" role="dialog" style="overflow-y: auto !important">
      <div class="modal-dialog modal-lg" style="overflow-y: auto !important">
        <div class="modal-content" style="overflow-y: auto !important">
          <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <input type="hidden" name="awaconfig" value='awaconfig' style="visibility: hidden">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Configuración:</h4>
            </div>
            <div class="modal-body">
              <p>
                <!-- RENGLON 1 -------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                  <div class="col-md-6">
                    <label for="IdCliente">ID Cliente</label>
                    <input type="text" class="form-control" id="IdCliente" name="IdCliente" value='' autocomplete="off" required>
                  </div>
                  <div class="col-md-6">
                    <label for="DescripcionEmp">Nombre Cliente</label>
                    <input type="text" class="form-control" id="DescripcionEmp" name="DescripcionEmp" value='' autocomplete="off" required>
                  </div>
                </div>
                <!-- RENGLON 2 -------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                  <div class="col-md-6">
                    <label for="UrlCliente">URL Cliente</label>
                    <input type="text" class="form-control" id="UrlCliente" name="UrlCliente" value='' autocomplete="off" required>
                  </div>
                  <div class="col-md-6">
                    <label for="ServidorCliente">Servidor Cliente </label>
                    <input type="text" class="form-control" id="ServidorCliente" name="ServidorCliente" value='' autocomplete="off" required>
                  </div>
                </div>
                <!-- RENGLON 3 -------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                  <div class="col-md-6">
                    <label for="BDCliente">Nombre BD</label>
                    <input type="text" class="form-control" id="BDCliente" name="BDCliente" value='' autocomplete="off" required>
                  </div>
                  <div class="col-md-3">                
                    <label for="IdEmpCliente">ID Empresa </label>
                    <input type="text" class="form-control" id="IdEmpCliente" name="IdEmpCliente" value='' autocomplete="off" required>
                  </div>
                  <div class="col-md-3">
                    <label for="IdSucCliente">ID Sucursal </label>
                    <input type="text" class="form-control" id="IdSucCliente" name="IdSucCliente" value='' autocomplete="off" required>
                  </div>
                </div>
                <!-- RENGLON 4 -------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                  <div class="col-md-6">
                    <label for="CaminoAwaDownload">Camino AWA Download </label>
                    <input type="text" class="form-control" id="CaminoAwaDownload" name="CaminoAwaDownload" value='' autocomplete="off" required>
                  </div>
                  <div class="col-md-6">
                    <label for="CaminoAwaBR">Camino AWA BR </label>
                    <input type="text" class="form-control" id="CaminoAwaBR" name="CaminoAwaBR" placeholder="" value='' autocomplete="off" required>
                  </div>
                </div>
                <!-- RENGLON 5 -------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                  <div class="col-md-6">
                    <label for="UsuarioAdm">Usuario ADM </label>
                    <input type="text" class="form-control" id="UsuarioAdm" name="UsuarioAdm" value='' autocomplete="off" required>
                  </div>
                  <div class="col-md-6">
                    <label for="PassAdm">Contraseña Usuario ADM </label>
                    <input type="password" class="form-control" id="PassAdm" name="PassAdm" placeholder="" value='' autocomplete="off" required>
                  </div>
                </div>
                <!-- RENGLON 6 -------------------------------------------------------------------------------------------------------->
                <div class="form-group">
                  <div class="col-md-6">
                    <label for="Llave">Llave</label>
                    <input type="text" class="form-control" id="Llave" name="Llave" value='' autocomplete="off" required>
                  </div>
                  <div class="col-md-6">
                  </div>
                </div>
              </p>
            </div>
            <div class="modal-footer" >
              <div class="col-md-3 col-sm-12 col-xs-12 disponible" style="text-align: left">
                <label for="Disponible" style="padding-top: 5px; padding-right: 10px; text-align: left">Disponible</label>
                <input onChange="changeValue()" type="checkbox" id="Disponible" value='1' data-width="50" name="Disponible" data-on="Si" data-off="No" checked data-toggle="toggle" data-size="mini">
              </div>
              <div class="col-md-9 col-sm-12 col-xs-12 disponible" style="text-align: right" id="boton">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div> 
</div> 


  <script type="text/javascript">

    function changeValue(){
      if ($('#Disponible').prop('checked')){
        document.getElementById('Disponible').value = '1';
      }else{
        document.getElementById('Disponible').value = '0';
      }
    }
    
    function modificar(IdCliente,UrlCliente,ServidorCliente,BDCliente,IdEmpCliente,IdSucCliente,CaminoAwaDownload,CaminoAwaBR,DescripcionEmp,UsuarioAdm,PassAdm,Disponible,Llave){

      document.getElementById('IdCliente').value         = IdCliente;
      document.getElementById('UrlCliente').value        = UrlCliente;
      document.getElementById('ServidorCliente').value   = ServidorCliente;
      document.getElementById('BDCliente').value         = BDCliente;
      document.getElementById('IdEmpCliente').value      = IdEmpCliente;
      document.getElementById('IdSucCliente').value      = IdSucCliente;
      document.getElementById('CaminoAwaDownload').value = CaminoAwaDownload;
      document.getElementById('CaminoAwaBR').value       = CaminoAwaBR;
      document.getElementById('DescripcionEmp').value    = DescripcionEmp;
      document.getElementById('UsuarioAdm').value        = UsuarioAdm;
      document.getElementById('PassAdm').value           = PassAdm; 
      document.getElementById('Llave').value             = Llave; 
      document.getElementById('Disponible').value        = Disponible;
      if (Disponible==1){
        $('#Disponible').bootstrapToggle('on')
      }else{
        $('#Disponible').bootstrapToggle('off')
      }

      document.getElementById('IdCliente').readOnly         = true;
      document.getElementById('UrlCliente').readOnly        = false;
      document.getElementById('ServidorCliente').readOnly   = false;
      document.getElementById('BDCliente').readOnly         = false;
      document.getElementById('IdEmpCliente').readOnly      = false;
      document.getElementById('IdSucCliente').readOnly      = false;
      document.getElementById('CaminoAwaDownload').readOnly = false;
      document.getElementById('CaminoAwaBR').readOnly       = false;
      document.getElementById('DescripcionEmp').readOnly    = false;
      document.getElementById('UsuarioAdm').readOnly        = false;
      document.getElementById('PassAdm').readOnly           = false; 
      document.getElementById('Llave').readOnly             = false; 
      document.getElementById('Disponible').readOnly        = false; 
      // Agregar boton de MODIFICAR ...
      document.getElementById('boton').innerHTML = '<button type="Submit" name="modificar" class="btn btn-primary">Aceptar</button>';
    }

    function borrar(IdCliente,UrlCliente,ServidorCliente,BDCliente,IdEmpCliente,IdSucCliente,CaminoAwaDownload,CaminoAwaBR,DescripcionEmp,UsuarioAdm,PassAdm,Disponible){

      document.getElementById('IdCliente').value         = IdCliente;
      document.getElementById('UrlCliente').value        = UrlCliente;
      document.getElementById('ServidorCliente').value   = ServidorCliente;
      document.getElementById('BDCliente').value         = BDCliente;
      document.getElementById('IdEmpCliente').value      = IdEmpCliente;
      document.getElementById('IdSucCliente').value      = IdSucCliente;
      document.getElementById('CaminoAwaDownload').value = CaminoAwaDownload;
      document.getElementById('CaminoAwaBR').value       = CaminoAwaBR;
      document.getElementById('DescripcionEmp').value    = DescripcionEmp;
      document.getElementById('UsuarioAdm').value        = UsuarioAdm;
      document.getElementById('PassAdm').value           = PassAdm; 
      document.getElementById('Llave').value             = Llave; 
      document.getElementById('Disponible').value        = Disponible; 
      if (Disponible==1){
        $('#Disponible').bootstrapToggle('on')
      }else{
        $('#Disponible').bootstrapToggle('off')
      }

      document.getElementById('IdCliente').readOnly         = true;
      document.getElementById('UrlCliente').readOnly        = true;
      document.getElementById('ServidorCliente').readOnly   = true;
      document.getElementById('BDCliente').readOnly         = true;
      document.getElementById('IdEmpCliente').readOnly      = true;
      document.getElementById('IdSucCliente').readOnly      = true;
      document.getElementById('CaminoAwaDownload').readOnly = true;
      document.getElementById('CaminoAwaBR').readOnly       = true;
      document.getElementById('DescripcionEmp').readOnly    = true;
      document.getElementById('UsuarioAdm').readOnly        = true;
      document.getElementById('PassAdm').readOnly           = true; 
      document.getElementById('Llave').readOnly             = true; 
      document.getElementById('Disponible').readOnly        = true; 
      // Agregar boton de BORRAR ...
      document.getElementById('boton').innerHTML = '<button type="Submit" name="borrar" class="btn btn-danger">Borrar</button>'
    }

    function nuevo(){

      document.getElementById('IdCliente').value         = '';
      document.getElementById('UrlCliente').value        = '';
      document.getElementById('ServidorCliente').value   = '';
      document.getElementById('BDCliente').value         = '';
      document.getElementById('IdEmpCliente').value      = '';
      document.getElementById('IdSucCliente').value      = '';
      document.getElementById('CaminoAwaDownload').value = '';
      document.getElementById('CaminoAwaBR').value       = '';
      document.getElementById('DescripcionEmp').value    = '';
      document.getElementById('UsuarioAdm').value        = '';
      document.getElementById('PassAdm').value           = ''; 
      document.getElementById('Llave').value             = ''; 
      document.getElementById('Disponible').value        = 1;

      document.getElementById('IdCliente').readOnly         = false;
      document.getElementById('UrlCliente').readOnly        = false;
      document.getElementById('ServidorCliente').readOnly   = false;
      document.getElementById('BDCliente').readOnly         = false;
      document.getElementById('IdEmpCliente').readOnly      = false;
      document.getElementById('IdSucCliente').readOnly      = false;
      document.getElementById('CaminoAwaDownload').readOnly = false;
      document.getElementById('CaminoAwaBR').readOnly       = false;
      document.getElementById('DescripcionEmp').readOnly    = false;
      document.getElementById('UsuarioAdm').readOnly        = false;
      document.getElementById('PassAdm').readOnly           = false; 
      document.getElementById('Llave').readOnly             = false; 
      document.getElementById('Disponible').readOnly        = false;

      // Agregar boton de GUARDAR
      document.getElementById('boton').innerHTML = '<button type="Submit" name="agregar" class="btn btn-success">Guardar</button>';

    }
    window.onscroll = function() {menusticky()};

    var navbar = document.getElementById("navbar");
    var contenido = document.getElementById("contenido");
    var sticky = navbar.offsetTop;

    function menusticky() {
      if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky");
        contenido.style.padding = '50px 15px 0px 15px';
      } else {
        navbar.classList.remove("sticky");
        contenido.style.padding = '0px 15px 0px 15px';
      }
    }

  </script>

  <script type="text/javascript" src="../awa/admin/js_admin/abm_awaconfig.js"></script>

</body>
</html>