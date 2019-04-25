function recuperarVendedores(codVendedor){
  
  if (!codVendedor){
    codVendedor = 0
  }
  $.post("../../ventas/nv_ventas/buscarVendedores.php", 
    { cod_vendedor: codVendedor}, 
    function(data) {
      vendedores = JSON.parse(data);
      if ( vendedores.results_row.as_error_msg_js ){
        alert ("Error en la conexión con el servidor del cliente: " + vendedores.results_row.as_error_msg_js );      
        return;
      }
      if ( vendedores.results_row.as_return_msg_js ){
        alert ("Alerta!: " + vendedores.results_row.as_return_msg_js );   
        return;
      }

      if (vendedores.results_row.length>0){
        //////////////////// ES ARRAY //////////////////////////
        var listaVendedores = vendedores.results_row
      }else{
        ///////////////// TRANSFORMAR EN ARRAY /////////////////
        var listaVendedores = [];
        var object = new Object();
        listaVendedores[0] = object;
        $.each(vendedores.results_row, function(key, value) {
          listaVendedores[0][key] = value
        });
      }

      var ddlbVendedores = document.getElementById("listaVendedores");

      for (var i = 0; i < listaVendedores.length; i++) {
        var option = document.createElement("option");
        option.text = listaVendedores[i].vendvtasapell + " " + listaVendedores[i].vendvtasnomb
        option.value   = listaVendedores[i].vendvtascod
        ddlbVendedores.add(option);
      }
    }
  )
}

function onChangeCliente(){
  $("#detallePedido tbody tr").remove();
  var codCliente  = document.getElementById("codCliente").value;
  document.getElementById("razonSocial").innerHTML    = '<i id="cargandoDatosCli" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: "></i>'
  seleccionarCliente(codCliente);
}

function totalizar(){

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                                                                          //
  //  ESTA FUNCION SE EJECUTA PARA CALCULAR EL TOTAL DEL COMPROBANTE PARA LOS CAMPOS "Descuento General" y "Total Comprobante"                //
  //                                                                                                                                          //
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  var totalGeneral     = 0.00;
  totalGeneral         = parseFloat(totalGeneral);
  totalGeneral         = totalGeneral.toFixed(2);

  var montoFinal       = 0.00;
  montoFinal           = parseFloat(montoFinal);
  montoFinal           = montoFinal.toFixed(2);

  var descuentoGeneral = document.getElementById("descuentoGeneral").innerHTML;
  descuentoGeneral     = parseFloat(descuentoGeneral);
  descuentoGeneral     = descuentoGeneral.toFixed(2);
  var t_detallePedido  = document.getElementById("detallePedido");
  for (var i = 1, row; row = t_detallePedido.rows[i]; i++) {

    for (var j = 0, col; col = row.cells[j]; j++) {
      switch (col.id){
        case 't_total':
          var totalRenglon = parseFloat(col.innerHTML);
          totalRenglon     = totalRenglon.toFixed(2);
          break;
        case 't_totalConIva':
          var finalRenglon = parseFloat(col.innerHTML);
          finalRenglon     = finalRenglon.toFixed(2);
      }
    }

    totalGeneral = parseFloat(totalGeneral) + parseFloat(totalRenglon);
    totalGeneral = parseFloat(totalGeneral);
    totalGeneral = totalGeneral.toFixed(2);
    totalGeneral = totalGeneral - ( totalGeneral * descuentoGeneral / 100 )
    totalGeneral = totalGeneral.toFixed(2);

    montoFinal   = parseFloat(montoFinal) + parseFloat(finalRenglon);
    montoFinal   = parseFloat(montoFinal);
    montoFinal   = montoFinal.toFixed(2);
    montoFinal   = montoFinal - ( montoFinal * descuentoGeneral / 100 )
    montoFinal   = montoFinal.toFixed(2);

  }

  document.getElementById("subtotal").innerHTML   = totalGeneral;
  document.getElementById("subtotal").value       = totalGeneral;

  document.getElementById("montoFinal").innerHTML = montoFinal;
  document.getElementById("montoFinal").value     = montoFinal;
}

