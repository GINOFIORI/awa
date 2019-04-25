<!DOCTYPE HTML>


<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="../templates/jb_creativ/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

<title>Log</title>

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
<script src="js/sorttable.js"></script>

<script type="text/javascript" src="js/funcionesComunes.js"></script>
<script type="text/javascript" src="admin/js_admin/funcionesLog.js"></script>

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
 // if ($alertaErrores!==''){
   // echo '<script type="text/javascript"> alert("' . $alertaErrores . '");</script>';
//  }

include_once('include/admin_header.php');
include_once('admin/nv_admin/admin_abm_log_ctrl.php');

 ?>
<div class="container-fluid" id="contenido">
	<div class="row">
	    <h3>LOG del Sistema</h3>
	</div>
	<form action="admin.php" method="post" >
	<div id="cargandoLog" class="loading" style="visibility: hidden;">Loading&#8230;</div>	
	<input name="log" id='log' style="visibility: hidden;" type="hidden">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px; border-bottom: 1px dotted #A1D9DF; padding-bottom: 10px;">

				<div class="Mobile9 col-md-5 col-lg-5">

					<div class='Mobile8 col-xs-12 col-sm-12 col-md-2 col-lg-2' style="padding: 0px; margin-top: 2px;">
	          <label style="color: #1c84c6; font-size: 8pt">Empresa</label>
	        </div>
		      <div class='Mobile9 col-xs-12 col-sm-12 col-md-2 col-lg-2'>
		      	<select style="font-size: 8pt; height: 22px; padding-top: 0; padding-bottom: 0;" name="idCliente" class="Mobile9 form-control" id="idCliente">
						   <?php                 				
									foreach ($lista_config as $key => $configuracion)  {
                    	?> 
                    	<option <?php if((isset($_POST['idCliente'])) && ($_POST['idCliente']==$configuracion->IdCliente))echo 'selected="selected"'; ?>  value=<?php echo $configuracion->IdCliente ?> > <?php echo $configuracion->IdCliente ?> </option>
                    		<?php }
                     
								 ?>
            </select>
          </div>

	        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style="padding: 0px; margin-top: 2px;">
	          <label style="color: #1c84c6; font-size: 8pt">Fecha Desde</label>
	        </div>
	        <div class='Mobile1 Mobile9 col-xs-12 col-sm-12 col-md-2 col-lg-2'>
	        	<input id    = "fechaDesde"
                   name  = "fechaDesde"
                   value = "<?php 
               								if ( isset($_POST['fechaDesde']) ){
               									echo date($_POST['fechaDesde']);
               								}else{ 
               									echo date("Y-m-d");
               								} 
                   					?>"
                   style = "height: 22px; font-size: 8pt; padding-left: 5px; padding-right: 5px;"
                   type  = "Date" 
                   class = "form-control unstyled">
					</div>
	     
	      	<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style="padding: 0px; margin-top: 2px;">
	          <label style="color: #1c84c6; font-size: 8pt">Fecha Hasta</label>
	        </div>
		      <div class='Mobile1 Mobile9 col-xs-12 col-sm-12 col-md-2 col-lg-2'>
		      	<input id    = "fechaHasta"
                   name  = "fechaHasta"
                   value = "<?php 
               								if ( isset($_POST['fechaHasta']) ){
               									echo date($_POST['fechaHasta']);
               								}else{ 
               									echo date("Y-m-d");
               								} 
                   					?>"
                   style = "height: 22px; font-size: 8pt; padding-left: 5px; padding-right: 5px;"    
                   type  = "Date"  
                   class = "form-control unstyled">
          </div>
	    	</div> <!--CIERRE FILTRO FECHAS Y EMPRESA -->
		    <div class="Mobile2 col-md-4 col-lg-4">

		    	<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style="margin-top: 2px;">
	          <label style="color: #1c84c6; font-size: 8pt">Usuario</label>
	        </div>
		      <div class='Mobile9 col-xs-12 col-sm-12 col-md-3 col-lg-3'>
		      	<input id    = "usuarioBusqueda"
                   name  = "usuarioBusqueda"
                   value = "<?php 
               								if ( isset($_POST['usuarioBusqueda']) ){
               									echo $_POST['usuarioBusqueda'];
               								}
                   					?>"
                   style = "height: 22px; font-size: 8pt;"    
                   type  = "text"  
                   class = "form-control"
                   autocomplete="off">
          </div>

		    	<div class='Mobile8 col-xs-12 col-sm-12 col-md-2 col-lg-2' style="padding: 0px; margin-top: 2px;">
	          <label style="color: #1c84c6; font-size: 8pt">Rol</label>
	        </div>
		      <div class='input-group Mobile9 col-xs-12 col-sm-12 col-md-4 col-lg-4'>
		      	<select style="font-size: 8pt; height: 22px; padding-top: 0; padding-bottom: 0;" name="roles" class="form-control" id="roles">
           			<option <?php if((isset($_POST['roles'])) && ($_POST['roles']=="0"))echo 'selected="selected"'; ?> value="0">Todos los roles</option>
           			<option <?php if((isset($_POST['roles'])) && ($_POST['roles']=="1"))echo 'selected="selected"'; ?> value="1">Usuario Allways ERP</option>
								<option <?php if((isset($_POST['roles'])) && ($_POST['roles']=="2"))echo 'selected="selected"'; ?> value="2">Cliente</option>
								<option <?php if((isset($_POST['roles'])) && ($_POST['roles']=="3"))echo 'selected="selected"'; ?> value="3">Vendedor</option>
								<option <?php if((isset($_POST['roles'])) && ($_POST['roles']=="4"))echo 'selected="selected"'; ?> value="4">Proveedor</option>
            </select>
          </div>

		  	</div> <!-- CIERRE FILTROS USUARIO Y ROL  -->

		  	<div class="Mobile3 col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding: 0px;">
		  		<div class='Mobile6 col-xs-6 col-sm-6 col-md-6 col-lg-6' >
		  			<button type="submit" name="aplicarFiltros" id="aplicarFiltros" value="Aplicar" style="padding: 2px 3px;" class="Mobile4 btn btn-success" >Aplicar</button>      
		  		</div>
		  		<div class='Mobile7 col-xs-6 col-sm-6 col-md-6 col-lg-6' style="text-align: center;" >
						<buttom  class="Mobile5 btn btn-success" data-toggle="modal" data-target="#detalleAdmin" style="padding: 2px 3px;" onClick=pedirContraseña()>Contraseñas</buttom>	
					</div>
				</div>
				    <?php
				if ( isset ( $_POST['aplicarFiltros'] )  or  isset ( $_POST['revelar'] ) ) {

					include_once('includes/maestro.php');
					include("includes/conexionBD.php"); 

					$_SESSION['idCliente'] = $_POST['idCliente'];

					$IdCliente = $_SESSION['idCliente'];
					
					$consulta  = "Select * from awa_config where IdCliente = '$IdCliente'";
					
					$result    = mysqli_query($link,$consulta) or die (mysqli_error($link));
					$fila      = mysqli_fetch_array($result);

					if ( mysqli_num_rows($result) != 1 ) { ?>

						<div class="alert alert-danger errores" style="text-align: center; margin-top: 7px; margin-bottom: 0px !important; padding-top: 2px; padding-bottom: 2px">
							<p><span style="font-size:8pt; color:#CC3300; padding-top: 2px; padding-bottom: 2px !important" ><b>La empresa no tiene cuenta asignada.</b></span></p>			
						</div>

					<?php 
					}else{

						$maestro = Maestro::instanciar();

						$UrlCliente        = $maestro->desencriptar($fila['UrlCliente'],$fila['IdCliente']);
						$ServidorCliente   = $maestro->desencriptar($fila['ServidorCliente'],$fila['IdCliente']);
						$BDCliente         = $maestro->desencriptar($fila['BDCliente'],$fila['IdCliente']);
						$IdEmpCliente      = $fila['IdEmpCliente'];
						$IdSucCliente      = $fila['IdSucCliente'];
						$CaminoAwaDownload = $maestro->desencriptar($fila['CaminoAwaDownload'],$fila['IdCliente']);
						$CaminoAwaBR       = $maestro->desencriptar($fila['CaminoAwaBR'],$fila['IdCliente']);
						$UsuarioAdm				 = $maestro->desencriptar($fila['UsuarioAdm'],$fila['IdCliente']);
						$PassAdm					 = $fila['PassAdm'];

						$ServidorCliente   = addslashes($ServidorCliente);
						$CaminoAwaBR			 = addslashes($CaminoAwaBR);

						if ( isset ( $_POST['revelar'] ) ) {

							$passUsuarioAdminIngresada = $_POST['PassUsuario'] ;

								if ( !(password_verify($passUsuarioAdminIngresada,$_SESSION["pass"] ) ) ) {
									$mostrarPass = 0 ;
								}else{
						    	$mostrarPass = 1;
						    }

								echo "<script>";
								echo "recuperarLog('$IdCliente','$UrlCliente','$ServidorCliente','$BDCliente','$IdEmpCliente','$IdSucCliente','$CaminoAwaDownload','$CaminoAwaBR','$UsuarioAdm','$PassAdm','$mostrarPass')";
								echo "</script>";

						}else if ( isset ( $_POST['aplicarFiltros'] ) ) {
					
							echo "<script>";
							echo "recuperarLog('$IdCliente','$UrlCliente','$ServidorCliente','$BDCliente','$IdEmpCliente','$IdSucCliente','$CaminoAwaDownload','$CaminoAwaBR','$UsuarioAdm','$PassAdm')";
							echo "</script>";

						}
					}
				}//cierra if general

  ?>

	  	</div> <!-- ACÁ SE CIERRA EL DIV DE FILTROS -->
	  </div> <!-- cierra row -->

    <!-- MODAL DE CONTRASEÑA PARA REVELAR PASS -->
    <!-- Esta Modal debe ir dentro del formulario para poder ejecutarse el submit. La de comando debe quedar fuera, ya que tiene un botón para descargar los datos recibidos -->
	  <div class="modal fade" id="detalleAdmin" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
    			<input type="hidden" name="log" value='log' style="visibility: hidden">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Confirmar Contraseña</h4>
	        </div>
	        <div class="modal-body">						
			    <div class="form-group">
			      <label for="PassUsuario">Contraseña</label>
			      <input type="password" class="form-control" id="PassUsuario" placeholder="Ingresar Password" name="PassUsuario" value=''>
			    </div>
	        </div>
	        <div class="modal-footer" id="boton">
	        	<button type="Submit" id="revelar" name="revelar" value="revelar" class="btn btn-success">Aceptar</button>
	        </div>
	      </div>
	    </div>
	  </div>	
	</form>

  <!-- MODAL DE COMANDO ENVIADO -->
  <div class="modal fade" id="comando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #2F4050; color:white; text-align: center; font-size: 30px">
          <button type="button" class="close" onclick="" data-dismiss="modal" aria-label="Close" style="color: #fff !important; text-shadow: none !important; opacity:1;"> 
            <span aria-hidden="true">&times;</span>
          </button> 
          <h4><span class="glyphicon glyphicon-th-large"></span> Comando Enviado </h4>
          </div>
          <div class="modal-body">
          	<div id="mostrarComando0"></div>
          	<div id="mostrarComando1"></div>
          	<div id="mostrarComando2"></div>
          	<div id="mostrarComando3"></div>
          	<div id="mostrarComando4"></div>
          	<div id="mostrarComando5"></div>
          	<div id="mostrarComando6"></div>
          	<div id="mostrarComando7"></div>
          	<div id="mostrarComando8"></div>
          	<div id="mostrarComando9"></div>
          	<div id="mostrarComando10"></div>
          	<div id="mostrarComando11"></div>
          	<div id="mostrarComando12"></div>
          	<div id="mostrarComando13"></div>
          	<div id="mostrarComando14"></div>
          	<div id="mostrarComando15"></div>
          	<div id="mostrarComando16"></div>
          	<div id="mostrarComando17"></div>
          	<div id="mostrarComando18"></div>
          	<div style="display: flex; align-items: center; justify-content: center; padding-top: 10px">
          		<button style="width:38; height:34" class="btn btn-default" id="comandoRecibidoModal" data-toggle="modal" onclick="">Datos Recibidos <i class="fa fa-download" aria-hidden="true"></i></button>
          	</div>
        </div><!-- Se cierra modal body --> 
      </div><!-- Se cierra modal-content --> 
    </div><!-- Se cierra modal-dialog --> 
  </div><!-- Se cierra modal fade-->

	<div class="row">
    <table class="table table-hover table-striped sortable" id="resultadoLog">
      <thead>
        <tr>
          <th class="text-center fontsize descarto" >ID</th>
          <th class="text-center fontsize descarto" >IP Visitante</th>
          <th class="text-center fontsize" >Fecha y Hora</th>
          <th class="text-center fontsize" >ms.</th>
          <th class="text-center fontsize" >Usuario</th>
          <th class="text-center fontsize descarto" >Contraseña</th>
          <th class="text-center fontsize" >Rol</th>
        </tr>
      </thead>
      <tbody style="font">

      </tbody>
    </table>	

  </div><!-- Se cierra row-->

</div> <!-- Se cierra container-->
<script>

	function pedirContraseña() {
		document.getElementById('PassUsuario').value 		= '';
		document.getElementById('PassUsuario').readOnly = false;
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
