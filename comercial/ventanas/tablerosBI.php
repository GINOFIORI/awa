<?php

  include("../../includes/iniciar_sesion.php");

  // Ante todo se debe validar que si el rol es CLIENTE, se deben setear variables iniciales ... //////////////////////////////////////////

  If ( $_SESSION["rol"] == 2 ){
    $codClienteLogIn   = $_SESSION["IdLogin"];
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

    <title>NeoSistemas SRL | Tableros BI</title>

    <link rel="stylesheet" type="text/css" href="../../css/estilo.css">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.css" rel="stylesheet">

    <link href="../../css/custom.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../css/font-awesome.css" rel="stylesheet" type="text/css">

    <link href="../../css/input-decorations.css" rel="stylesheet">
    <link href="../../css/resaltador.css" rel="stylesheet">    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/jquery-1.10.2.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../css/all.min.css">
    <script type="text/javascript" src="../../js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="../../js/jszip.min.js"></script>

  </head>
  <body style="background-color:#F3F3F4; ">
    <div id="cargandoTablero" class="loading" style="visibility: hidden;">Loading&#8230;</div>
    <div class="row">
      <div class="panel-group" id="accordion" >
        <div class="panel panel-default" style="border-color: #A7BEE7; background-color: #A7BEE7; border-radius: 0px 0px 0px 0px " >
          <div class="ibox-title" style="background-color:#2F4050;">          
            <h5 style="color:#DFE4ED;">
              <a id="titulo" data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="color: #DFE4ED">
                Tableros BI - <?php echo $_SESSION["DescripcionEmp"] ?>
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
                    <div class="col-md-3">
                      <button id="tablero1" 
                              name="tablero1" 
                              style="padding: 5px 30px 5px 30px;" 
                              class="btn btn-xs btn-primary btn-block" 
                              type="button" 
                              onclick="recuperarTablero(1)">
                        <strong> Tablero 1 </strong>
                      </button>
                    </div>
                    <div class="col-md-3">
                      <button id="tablero2" 
                              name="tablero2" 
                              style="padding: 5px 30px 5px 30px;" 
                              class="btn btn-xs btn-primary btn-block" 
                              type="button" 
                              onclick="recuperarTablero(2)">
                        <strong> Tablero 2 </strong>
                      </button>
                    </div>
                    <div class="col-md-3 b-r">
                      <button id="tablero3" 
                              name="tablero3" 
                              style="padding: 5px 30px 5px 30px;" 
                              class="btn btn-xs btn-primary btn-block" 
                              type="button" 
                              onclick="recuperarTablero(3)">
                        <strong> Tablero 3 </strong>
                      </button>
                    </div>
                    <div class="col-md-3">
                      <button id="tablero3" 
                              name="tablero3" 
                              class="btn btn-sm btn-primary btn-block" 
                              style="padding: 5px 30px 5px 30px;" 
                              type="button" 
                              onclick="imprimirTablero()">
                        <span class="glyphicon glyphicon-print "></span>
                        <strong>Imprimir</strong>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div clas="row"> 
      <div id="divTablero" class="container-fluid" style="padding-right: 0px; padding-left: 0px">
        <iframe id="frameTablero" name="frameTablero" src="" width="100%" height="700" frameborder="0">
        </iframe>
      </div>
    </div>
    <script>
      function mostrarIconoCargando() {
        document.body.style.cursor='wait';
        document.getElementById("cargandoTablero").style.visibility = 'visible';
      }

      function ocultarIconoCargando() {
        document.body.style.cursor='default';
        document.getElementById("cargandoTablero").style.visibility = 'hidden';
      }

      function recuperarTablero(nroTablero){
        mostrarIconoCargando();
        $.post("../../comercial/nv_comercial/recuperarTableroBI.php", 
        { num_tablero:   nroTablero }, 
        function(data) {
          tablero = JSON.parse(data);
          if ( tablero.results_row.as_error_msg ){
            ocultarIconoCargando()
            alert ("Error en la conexión con el servidor del cliente: " + tablero.results_row.as_error_msg_js );
            return;
          }
          if ( tablero.results_row.as_return_msg ){
            ocultarIconoCargando()
            alert ("Alerta!: " + tablero.results_row.as_return_msg_js );
            return;
          }

          $("#frameTablero").attr("src", tablero.results_row.as_panel_bi_usu);
          $("#titulo").click();
          ocultarIconoCargando();

        })
      }

      function imprimirTablero(){
        $("#titulo").click();
        this.print();
      }

    </script>
  </body>
</html>