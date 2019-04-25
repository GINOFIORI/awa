<?php

function buscarClientes($codCliente , $nombreCliente){

	$comandoBuscarCliente = "BUSCARCLIENTES(".$codCliente.",".$nombreCliente.")";
	$clientes   = conexionWS ( 3 , $comandoBuscarCliente );

  If ( gettype($clientes)=='array' ){
  ?>
    <div class="alert alert-danger errores">
      <p><span style="font-size:10pt; color:#CC3300"><b><?php echo 'Mensaje Info: ' . $clientes[1] ; ?></b></span></p>
    </div>
  <?php
    die();
  }

  return $clientes;
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=2">

  <style>
  .modal-header, h4, .close {
      background-color: #2F4050;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
  .modal-footer {
      background-color: #f9f9f9;
  }
  </style>
  <?php
  if (isset($_REQUEST['buscar'])){ // BUSCAR CLIENTES /////////////////////////////////////////////////

	   if ( array_key_exists('codClienteBuscador', $_REQUEST) ) {
	   	$codClienteBuscador = $_REQUEST['codClienteBuscador'];
	   };

	   if ( array_key_exists('nombreClienteBuscador', $_REQUEST) ) {
	   	$nombreClienteBuscador = $_REQUEST['nombreClienteBuscador'];
	   };

	  $clientes = buscarClientes($codClienteBuscador,$nombreClienteBuscador);

  }
  ?>

</head>
<body>

	<div class="modal fade" id="buscarClientes" name="buscarClientes" role="dialog">
		<div class="modal-dialog" style="overflow-y: initial;">
	    <div class="modal-content">
	      <div class="modal-header" style="padding:10px 20px;">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4><span class="glyphicon glyphicon-user"></span> Buscador de clientes</h4>
	      </div>
	      <div class="modal-body" style="padding:10px 10px 10px; overflow-y: auto">
	        <form role="form" method="POST">
	          <div class="form-group">
	            <input type="text" class="form-control" id="codClienteBuscador" name="codClienteBuscador" placeholder="Buscar por c&oacute;digo">
	          </div>
	          <div class="form-group">
	            <input type="text" class="form-control" id="nombreClienteBuscador" name="nombreClienteBuscador" placeholder="Buscar por descripci&oacute;n">
	          </div>
	          <button id="buscar" name="buscar" style="padding: 5px 30px 5px 30px;" class="btn btn-xs btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span><strong> Buscar</strong></button>
	        </form>
	      </div>
	      <div class="container-fluid" style="padding-right: 0px; padding-left: 0px; max-height: 200px; overflow-y: auto">
	      	<div class="row">
		      	<table class="table table-striped" id="tablaClientes" name="tablaClientes">
      		    <thead>
					      <tr class="clickable-row">
					        <th>C&oacute;digo</th>
					        <th>Nombre</th>
					      </tr>
					    </thead>
			      	<tbody>
					      <?php
					      if ( isset($clientes) ) {
									foreach($clientes->results_row as $item){
								?>
										<tr>
										<a>
										<td>
								<?php
										echo "(". (string)$item->clientvtascod .")";
								?>
										</td>
										<td>
								<?php
										echo (string)$item->clientvtasnomb;
								?>
										</td>
										</a>
										</tr>
								<?php
									}
								}
					      ?>
					    </tbody>
			    	</table>
						<select multiple class="form-control" id="sel2">
			        <option>1</option>
			        <option>2</option>
			        <option>3</option>
			        <option>4</option>
			        <option>5</option>
			      </select>
		    	</div>
	      </div>
	      <div class="modal-footer">
					<button id="seleccionar" name="seleccionar" style="padding: 7px 20px 7px 20px;" class="btn btn-xs btn-primary" type="submit"><strong>Seleccionar</strong></button>
	      </div>
	    </div>
	  </div>
	</div> 

	<script>
	$(document).ready(function(){
	    $("#myBtn").click(function(){
	        $("#myModal").modal();
	    });
	});
	</script>

	</body>