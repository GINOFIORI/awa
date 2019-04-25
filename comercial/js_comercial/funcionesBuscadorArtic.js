  function mostrarIconoBuscandoArtic() {

    var buscandoArtic = document.getElementById("buscandoArtic");
    if (!(buscandoArtic==null)){
      document.getElementById("buscandoArtic").style.visibility = 'visible';
    }

    var cargandoDatosArtic = document.getElementById("cargandoDatosArtic");
    if (!(cargandoDatosArtic==null)){
      document.getElementById("cargandoDatosArtic").style.visibility = 'visible';
    }
	 }

  function ocultarIconoBuscandoArtic() {
    var buscandoArtic = document.getElementById("buscandoArtic");
    if (!(buscandoArtic==null)){
      document.getElementById("buscandoArtic").style.visibility = 'hidden';
    }

    var cargandoDatosArtic = document.getElementById("cargandoDatosArtic");
    if (!(cargandoDatosArtic==null)){
      document.getElementById("cargandoDatosArtic").style.visibility = 'hidden';
    }
  }

	function buscarArticulo(){
		mostrarIconoBuscandoArtic();
		var codAdmin  = document.getElementById("codAdminBuscador").value;
		var descArtic = document.getElementById("descArticBuscador").value;
    

		$.post("../../comercial/nv_comercial/buscarArticulos.php", 
      { cod_articulo: codAdmin, 
        desc_articulo: descArtic }, 
      function(data) {
        articulos = JSON.parse(data);
        if ( articulos.results_row.as_error_msg ){
        	$("#resultadoBusquedaArtic tbody tr").remove()
        	ocultarIconoBuscandoArtic();
          $('#resultadoBusquedaArtic tbody').append(
          	'<tr>' +
          	'<td colspan="2"' + 
          	'<div class="container" style="width: 100%; text-align: center">' +
		          '<div class="alert alert-danger errores" style="text-align: center; width: 100%">'+
		          	'<p><span style="font-size:10pt; color:#CC3300"><b>Error en la conexión con el servidor del cliente</b></span></p>' + 
		            '<p><span style="font-size:10pt; color:#CC3300"><b>' + articulos.results_row.as_error_msg + '</b></span></p>	'+
		          '</div>'+
		        '</div>' + 
		        '</td>' +
		        '<tr>'
	        )
          return;
        }
        if ( articulos.results_row.as_return_msg ){
        	$("#resultadoBusquedaArtic tbody tr").remove()
          ocultarIconoBuscandoArtic();
          $('#resultadoBusquedaArtic tbody').append(
          	'<tr>' +
          	'<td colspan="2"' + 
          	'<div class="container" style="width: 100%; text-align: center">' +
		          '<div class="alert alert-danger errores" style="text-align: center; width: 100%">'+
		            '<p><span style="font-size:10pt; color:#CC3300"><b>' + articulos.results_row.as_return_msg + '</b></span></p>	'+
		          '</div>'+
		        '</div>' + 
		        '</td>' +
		        '<tr>'
	        )
          return;
        }
        $("#resultadoBusquedaArtic tbody tr").remove()


      if (articulos.results_row.length>0){
        //////////////////// ES ARRAY //////////////////////////
        var articuloConsultado = articulos.results_row
      }else{
        ///////////////// TRANSFORMAR EN ARRAY /////////////////
        var articuloConsultado = [];
        var object = new Object();
        articuloConsultado[0] = object;
        $.each(articulos.results_row, function(key, value) {
          articuloConsultado[0][key] = value
        });

      }

      for (var i = 0; i < articuloConsultado.length ; i++ ) {
      	$('#resultadoBusquedaArtic tbody').append(
          '<tr style="cursor:pointer" onclick="seleccionarArticulo('+ "'" + articuloConsultado[i].articcodadmin + "'" + ',' + "'" + articuloConsultado[i].articdesc + "'" + ',' + "'" + articuloConsultado[i].articprecvta + "'" + ',' + "'" + articuloConsultado[i].alicivacod + "'" + ')">'
          +'<td style="text-align:center">' + articuloConsultado[i].articcodadmin + '</td>'
          +'<td>'+ articuloConsultado[i].articdesc +'</td>'
          +'</tr>'
        );
      }
    		ocultarIconoBuscandoArtic();
      }
    );
	}

	function seleccionarArticulo(articCodAdmin, articDesc, articPrecVta, articAlicIvaCod ){
    $("#resultadoBusquedaArtic tbody tr").remove();
		ocultarIconoBuscandoArtic();
    document.getElementById("articCodAdmin").value    = articCodAdmin
    document.getElementById("articDesc").innerHTML    = articDesc
    document.getElementById("articPrecVta").innerHTML = articPrecVta

    alicIvaCod = document.getElementById("alicIvaCod");
    if (!(alicIvaCod==null)){ alicIvaCod.innerHTML = articAlicIvaCod }

    $("#buscarArticulos").on("hidden.bs.modal", function () {
      document.getElementById("cantidad").focus()
    });
    $("#buscarArticulos").modal("hide");
	}
