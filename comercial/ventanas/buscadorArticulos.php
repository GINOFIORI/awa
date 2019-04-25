<!DOCTYPE HTML>
<html lang="en">
<head>
	
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  
	<style>
		.modal-header, h4, .close {
		    background-color: #2F4050;
		    color:white !important;
		    text-align: center;
		    font-size: 10pt;

		}
		.modal-footer {
		    background-color: #f9f9f9;
		}
	</style>

</head>
<body>
	<div class="modal fade" id="buscarArticulos" name="buscarArticulos" role="dialog">
		<div class="modal-dialog" style="overflow-y: initial;">
	    <div class="modal-content" style="max-height: 500px !important; overflow: hidden;">
	    	<form id="busqueda"
              name="busqueda" 
              action="<?php echo $_SERVER['PHP_SELF'];?>"
              method="POST">
			    <div class="modal-header" style="padding:10px 20px;">
			       	<button type="button" class="close" data-dismiss="modal" style="color: #fff !important; text-shadow: none !important; opacity:1;">&times;</button>
			      	<h4><i class="fa fa-binoculars" aria-hidden="true"></i> Buscador de Articulos</h4>
			    </div>
			    <div class="modal-body" style="padding:10px 10px 10px; overflow-y: initial">		        
	        	<div class="form-group">
	          	<input type  = "text" 
	          				 class = "form-control" 
	          				 id    = "codAdminBuscador" 
	          				 name  = "codAdminBuscador" 
	          				 placeholder = "Buscar por c&oacute;digo">
	        	</div>
	        	<div class="form-group">
	          	<input type  = "text" 
	          				 class = "form-control" 
	          				 id    = "descArticBuscador" 
	          				 name  = "descArticBuscador" 
	          				 placeholder = "Buscar por descripci&oacute;n">
	        	</div>
	        	<button id="buscar" name="buscar" style="padding: 5px 30px 5px 30px;" class="btn btn-xs btn-primary" type="button" onclick="buscarArticulo()"><span class="glyphicon glyphicon-search"></span><strong> Buscar</strong></button>
			    </div>
			    <div class="container-fluid" style="height: 330px; overflow-y: auto; padding-right: 10px; padding-left: 10px">
			      <div class="row">
				      <div id="buscandoArtic" class="text-center indicadorCargando" style="padding-top: 80px; visibility: hidden;">
				        <i class="fa fa-spinner fa-spin fa-fw fa-4x fa fa-align-center" ></i>
				      </div>
					    <table class="table table-hover sortable" id="resultadoBusquedaArtic" name="resultadoBusquedaArtic">
				      <thead style="background-color: lightgrey;">
					      <tr>
					        <th class="text-center" width="20%"><button type="button" style ="border:none; outline: none; background-color: transparent;"><strong> C&oacute;digo </strong></button></th>
					        <th class="text-center" ><button type="button" style ="border:none; outline: none; background-color: transparent;"><strong> Descripción </strong></button></th>
					      </tr>
				    	</thead>
				    	<tbody>
				    	</tbody>
							</table>
				    </div>
			    </div>
		    </form>
	    </div>
	  </div>
	</div>
 <script src="../../comercial/js_comercial/funcionesBuscadorArtic.js"></script>
</body>
</html>