function calcularTotal(){

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                                                                          //
  //  ESTA FUNCION SE EJECUTA PARA CALCULAR EL TOTAL DEL ARTÍCULO QUE ESTAMOS AGREGANDO EN EL RENGLÓN                                         //
  //                                                                                                                                          //
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  var articPrecVta  = document.getElementById("articPrecVta").innerHTML;
  var cantidad      = document.getElementById("cantidad").value;
  var descuento     = document.getElementById("descuento").value;

  if (!cantidad || cantidad == 0){
    return;
  }

  if (!articPrecVta || articPrecVta == 0){
    return;
  }

  if (!descuento){
    descuento = 0
  }

  if ( descuento > 100 || descuento < 0 ) {
    alert("El monto de descuento es inválido.")
    return;
  }

  cantidad  = parseFloat(cantidad);
  cantidad  = cantidad.toFixed(2);

  descuento = parseFloat(descuento);
  descuento = descuento.toFixed(2);
  
  var factorDescuento = ( 100 - descuento ) / 100;
  
  var subTotal = articPrecVta * cantidad * factorDescuento;
  subTotal     = parseFloat(subTotal);
  subTotal     = subTotal.toFixed(2);

  document.getElementById("cantidad").value = cantidad ;
  document.getElementById("descuento").value = descuento ;
  document.getElementById("artiMontoTotal").innerHTML = subTotal ;
}

function calcularTotalConcepto(){
  var articPrecVta = document.getElementById("precioUnitConcepto").value;
  var cantidad     = document.getElementById("cantidadConcepto").value;

  if (!cantidad || cantidad == 0){
    cantidad = 0;
  }

  if (!articPrecVta || articPrecVta == 0){
    articPrecVta = 0;
  }

  cantidad  = parseFloat(cantidad);
  cantidad  = cantidad.toFixed(2);

  articPrecVta = parseFloat(articPrecVta);
  articPrecVta = articPrecVta.toFixed(2);
  
  var total = articPrecVta * cantidad
  total     = parseFloat(total);
  total     = total.toFixed(2);

  document.getElementById("precioUnitConcepto").value = articPrecVta ;
  document.getElementById("cantidadConcepto").value   = cantidad ;
  document.getElementById("totalConcepto").value      = total ;
}

function onChangeArticulos(){
  document.getElementById("articDesc").innerHTML    = '<i id="cargandoDatosArtic" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: "></i>'
  document.getElementById("articPrecVta").innerHTML = ''
  mostrarIconoBuscandoArtic()
  codAdmin       = document.getElementById("articCodAdmin").value;
  descArtic      = '';
  codCliente     = document.getElementById("codCliente").value;
  document.getElementById("cantidad").focus()
  $.post("../../comercial/nv_comercial/buscarArticulos.php", 
    { cod_articulo: codAdmin, 
      desc_articulo: descArtic,
      cod_cliente: codCliente }, 
    function(data) { 
      articulos = JSON.parse(data);
      if ( articulos.results_row.as_error_msg ){
        var mensaje = articulos.results_row.as_error_msg;
        alert ("Error en la conexión con el servidor del cliente: " + articulos.results_row.as_error_msg_js );      
        ocultarIconoBuscandoArtic()
        document.getElementById("articDesc").innerHTML    = ''
        document.getElementById("articPrecVta").innerHTML = ''
        document.getElementById("alicIvaCod").innerHTML = ''
        return;
      }
      if ( articulos.results_row.as_return_msg_js ){
        alert ("Alerta!: " + articulos.results_row.as_return_msg_js);   
        ocultarIconoBuscandoArtic()
        document.getElementById("articDesc").innerHTML    = ''
        document.getElementById("articPrecVta").innerHTML = ''
        document.getElementById("alicIvaCod").innerHTML = ''
        return;
      }

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
      ocultarIconoBuscandoArtic()

      document.getElementById("articDesc").innerHTML    = articuloConsultado[0].articdesc;
      document.getElementById("articPrecVta").innerHTML = articuloConsultado[0].articprecvta;
      document.getElementById("alicIvaCod").innerHTML   = articuloConsultado[0].alicivacod;
      calcularTotal();

    }
  );
}

function limpiarArticulo(){
  document.getElementById("articCodAdmin").value      = '';
  document.getElementById("articDesc").innerHTML      = '<i id="cargandoDatosArtic" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: hidden "></i>';
  document.getElementById("articPrecVta").innerHTML   = '0.00';
  document.getElementById("cantidad").value           = '';
  document.getElementById("artiMontoTotal").innerHTML = '';

  document.getElementById("descripcionConcepto").value = '';
  document.getElementById("precioUnitConcepto").value  = '';
  document.getElementById("cantidadConcepto").value    = '';
  document.getElementById("totalConcepto").value       = '';

  document.getElementById("articCodAdmin").focus();
}

