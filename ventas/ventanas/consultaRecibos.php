<div class="modal fade" id="consultaRecibos" role="dialog">
	<div class="modal-dialog modal-lg" style="overflow-y: initial; height: 20%">
    <div class="modal-content">
	    <div class="modal-header" style="padding:10px 20px;">
	       	<button type="button" class="close" data-dismiss="modal" style="color: #fff !important; text-shadow: none !important; opacity:1;font-size:20px">&times;
	      	</button>
	      	<h4><span class="glyphicon glyphicon-file"></span> Consulta de Detalle de Recibos</h4>
	    </div>
	    <div class="modal-body fontsize" style="padding:10px 10px 10px; overflow-y: initial">		        
      	<div class="row">
      		<strong>
      		<div id="reccobrovtasfec" class="col-md-12" style="padding-top:5px; padding-bottom:5px; padding-right:0px; padding-left:0px; text-align: right">
      		</div>
      		</strong>
      		<div id="recibocobro" class="col-md-12" style="padding-top:0px; padding-bottom:5px; padding-right:0px; padding-left:0px; text-align: right; border-bottom: 1px solid lightgrey;">
      		</div>
        	<div class="col-sm-2 col-md-2" style="padding-top:5px; padding-bottom:5px; padding-left:0px; text-align: left;">
        		<strong>Cliente:</strong>
        	</div>
        	<div id="rboclientvtasnomb" class="col-sm-10 col-md-10" style="padding-top:5px; padding-bottom:5px; padding-left:0px; text-align: left;">
        		UNDEFINED
        	</div>
        	<div class="col-sm-2 col-md-2" style="padding-top:5px; padding-bottom:5px; padding-left:0px; text-align: left;">
        		<strong>Domicilio:</strong>
        	</div>
        	<div id= "rbodomicilio" class="col-sm-10 col-md-10" style="padding-top:5px; padding-bottom:5px; padding-left:0px; text-align: left;">
        		UNDEFINED
        	</div>
        	<div class="col-sm-2 col-md-2" style="padding-top:5px; padding-bottom:5px; padding-left:0px; padding-right:0px; text-align: left;">
        		<strong>C.U.I.T.:</strong>
        	</div>
        	<div id= "clientvtascuit" class="col-sm-10 col-md-10" style="padding-top:5px; padding-bottom:5px; padding-left:0px; text-align: left;">
        		UNDEFINED
        	</div>
      	</div>
				<div class="col-md-12" style="padding-top:0px; padding-bottom:0px; padding-right: 20px; padding-left: 0px ">
					<table class="table table-hoover" style="margin-bottom: 0px; font-size: 10px ">
			      <thead style="background-color: lightgrey;">
				      <tr>
				      <!-- COLUMNAS DESKTOP -->
				        <th class="text-center" width="800px" colspan="3"> 
				        	<strong> Comprobante </strong>
				        </th>
				        <th class="text-center descarto" width="100px"> 
				        	<strong> Fecha </strong>
				        </th>
				        <th class="text-center soloMobile" width="50px"> 
				        	<strong> Fecha </strong>
				        </th>
				        <th class="text-center descarto" width="100px"> 
				        	<strong> Fecha Vto. </strong>
				        </th>
				        <th class="text-center descarto" width="100px"> 
				        	<strong> Importe </strong>
				        </th>
				        <th class="text-center descarto" width="100px"> 
				        	<strong> Cancelado </strong>
				        </th>
				        <th class="text-center descarto" width="100px">
				        	<strong> Total </strong>
				        </th>
				        <th class="text-center soloMobile" width="70px">
				        	<strong> Total </strong>
				        </th>
				      </tr>
			    	</thead>
			    	<tbody>
		    	  </tbody> 
					</table>
				</div>
		    <div class="container-fluid" style="max-height: 220px; overflow-y: auto; padding-right: 5px; padding-left: 0">
		      <div class="row">
		      	<div id="xmlconsulta" class="col-sm-12">
		      	</div>
				    <table class="table table-hoover" id="detalleRecibo">
				    	<tbody>
			    	  </tbody> 
						</table>
			    </div>
		    </div>
		  </div>
			<div class="modal-footer" style="border-top: 0px; border-bottom: 0px; padding: 5px 8px 5px 8px">
				<table class="table table-bordered" id="totalesRecibo" style="margin-bottom: 0px; font-size: 10px;" >
		      <thead style="background-color: lightgrey;">
			      <tr>
			      	<th style="text-align: center">
			      		A Cobrar
			      	</th>
			      	<th style="text-align: center">
			      		Retenciones
			      	</th>
			      	<th style="text-align: center">
			      		Cheques
			      	</th>
			      	<th style="text-align: center" class="descarto">
			      		Transferencias
			      	</th>
			      	<th style="text-align: center" class="descarto">
			      		Tarjeta
			      	</th>
			      	<th style="text-align: center" class="descarto">
			      		Efectivo
			      	</th>
			      </tr>
        	</thead>
        	<tbody>
        	</tbody>
      	</table>
				<table class="table table-bordered" id="totalesRboMobile" style="margin-bottom: 0px; font-size: 10px;" >
		      <thead style="background-color: lightgrey;">
			      <tr>
			      	<th style="text-align: center" class="soloMobile">
			      		Transferencias
			      	</th>
			      	<th style="text-align: center" class="soloMobile">
			      		Tarjeta
			      	</th>
			      	<th style="text-align: center" class="soloMobile">
			      		Efectivo
			      	</th>
			      </tr>
        	</thead>
        	<tbody>
        	</tbody>
      	</table>
      </div>
    </div>
  </div>
</div>