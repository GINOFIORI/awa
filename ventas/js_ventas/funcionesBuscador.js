  function mostrarIcono() {
    var buscando = document.getElementById("buscando");
    if (!(buscando==null)){
      document.getElementById("buscando").style.visibility = 'visible';
    }

    var cargandoDatosCli = document.getElementById("cargandoDatosCli");
    if (!(cargandoDatosCli==null)){
      document.getElementById("cargandoDatosCli").style.visibility = 'visible';
    }
    if (!(cargandoDatosCli==null)){
      document.getElementById("cargandoDatosCli").style.display = '';
    }

	 }

  function ocultarIcono() {
    var buscando = document.getElementById("buscando");
    if (!(buscando==null)){
      document.getElementById("buscando").style.visibility = 'hidden';
    }

    var cargandoDatosCli = document.getElementById("cargandoDatosCli");
    if (!(cargandoDatosCli==null)){
      document.getElementById("cargandoDatosCli").style.visibility = 'hidden';
    }
  }

	function buscarCliente(){
    /*

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                                                                                          //
    //     ESTA FUNCIÓN SE EJECUTA DESDE EL BUSCADOR DE CLIENTES (VENTANA MODAL) AL HACER CLIC EN BUSCAR        //
    //                                                                                                          //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

    */

		mostrarIcono();
		var codCliente 		= document.getElementById("codClienteBuscador").value;
		var nombreCliente = document.getElementById("nombreClienteBuscador").value;

		$.post("../../ventas/nv_ventas/buscarClientes.php", 
      { cod_cliente_busca: codCliente, 
        nom_cliente_busca: nombreCliente }, 
      function(data) {
        clientes = JSON.parse(data);
        if ( clientes.results_row.as_error_msg ){
        	$("#resultadoBusqueda tbody tr").remove()
        	ocultarIcono();
          $('#resultadoBusqueda tbody').append(
          	'<tr>' +
          	'<td colspan="2"' + 
          	'<div class="container" style="width: 100%; text-align: center">' +
		          '<div class="alert alert-danger errores" style="text-align: center; width: 100%">'+
		          	'<p><span style="font-size:10pt; color:#CC3300"><b>Error en la conexión con el servidor del cliente</b></span></p>' + 
		            '<p><span style="font-size:10pt; color:#CC3300"><b>' + clientes.results_row.as_error_msg + '</b></span></p>	'+
		          '</div>'+
		        '</div>' + 
		        '</td>' +
		        '<tr>'
	        )
          return;
        }
        if ( clientes.results_row.as_return_msg ){
        	$("#resultadoBusqueda tbody tr").remove()
          ocultarIcono();
          $('#resultadoBusqueda tbody').append(
          	'<tr>' +
          	'<td colspan="2"' + 
          	'<div class="container" style="width: 100%; text-align: center">' +
		          '<div class="alert alert-danger errores" style="text-align: center; width: 100%">'+
		            '<p><span style="font-size:10pt; color:#CC3300"><b>' + clientes.results_row.as_return_msg + '</b></span></p>	'+
		          '</div>'+
		        '</div>' + 
		        '</td>' +
		        '<tr>'
	        )
          return;
        }
        $("#resultadoBusqueda tbody tr").remove()

        if (clientes.results_row.length>0){
          //////////////////// ES ARRAY //////////////////////////
          var listaClientes = clientes.results_row
        }else{
          ///////////////// TRANSFORMAR EN ARRAY /////////////////
          var listaClientes = [];
          var object = new Object();
          listaClientes[0] = object;
          $.each(clientes.results_row, function(key, value) {
            listaClientes[0][key] = value
          });
        }

        /////////////////// SETEAR LOS DATOS EN LA LISTA

        for (var i = 0; i < listaClientes.length ; i++ ) {

          // ARMAR LLAMADA AL EVENTO QUE SIRVE PARA SELECCIONAR EL CLIENTE DEL RENGLON

          if ( typeof(listaClientes[i].callesnomb)==='string' ){
            domicilio = listaClientes[i].callesnomb;
          }

          if (typeof(listaClientes[i].clientvtasaltdomic)==='string'){
            domicilio = domicilio + ' ' + listaClientes[i].clientvtasaltdomic;
          }

          if (typeof(listaClientes[i].clientvtaspisodomic)==='string'){
            domicilio = domicilio + ' Piso:' + listaClientes[i].clientvtasaltdomic;
          }

          if (typeof(listaClientes[i].clientvtasdptodomic)==='string'){
            domicilio = domicilio + ' Dpto.:' + listaClientes[i].clientvtasdptodomic;
          }

          if (typeof(listaClientes[i].clientvtasadicdomic)==='string'){
            domicilio = domicilio + ' (' + listaClientes[i].clientvtasadicdomic; + ')'
          }

          if (typeof(listaClientes[i].localicod)==='string'){
            domicilio = domicilio + '. ' + listaClientes[i].localicod;
          }

          if (typeof(listaClientes[i].localinomb)==='string'){
            domicilio = domicilio + ' - ' + listaClientes[i].localinomb;
          }

          if (typeof(listaClientes[i].provinnomb)==='string'){
            domicilio = domicilio + ', ' + listaClientes[i].provinnomb;
          }

          var domicilioCli = encodeURI(domicilio);
          var nombreCli    = encodeURI(listaClientes[i].clientvtasnomb );

          if ( typeof(listaClientes[i].clientvtasdtogen)=='string'){
            var descuentoCli = listaClientes[i].clientvtasdtogen;
          }else{
            var descuentoCli = '';
          }

          var valorOnClick = "pegarCliente('" + listaClientes[i].clientvtascod   + "'," +
                                          "'" + nombreCli   + "'," +
                                          "'" + domicilioCli                   + "'," +
                                          "'" + descuentoCli + "'," +
                                          "'" + listaClientes[i].vendvtascod      + "')";

        	$('#resultadoBusqueda tbody').append(
            '<tr style="cursor:pointer" onclick=' + valorOnClick + '>'
            +'<td style="text-align:center">'+ listaClientes[i].clientvtascod  +'</td>'
            +'<td>'+ listaClientes[i].clientvtasnomb +'</td>'
            +'</tr>'
          );
        }
    		ocultarIcono();
      }
    );
	}

	function seleccionarCliente(codCliente){

    /*

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                                                                                          //
    //     ESTA FUNCIÓN SE EJECUTA CUANDO SE CAMBIA DE FOCO DESDE EL CONTROL DONDE SE INGRESA EL CÓDIGO DE      //
    //     CLIENTE DESDE CUALQUIER PROGRAMA.                                                                     //
    //                                                                                                          //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

    */

    $("#cuentaCorriente tbody tr").remove();
		mostrarIcono();
		$.post("../../ventas/nv_ventas/selClienteBuscador.php", 
      { cod_cliente: codCliente }, 
      function(data) {
        cliente = JSON.parse(data);

        // recuperar secciones para luego detectar si existen en la pagina //

        var codCliente        = document.getElementById("codCliente")
        var abrirBuscador     = document.getElementById("abrirBuscador")
        var razonSocial       = document.getElementById("razonSocial")
        var domicilioCliente  = document.getElementById("domicilioCliente")
        var clientVtasNomb    = document.getElementById("clientVtasNomb")
        var descuento         = document.getElementById("descuento")
        var descuentoGeneral  = document.getElementById("descuentoGeneral")
        var ddlb_vendedores   = document.getElementById("listaVendedores")
        var headerDeImpresion = document.getElementById("headerDeImpresion")
        var clientVtasTelef   = document.getElementById("clientVtasTelef")

        // secciones de la utilidad de nota de pedido //

        var articCodAdmin   = document.getElementById("articCodAdmin")
        var cantidad        = document.getElementById("cantidad")
        var buscaArtic      = document.getElementById("buscaArtic")
        var agregar         = document.getElementById("agregar")
        var agregarMobile   = document.getElementById("agregarMobile")

        if ( cliente.results_row.as_error_msg ){
          ocultarIcono();
          document.getElementById("codCliente").value = ""

          if (!(razonSocial==null)){ razonSocial.innerHTML = "" }

          if (!(domicilioCliente==null)){ domicilioCliente.innerHTML = "" }

          if(!(clientVtasNomb==null)){ clientVtasNomb.value = "" }

          if(!(descuento==null)){ descuento.value = "" }

          if(!(articCodAdmin==null)){ articCodAdmin.disabled = "disabled" }

          if(!(cantidad)==null){ cantidad.disabled = "disabled" }

          if(!(buscaArtic)==null){ buscaArtic.disabled = "disabled" }

          if(!(agregar)==null){ agregar.disabled = "disabled" }

          if(!(agregarMobile)==null){ agregarMobile.disabled = "disabled" }

          alert ("Error en la conexión con el servidor del cliente: " + cliente.results_row.as_error_msg_js );          
          return;
        };
        if ( cliente.results_row.as_return_msg ){
          ocultarIcono();
          document.getElementById("codCliente").value = ""

          if (!(razonSocial==null)){ razonSocial.innerHTML = "" }

          if (!(domicilioCliente==null)){ domicilioCliente.innerHTML = "" }

          if(!(clientVtasNomb==null)){ clientVtasNomb.value = "" }

          if(!(descuento==null)){ descuento.value = "" }

          if(!(articCodAdmin==null)){ articCodAdmin.disabled = "disabled" }

          if(!(cantidad)==null){ cantidad.disabled = "disabled" }

          if(!(buscaArtic)==null){ buscaArtic.disabled = "disabled" }

          if(!(agregar)==null){ agregar.disabled = "disabled" }

          if(!(agregarMobile)==null){ agregarMobile.disabled = "disabled" }

          alert ("Alerta!: " + cliente.results_row.as_return_msg_js );
          return;
        };

        $("#buscarClientes").modal("hide");

        var domicilio = '';

        if ( typeof(cliente.results_row.callesnomb)==='string' ){ domicilio = cliente.results_row.callesnomb }

        if (typeof(cliente.results_row.clientvtasaltdomic)==='string'){ domicilio = domicilio + ' ' + cliente.results_row.clientvtasaltdomic }

        if (typeof(cliente.results_row.clientvtaspisodomic)==='string'){ domicilio = domicilio + ' Piso:' + cliente.results_row.clientvtasaltdomic }

        if (typeof(cliente.results_row.clientvtasdptodomic)==='string'){ domicilio = domicilio + ' Dpto.:' + cliente.results_row.clientvtasdptodomic }

        if (typeof(cliente.results_row.clientvtasadicdomic)==='string'){ domicilio = domicilio + ' (' + cliente.results_row.clientvtasadicdomic; + ')' }

        if (typeof(cliente.results_row.localicod)==='string'){ domicilio = domicilio + '. ' + cliente.results_row.localicod }

        if (typeof(cliente.results_row.localinomb)==='string'){ domicilio = domicilio + ' - ' + cliente.results_row.localinomb }

        if (typeof(cliente.results_row.provinnomb)==='string'){ domicilio = domicilio + ', ' + cliente.results_row.provinnomb }

				document.getElementById("codCliente").value    = cliente.results_row.clientvtascod;
        document.getElementById("codCliente").disabled = "disabled";
        
        if (!(abrirBuscador==null)){ abrirBuscador.disabled = "disabled" }

        if (!(razonSocial==null)){ razonSocial.innerHTML = cliente.results_row.clientvtasnomb }

        if (!(domicilioCliente==null)){ domicilioCliente.innerHTML = domicilio }

        if (!(razonSocial==null)){ razonSocial.innerHTML = cliente.results_row.clientvtasnomb }

        if (!(clientVtasNomb==null)){ documentclientVtasNomb.value = cliente.results_row.clientvtasnomb }

        if (!(headerDeImpresion==null)){ headerDeImpresion.innerHTML = "Cliente: " + cliente.results_row.clientvtascod + " - " + cliente.results_row.clientvtasnomb }

        var telefono = '';

        if (typeof(cliente.results_row.clientvtastelef1)==='string'){ telefono = cliente.results_row.clientvtastelef1 }
        if (typeof(cliente.results_row.clientvtastelef2)==='string'){ telefono = telefono + ', ' + cliente.results_row.clientvtastelef2 }
        if (typeof(cliente.results_row.clientvtastelef3)==='string'){ telefono = telefono + ', ' + cliente.results_row.clientvtastelef3 }

        if (!(clientVtasTelef==null)){ clientVtasTelef.innerHTML = telefono }

        /*
        
        DEFINIR TEMA DESCUENTOS DEL CLIENTE

        if (!(descuento==null)){ descuento.value = cliente.results_row.clientvtasdtogen }


        if (!(descuentoGeneral==null)){ descuentoGeneral.innerHTML = cliente.results_row.clientvtasdtogen }

        */

        if (!(ddlb_vendedores==null)){ ddlb_vendedores.value = cliente.results_row.vendvtascod }

        if (!(articCodAdmin==null)){
          articCodAdmin.disabled = ""
          articCodAdmin.focus()
        }

        if (!(cantidad==null)){ cantidad.disabled = "" }

        if (!(descuento==null)){ descuento.disabled = "" }

        if (!(buscaArtic==null)){ buscaArtic.disabled = "" }

        if (!(agregar==null)){ agregar.disabled = "" }

        if (!(agregarMobile==null)){ agregarMobile.disabled = "" }

        ocultarIcono()

      }
    );
	}

  function pegarCliente(codCliente,nombreCli,domicilioCli,descuentoCli,codVendedor){

    /*

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                                                                                          //
    //     ESTA FUNCIÓN SE EJECUTA CUANDO SE PEGA EL CLIENTE DESDE UN BUSCADOR DE CLIENTES (VENTANA MODAL)      //
    //                                                                                                          //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

    */

    nombreCli    = decodeURI(nombreCli);
    domicilioCli = decodeURI(domicilioCli);

    $("#buscarClientes").modal("hide");

    $("#cuentaCorriente tbody tr").remove();

    // recuperar secciones para luego detectar si existen en la pagina //

    var abrirBuscador    = document.getElementById("abrirBuscador")
    var razonSocial      = document.getElementById("razonSocial")
    var domicilioCliente = document.getElementById("domicilioCliente")
    var clientVtasNomb   = document.getElementById("clientVtasNomb")
    var descuento        = document.getElementById("descuento")
    var descuentoGeneral = document.getElementById("descuentoGeneral")
    var ddlb_vendedores  = document.getElementById("listaVendedores")

    // secciones de la utilidad de nota de pedido //

    var articCodAdmin   = document.getElementById("articCodAdmin")
    var cantidad        = document.getElementById("cantidad")
    var buscaArtic      = document.getElementById("buscaArtic")
    var agregar         = document.getElementById("agregar")
    var agregarMobile   = document.getElementById("agregarMobile")

    document.getElementById("codCliente").value = codCliente;
    document.getElementById("codCliente").disabled = "disabled";

    if (!(abrirBuscador==null)){ abrirBuscador.disabled = "disabled" }

    if (!(razonSocial==null)){ razonSocial.innerHTML = nombreCli }

    if (!(domicilioCliente==null)){ domicilioCliente.innerHTML = domicilioCli }

    if (!(clientVtasNomb==null)){ clientVtasNomb.value = nombreCli }

    /*
    DEFINIR TEMA DESCUENTOS DEL CLIENTE

    if (!(descuento==null)){ descuento.value = descuentoCli }

    if (!(descuentoGeneral==null)){ descuentoGeneral.innerHTML = descuentoCli }
    */

    if (!(ddlb_vendedores==null)){ ddlb_vendedores.value = codVendedor }

    if (!(articCodAdmin==null)){
      articCodAdmin.disabled = ""
      articCodAdmin.focus()
    }

    if (!(cantidad==null)){ cantidad.disabled = "" }

    if (!(descuento==null)){ descuento.disabled = "" }

    if (!(buscaArtic==null)){ buscaArtic.disabled = "" }

    if (!(agregar==null)){ agregar.disabled = "" }

    if (!(agregarMobile==null)){ agregarMobile.disabled = "" }

    ocultarIcono()

  }