function agregarItem(rol){

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                                                                          //
  //  ESTA FUNCION SE EJECUTA CUANDO SE HACE CLIC EN EL BOTÓN "+ AGREGAR"                                                                     //
  //  Decide si va a llamar a abrir el modal AgregarConcepto para permitir ingresar un nuevo concepto o, si existen datos de artículo,        //
  //  agregará el artículo en el renglón llamando a la función "agregarArticulo(params...).                                                   //
  //  Los clientes no pueden agregar conceptos.                                                                                               //
  //                                                                                                                                          //
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  calcularTotal();
  
  articCodAdmin   = document.getElementById("articCodAdmin").value
  articDesc       = document.getElementById("articDesc").innerHTML
  alicuotaIVA     = document.getElementById("alicuotaConcepto").value

  if ((!articCodAdmin || !articDesc) && (rol !== 2)) {
    $("#agregarConcepto").modal("show");
    return;
  }else{
    articPrecVta    = document.getElementById("articPrecVta").innerHTML
    cantidad        = document.getElementById("cantidad").value
    descuento       = document.getElementById("descuento").value
    articMontoTotal = document.getElementById("artiMontoTotal").innerHTML
    alicuotaIVA     = document.getElementById("alicIvaCod").innerHTML
  }

  if (!articCodAdmin || !articDesc || !alicuotaIVA || !articPrecVta || !cantidad || !articMontoTotal){
    return;
  }

  agregarArticulo(articCodAdmin,articDesc,alicuotaIVA,articPrecVta,cantidad,descuento,articMontoTotal);
}

function agregarArticulo(articCodAdmin,articDesc,alicuotaIVA,articPrecVta,cantidad,descuento,articMontoTotal){

  switch(alicuotaIVA){
    case "1":
      var porcentajeAlicuotaIva = 21.00;
      break;
    case "3":
      var porcentajeAlicuotaIva = 0.00;
      break;
    case "4":
      var porcentajeAlicuotaIva = 10.50;
      break;
    case "5":
      var porcentajeAlicuotaIva = 27.00;
      break;
    case "6":
      var porcentajeAlicuotaIva = 2.50;
      break;
  }

  porcentajeAlicuotaIva = parseFloat(porcentajeAlicuotaIva);
  porcentajeAlicuotaIva = porcentajeAlicuotaIva.toFixed(2);

  var totalConIva = articMontoTotal * ( 1 +  porcentajeAlicuotaIva / 100 );
  totalConIva     = parseFloat(totalConIva);
  totalConIva     = totalConIva.toFixed(2);

  var filaDetalle = '<tr class="resaltador protected" style="cursor: default">'                                     + 
                      '<td id = "t_codAdmin" class="text-center descarto protected">'                 +
                      articCodAdmin                                                                                 +
                      '</td>'                                                                                       + 
                      '<td id = "t_descripcion" class="text-center descarto protected" colspan="3" >'  +
                      articDesc                                                                                     +
                      '</td>'                                                                                       +
                      '<td id = "t_precioUnitario" class="text-center descarto protected" >'           +
                      articPrecVta                                                                                  +
                      '</td>'                                                                                       +
                      '<td id = "t_cantidad" class="text-center descarto protected" >'                 +
                      cantidad                                                                                      +
                      '</td>'                                                                                       +
                      '<td id = "t_descuento" class="text-center descarto protected" >'                +
                      descuento                                                                                     +
                      '</td>'                                                                                       +
                      '<td id = "t_total" class="text-center descarto protected" >'                    +
                      articMontoTotal                                                                               +
                      '</td>'                                                                                       +
                      '<td id = "t_porcentajeAlicuotaIva" class="text-center descarto protected" >'    +
                      porcentajeAlicuotaIva                                                                         +
                      '</td>'                                                                                       +
                      '<td id = "t_totalConIva" class="text-center descarto protected" >'              +
                      totalConIva                                                                                   +
                      '</td>'                                                                                       +
                      '<td class="text-center descarto" >'                                              +
                      '<a class="btn btn-default btn-xs" onClick="borrarItem(this)" aria-label="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>' +
                      '</td>'                                                                                       +
                      '<td id = "t_iva" class="text-center descarto protected" style="display:none">' +
                      alicuotaIVA                                                                                   +
                      '</td>'                                                                                       +
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                      '<td class="text-center soloMobile protected" style="font-size: 10px; padding-right:2px; padding-left:1px">'                       +
                      articCodAdmin                                                                                 +
                      '</td>'                                                                                       + 
                      '<td class="text-center soloMobile protected" colspan="3" style="font-size: 10px; padding-right:2px; padding-left:1px">'           +
                      articDesc                                                                                     +
                      '</td>'                                                                                       +
                      '<td class="text-center soloMobile protected" style="font-size: 10px; padding-right:2px; padding-left:1px">'                        +
                      cantidad                                                                                      +
                      '</td>'                                                                                       +
                      '<td class="text-center soloMobile protected" style="font-size: 10px; padding-right:2px; padding-left:1px">'                        +
                      articMontoTotal                                                                               +
                      '</td>'                                                                                       +
                      '<td class="text-center soloMobile protected" style="font-size: 10px; padding-right:2px; padding-left:1px">'                        +
                      porcentajeAlicuotaIva                                                                         +
                      '</td>'                                                                                       +
                      '<td class="text-center soloMobile protected" style="font-size: 10px; padding-right:2px; padding-left:1px">'                        +
                      totalConIva                                                                                   +
                      '</td>'                                                                                       +
                      '<td class="text-center soloMobile">'                                                         +
                      '<a class="btn btn-default btn-xs" onClick="borrarItem(this)" aria-label="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>' +
                      '</td>'                                                                                       +
                    '</tr>';
  $('#detallePedido tbody').append(filaDetalle);
  limpiarArticulo();
  totalizar();
}

