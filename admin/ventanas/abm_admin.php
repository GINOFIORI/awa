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

<style type="text/css" name="estilo-para-arreglar-efecto-visual-cuando-muestra-modal">
  body { padding-right: 0 !important }
  @media (min-width: 768px) {
    .descartoWeb {
      display: none !important;
    }
  }

</style>
</head>

<body style="background-color: transparent;">
  <?php
  if ($alertaErrores!==''){
    echo '<script type="text/javascript"> alert("' . $alertaErrores . '");</script>';
  }
  
  include_once('include/admin_header.php');

  ?>

<div class="container-fluid" id="contenido">
  <div class='row'>
      <buttom  class="btn btn-default" data-toggle="modal" data-target="#detalleAdmin" style="float: left; margin-top: 7px" onClick="nuevo()">Nuevo</buttom> 

      <table class="table table-hover" style="border-color: #f3f3f4">
        <thead>
          <tr>
            <th scope="col">ID Usuario</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col" class="descarto">Contraseña</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($lista_administradores as $key => $administrador) {
              echo '<tr>';
              echo '<td onChange="modificarCampo()">' . $administrador->NombreUsuario . '</td>';
              echo '<td onChange="modificarCampo()">' . $administrador->Nombre . '</td>';
              echo '<td onChange="modificarCampo()">' . $administrador->Apellido . '</td>';
              echo '<td class="descarto">******************************</td>';
              echo '<td style="width: 15px">  <button style="width:38; height:34" class="btn btn-default" data-toggle="modal" data-target="#detalleAdmin" onClick="modificar(' . "'" . $administrador->NombreUsuario . "'" . ' , ' . "'" . $administrador->Nombre . "'" . ' , ' . "'" . $administrador->Apellido . "'" . ' , ' . "'" . $administrador->PassUsuario . "'" . ')">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                          </button>
                    </td>';
              echo '<td style="width: 15px">  <button style="width:38; height:34" class="btn btn-default" data-toggle="modal" data-target="#detalleAdmin"    onClick="borrar(' . "'" . $administrador->NombreUsuario . "'" . ' , ' . "'" . $administrador->Nombre . "'" . ' , ' . "'" . $administrador->Apellido . "'" . ' , ' . "'" . $administrador->PassUsuario . "'" . ')">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                          </button> 
                    </td>';
              echo '</tr>';
            }

          ?>
        </tbody>
      </table>

      <div class="modal fade" id="detalleAdmin" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
              <input type="hidden" name="administradores" value='administradores' style="visibility: hidden">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Administrador:</h4>
              </div>
              <div class="modal-body">                
                <div class="form-group">
                  <label for="NombreUsuario">ID Usuario</label>
                  <input type="text" class="form-control" id="NombreUsuario" placeholder="Ingresar ID" name="NombreUsuario" value='' required>
                </div>
                <div class="form-group">
                  <label for="Nombre">Nombre</label>
                  <input type="text" class="form-control" id="Nombre" placeholder="Ingresar Nombre" name="Nombre" value='' required>
                </div>
                <div class="form-group">
                  <label for="Apellido">Apellido</label>
                  <input type="text" class="form-control" id="Apellido" placeholder="Ingresar Apellido" name="Apellido" value='' required>
                </div>
                <div class="form-group">
                  <label for="PassUsuario">Contraseña</label>
                  <input type="password" class="form-control" id="PassUsuario" placeholder="Ingresar Password" name="PassUsuario" value='' required>
                </div>
              </div>
              <div class="modal-footer" id="boton">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div> 
  </div>

  <script type="text/javascript">
    
    function modificar(nombre_usuario,nombre,apellido,pass_usuario){
      document.getElementById('NombreUsuario').value    = nombre_usuario;
      document.getElementById('Nombre').value           = nombre;
      document.getElementById('Apellido').value         = apellido;
      document.getElementById('PassUsuario').value      = pass_usuario;

      document.getElementById('NombreUsuario').readOnly = true;
      document.getElementById('Nombre').readOnly        = false;
      document.getElementById('Apellido').readOnly      = false;
      document.getElementById('PassUsuario').readOnly   = false;
      // Agregar boton de MODIFICAR ...
      document.getElementById('boton').innerHTML = '<button type="Submit" name="modificar" class="btn btn-primary">Aceptar</button>'
    }

    function borrar(nombre_usuario,nombre,apellido,pass_usuario){

      document.getElementById('NombreUsuario').value    = nombre_usuario;
      document.getElementById('Nombre').value           = nombre;
      document.getElementById('Apellido').value         = apellido;
      document.getElementById('PassUsuario').value      = pass_usuario;

      document.getElementById('NombreUsuario').readOnly = true;
      document.getElementById('Nombre').readOnly        = true;
      document.getElementById('Apellido').readOnly      = true;
      document.getElementById('PassUsuario').readOnly   = true;
      // Agregar boton de BORRAR ...
      document.getElementById('boton').innerHTML = '<button type="Submit" name="borrar" class="btn btn-danger">Borrar</button>'
    }

    function nuevo(){
      document.getElementById('NombreUsuario').value    = '';
      document.getElementById('Nombre').value           = '';
      document.getElementById('Apellido').value         = '';
      document.getElementById('PassUsuario').value      = '';
      
      document.getElementById('NombreUsuario').readOnly = false;
      document.getElementById('Nombre').readOnly        = false;
      document.getElementById('Apellido').readOnly      = false;
      document.getElementById('PassUsuario').readOnly   = false;
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

</body>
</html>