function agregarConcepto(){

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                                                                          //
  //  ESTA FUNCION SE EJECUTA CUANDO SE HACE CLIC EN AGREGAR DESDE LA VENATANA MODAL agregarConcepto                                          //
  //                                                                                                                                          //
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  document.getElementById("articCodAdmin").value      = "CONCEPTO";
  document.getElementById("articDesc").innerHTML      = document.getElementById("descripcionConcepto").value;
  document.getElementById("articPrecVta").innerHTML   = document.getElementById("precioUnitConcepto").value;
  document.getElementById("cantidad").value           = document.getElementById("cantidadConcepto").value;
  document.getElementById("descuento").value          = 0;
  document.getElementById("artiMontoTotal").innerHTML = document.getElementById("totalConcepto").value;
  agregarItem();
  $("#agregarConcepto").modal("hide");
}

function borrarItem(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("detallePedido").deleteRow(i);
    totalizar();
}

function generarPedido(){

  if ( !(document.getElementById("codCliente").value) ){
    alert('No se han completado los datos del cliente');
    return;
  }

  if ( document.getElementById("detallePedido").rows.length <= 1 ) {
    alert('Debe ingresar el detalle del pedido!');
    return;
  }

  if (confirm('Desea generar el pedido ingresado?')) {

    $('#generandoPedido').modal('show');
    document.body.style.cursor  = 'wait'
    
    var codCliente    = document.getElementById("codCliente").value;
    var codVendedor   = document.getElementById("listaVendedores").value;
    var leyenda       = 'GENERADO DESDE SITIO WEB AWA BR';
    var detallePedido = '';

    var t_detallePedido = document.getElementById("detallePedido");
    for (var i = 1, row; row = t_detallePedido.rows[i]; i++) {

      for (var j = 0, col; col = row.cells[j]; j++) {
        switch (col.id){
          case 't_codAdmin':
            var codAdmin = col.innerHTML;
            break;
          case 't_descripcion':
            var descripcion = col.innerHTML;
            // A LA DESCRIPCION SE LE DEBEN QUITAR TODOS LOS CARACTERES ESPECIALES DE SEPARACIÓN , # *
            descripcion = descripcion.replace(/,/g   , '.');
            descripcion = descripcion.replace(/#/g   , ' ');
            descripcion = descripcion.split('*').join('');
            break;
          case 't_precioUnitario':
            var precioUnitario = col.innerHTML;
            precioUnitario     = parseInt ( precioUnitario * 100 );
            break;
          case 't_cantidad':
            var cantidad = col.innerHTML;
            cantidad     = parseInt ( cantidad * 100 );
            break;
          case 't_descuento':
            var descuento = col.innerHTML;
            descuento     = parseInt ( descuento * 100 );
            break;
          case 't_iva':
            if (codAdmin == 'CONCEPTO'){
              var ivaConcepto = col.innerHTML;
            }else{
              var ivaConcepto = '0';
            }
            break;
        }
      }

      detallePedido = detallePedido + codAdmin + '*' + descripcion + '*' + ivaConcepto + '*' + precioUnitario + '*' + cantidad + '*' + descuento + '#';

    }

    var comando = codCliente + "," + codVendedor + "," + leyenda + "," + detallePedido;

    $.post("../../ventas/nv_ventas/generarPedido.php", 
      { cod_cliente: codCliente, 
        cod_vendedor: codVendedor,
        leyenda: leyenda,
        detalle_pedido: detallePedido }, 
      function(data) { 
        pedido = JSON.parse(data);
        if ( pedido.results_row.as_error_msg ){
          alert ("Error en la conexión con el servidor del cliente: " + pedido.results_row.as_error_msg_js );      
          $('#generandoPedido').modal('hide');
          document.body.style.cursor  = 'default'
          return;
        }
        if ( pedido.results_row.as_return_msg_js ){
          alert ("Alerta!: " + pedido.results_row.as_return_msg_js );   
          $('#generandoPedido').modal('hide');
          document.body.style.cursor  = 'default'
          return;
        }

        if (pedido.results_row.length>0){
          //////////////////// ES ARRAY //////////////////////////
          var resultadoPedido = pedido.results_row
        }else{
          ///////////////// TRANSFORMAR EN ARRAY /////////////////
          var resultadoPedido = [];
          var object = new Object();
          resultadoPedido[0] = object;
          $.each(pedido.results_row, function(key, value) {
            resultadoPedido[0][key] = value
          });

        }

        // reiniciar algunos valores para prevenir repetición del pedido...

        document.getElementById("codCliente").value = "";
        document.getElementById("detallePedido").innerHTML = "";

        // mostrar cartel con número de pedido generado ...

        var mensaje = 'Se ha generado el pedido Nro ' + resultadoPedido[0].as_numero_cbte;

        document.body.style.cursor  = 'default';

        document.getElementById("tituloMensajePedido").innerHTML = "Pedido Generado Exitosamente";
        document.getElementById("mensajePedido").innerHTML = mensaje;
        document.getElementById("procesandoPedido").style.display = "none";
        document.getElementById("botonMensajePedido").style.display = "";



        //location.reload();

      }
    );

  }else{
    return;
  }

}

function recuperarVendedorCliente(codCliente){

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                                                                          //
  //  ESTA FUNCION SE EJECUTA CUANDO EL ROL ES CLIENTE: al abrirse la página se trae todos los datos del cliente. De aquí saca el codigo del  //
  //  vendedor asignado y el descuento que el cliente tiene asignado ...                                                                      //
  //                                                                                                                                          //
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


  $.post("../../ventas/nv_ventas/selClienteBuscador.php", 
    { cod_cliente: codCliente }, 
    function(data) {
      cliente = JSON.parse(data);

      if ( cliente.results_row.as_error_msg_js ){
        alert ("Error en la conexión con el servidor del cliente: " + cliente.results_row.as_error_msg_js );          
        return;
      };
      if ( cliente.results_row.as_return_msg_js ){
        alert ("Alerta!: " + cliente.results_row.as_return_msg_js );
        return;
      };

      var ddlbVendedores = document.getElementById("listaVendedores");
    
      var option   = document.createElement("option");
      option.text  = cliente.results_row.vendvtasapell + " " + cliente.results_row.vendvtasnomb
      option.value = cliente.results_row.vendvtascod
      ddlbVendedores.add(option);

      // Aprovecharemos este metodo para setear el descuento del cliente ...

      /*
      
      DEFINIR TEMA DESCUENTOS DEL CLIENTE

      if (!(descuento==null)){ descuento.value = cliente.results_row.clientvtasdtogen }


      if (!(descuentoGeneral==null)){ descuentoGeneral.innerHTML = cliente.results_row.clientvtasdtogen }

      */

    }
  );
}

function recuperarVendedorActual(codVendedor){
  recuperarVendedores(codVendedor);
}