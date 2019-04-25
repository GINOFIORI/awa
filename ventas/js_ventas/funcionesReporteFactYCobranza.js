function mostrarIconoRep() {
  document.body.style.cursor='wait';
  document.getElementById("cargandoReporte").style.visibility = 'visible';
}
function ocultarIconoRep() {
  document.body.style.cursor='default';
  document.getElementById("cargandoReporte").style.visibility = 'hidden';
}


function habilitarVendedores(value) 
  {
      valorTodosVendedor    = value;
      if (valorTodosVendedor == true ) {
          document.getElementById("listaVendedores").disabled=true;
      }else{
          document.getElementById("listaVendedores").disabled=false;
      }

  }


function checkbox_vendedores(value)
{

  if(value==true)
  {
    // habilitamos
    document.getElementById("todosVendedores").disabled=false;
    document.getElementById("listaVendedores").disabled=true;
   
  }else if(value==false){
    //deshabilitamos
    document.getElementById("listaVendedores").disabled=true;
    document.getElementById("todosVendedores").disabled=true;
  }
}

function buscadorCliente(value)
{
  if(value==true){
    document.getElementById("codCliente").disabled=false;
    document.getElementById("buscarCli").disabled = false;
  }else{
    document.getElementById("codCliente").disabled=true;
    document.getElementById("buscarCli").disabled = true;
  }

}

function recuperarVendedores(codVendedor){

  if (!codVendedor){
    codVendedor = 0
  }
  $.post("../../ventas/nv_ventas/buscarVendedores.php", 
      { cod_vendedor: codVendedor}, 
      function(data) {
        vendedores = JSON.parse(data);
        if ( vendedores.results_row.as_error_msg ){
          alert ("Error en la conexión con el servidor del cliente: " + vendedores.results_row.as_error_msg_js );      
          return;
        }
        if ( vendedores.results_row.as_return_msg ){
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

      })

}

function onChangeCliente(){
  $("#reporteFactYCobranza tbody tr").remove();
  var codCliente = document.getElementById("codCliente").value;
  document.getElementById("razonSocial").innerHTML    = '<i id="cargandoDatosCli" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: "></i>'
  seleccionarCliente(codCliente);
}

function recuperarListado(rol){
  mostrarIconoRep();
  
  var fechaDesde  = document.getElementById("fechaDesde").value;
  var fechaHasta  = document.getElementById("fechaHasta").value;
  var tipoListado = document.getElementById("tipoCorte").value;

  if ( document.getElementById("seleccionarCliente").checked){var codCliente = document.getElementById("codCliente").value;} else{var codCliente = 0;}

  var codRol = rol; 

  if (codRol == 3) {
    var codVendedor    = document.getElementById("listaVendedores").value;
    var separaVendedor = 1;
  }else{
    if ( document.getElementById("todosVendedores").checked){var codVendedor = 0;} else{var codVendedor = document.getElementById("listaVendedores").value;}
    if ( document.getElementById("separarVendedores").checked ){var separaVendedor = 1;}else{var separaVendedor = 0;}
  }

  if ( !(fechaDesde) || (fechaDesde=="") ){
    document.getElementById("fechaDesde").style.border="solid 1px red";
    ocultarIconoRep();
    alert("La fecha desde no es válida!");
    return;
  }else{
    document.getElementById("fechaDesde").style.border="";
  }

  if ( !(fechaHasta) || (fechaHasta=="") ){
    document.getElementById("fechaHasta").style.border="solid 1px red";
    ocultarIconoRep();
    alert("La fecha hasta no es válida!");
    return;
  }else{
    document.getElementById("fechaHasta").style.border="";
  }

  if ( ( document.getElementById("seleccionarCliente").checked &&  codCliente == null ) ) {
      alert("El cliente no es válido!");
      ocultarIconoRep();
      return;
  }

  $.post("../../ventas/nv_ventas/listarFacturacionYCobranza.php", 
    { fecha_desde: fechaDesde,
      fecha_hasta: fechaHasta, 
      tipo_listado: tipoListado,
      cod_cliente: codCliente,
      separar_vendedores: separaVendedor,
      codigo_vendedor: codVendedor },
    function(data) {

      listado = JSON.parse(data);        

      if ( listado.results_row.as_error_msg_js ){
        $("#listado tbody tr").remove();
        ocultarIconoRep();
        alert ("Error en la conexión con el servidor del cliente: " + listado.results_row.as_error_msg_js );
        return;
      }

      if ( listado.results_row.as_return_msg_js ){
        $("#listado tbody tr").remove();
        ocultarIconoRep();
        alert ("Alerta!: " + listado.results_row.as_return_msg_js );
        return;
      }

      if (listado.results_row.length>0){
        ///////////////////////////// ES ARRAY //////////////////////////////////
        var listadoFactCobr = listado.results_row
      }else{
        //////////////////////// TRANSFORMAR EN ARRAY ///////////////////////////
        var listadoFactCobr = [];
        var renglon = new Object();
        listadoFactCobr[0] = renglon;
        $.each(listado.results_row, function(key, value) {
          listadoFactCobr[0][key] = value
        });
      }

      ocultarIconoRep();

      $('#listado tbody tr').remove();
      $('#listado thead tr').remove();

      if ( tipoListado == 1 ) {

        listarFacturacion(listadoFactCobr,separaVendedor);

      } else {

        listarCobranza(listadoFactCobr,separaVendedor);

      }

    }
  );
};


function listarFacturacion ( listadoFacturacion , separaVendedor ) {

  var encabezado = '<tr style="height: 33.33px;">'                                                                                                                      +

                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px"> <strong> Fecha </strong> </th>'                                    +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px" colspan="3" style="min-width:100px">'                               +
                        '<strong> Comprobante </strong>'                                                                                                                +
                      '</th>'                                                                                                                                           +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px" colspan="2"> <strong> Cliente     </strong> </th>'                  +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px"> <strong> Mto. Imp./Exe. </strong> </th>'                           +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px"> <strong> IVA </strong> </th>'                                      +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px"> <strong> No Grav.</strong> </th>'                                  +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px"> <strong> Percep. </strong> </th>'                                  +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px"> <strong> Total </strong> </th>'                                    +
                      '<th name="columnaBotonConsultar" class="descarto"></th>'                                                                                         +

                      '<th class="text-center soloMobile" style="font-size:12px"> <strong> Fecha </strong> </th>'                                                       +
                      '<th class="text-center soloMobile" style="font-size:12px; padding-left:3px; padding-right:3px" colspan="3">'                                     +
                        '<strong> Comprobante </strong>'                                                                                                                +
                      '</th>'                                                                                                                                           +
                      '<th class="text-center soloMobile" style="font-size:12px;" > <strong> Mto. Imp./Exe. </strong> </th>'                                            +
                      '<th class="text-center soloMobile" style="font-size:12px;" > <strong> IVA </strong> </th>'                                                       +
                      '<th class="text-center soloMobile" style="padding-right:3px"> <strong> Total </strong> </th>'                                    +

                   '</tr>';

  $('#listado thead').append(encabezado);

  var an_cod_vendedor = '';
  var an_cod_vendedor_ant = '';

  for ( var recorre in listadoFacturacion ) {

    var consultaCbte = "<button type='button' "                                       +
                                  "class='btn btn-primary btn-xs' "                   +
                                  "style='width:24; height:24'"                       +
                                  "onClick=consultarCbtes("                           +
                                  listadoFacturacion[recorre].an_tipo_cbte    + ",'"     +  
                                  listadoFacturacion[recorre].as_clase_cbte   + "','"    + 
                                  listadoFacturacion[recorre].as_numero_cbte  + "')>"    +
                                  "<span class='glyphicon glyphicon-search' aria-hidden='false'></span>" +
                          "</button>";

    var consultaCbteMobile = "onClick=consultarCbtes("                           +
                                  listadoFacturacion[recorre].an_tipo_cbte    + ",'"     +  
                                  listadoFacturacion[recorre].as_clase_cbte   + "','"    + 
                                  listadoFacturacion[recorre].as_numero_cbte  + "')"

    switch(listadoFacturacion[recorre].an_tipo_cbte){
      case '1':
        var nombreCbte = 'FC Vtas.';
        var nombreCbteMobile = 'FC ' + listadoFacturacion[recorre].as_clase_cbte + ' ' + listadoFacturacion[recorre].as_numero_cbte;
        break;
      case '2':
        var nombreCbte = 'NC Vtas.';
        var nombreCbteMobile = 'NC ' + listadoFacturacion[recorre].as_clase_cbte + ' ' + listadoFacturacion[recorre].as_numero_cbte;
        break;
      case '3':
        var nombreCbte = 'ND Vtas.';
        var nombreCbteMobile = 'ND ' + listadoFacturacion[recorre].as_clase_cbte + ' ' + listadoFacturacion[recorre].as_numero_cbte;
        break;
    }

    var fechaCbte  = formatearFecha(listadoFacturacion[recorre].adt_fecha_cbte);

    var adec_mto_impon_exe = formatearNumero(listadoFacturacion[recorre].adec_mto_impon_exe);
    var adec_mto_iva       = formatearNumero(listadoFacturacion[recorre].adec_mto_iva);
    var adec_mto_ng        = formatearNumero(listadoFacturacion[recorre].adec_mto_ng);
    var adec_mto_percep    = formatearNumero(listadoFacturacion[recorre].adec_mto_percep);
    var adec_mto_total     = formatearNumero(listadoFacturacion[recorre].adec_mto_total);

    var an_cod_vendedor    = listadoFacturacion[recorre].an_cod_vendedor

    if ( separaVendedor == 1 && an_cod_vendedor != an_cod_vendedor_ant ) {

      var fila_corte =  '<tr class="resaltador">'                                                                                                                                       +
                           '<td style="padding-left: 12px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="6" class="text-center fontsize descarto">'                    +
                              '<strong>'                                                                                                                                                +
                                'Vendedor: ' + an_cod_vendedor + ' - ' + listadoFacturacion[recorre].as_apell_nomb_vend                                                                    +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                                           +
                              '<strong>'                                                                                                                                                +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_impon_exe_vend)                                                                                       +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                                           +
                              '<strong>'                                                                                                                                                +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_iva_vend)                                                                                         +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                                           +
                              '<strong>'                                                                                                                                                +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_ng_vend)                                                                                          +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                                           +
                              '<strong>'                                                                                                                                                +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_percep_vend)                                                                                      +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td style="padding-left: 3px; padding-right: 5px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                                           +
                              '<strong>'                                                                                                                                                +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_total_vend)                                                                                       +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td name="columnaBotonConsultar" class="descarto"></td>'                                                                                                    +

                           '<td style="font-size:12px; padding-left: 5px; padding-right: 3px; text-align: left; color:#1ab394;" colspan="4" class="soloMobile text-center fontsize">'   +
                              '<strong>'                                                                                                                                                +
                                'Vendedor: ' + an_cod_vendedor + ' - ' + listadoFacturacion[recorre].as_apell_nomb_vend                                                                    +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td style="font-size:12px; padding-left: 3px; padding-right: 3px; text-align: right; color:#1ab394;" class="soloMobile fontsize" >'                         +
                              '<strong>'                                                                                                                                                +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_impon_exe_vend)                                                                                       +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td style="font-size:12px; padding-left: 3px; padding-right: 3px; text-align: right; color:#1ab394;" class="soloMobile fontsize" >'                         +
                              '<strong>'                                                                                                                                                +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_iva_vend)                                                                                         +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                           '<td style="font-size:12px; padding-left: 3px; padding-right: 10px; text-align: right; color:#1ab394;" class="soloMobile fontsize" >'                        +
                              '<strong>'                                                                                                                                                +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_total_vend)                                                                                       +
                              '</strong>'                                                                                                                                               +
                           '</td>'                                                                                                                                                      +
                        '</tr>';

       $('#listado tbody').append(fila_corte);

       an_cod_vendedor_ant = an_cod_vendedor;

    }

    var fila       = '<tr style="height: 33.33px;">'                                                                                              +

                        '<td class="descarto" style="padding-left: 5px;">' + fechaCbte + ' </td>'                                                 +
                        '<td class="descarto" style="white-space: nowrap">' + nombreCbte        + '</td>'                                         +
                        '<td class="descarto">' + listadoFacturacion[recorre].as_clase_cbte   + '</td>'                                              +
                        '<td class="descarto">' + listadoFacturacion[recorre].as_numero_cbte  + '</td>'                                              +
                        '<td class="descarto">' + listadoFacturacion[recorre].an_cod_cliente  + '</td>'                                              +
                        '<td class="descarto">' + listadoFacturacion[recorre].as_desc_cliente + '</td>'                                              +
                        '<td class="descarto" style="padding-left: 2px; padding-right: 1px; text-align: right">' + adec_mto_impon_exe + '</td>'   +
                        '<td class="descarto" style="padding-left: 2px; padding-right: 1px; text-align: right">' + adec_mto_iva + '</td>'         +
                        '<td class="descarto" style="padding-left: 2px; padding-right: 1px; text-align: right">' + adec_mto_ng + '</td>'          + 
                        '<td class="descarto" style="padding-left: 2px; padding-right: 1px; text-align: right">' + adec_mto_percep + '</td>'      + 
                        '<td class="descarto" style="padding-left: 2px; padding-right: 5px; text-align: right">' + adec_mto_total + '</td>'       +
                        '<td class="descarto">' + consultaCbte + '</td>'                                                                          +

                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:11px; padding-right:1px; padding-left:3px">' + fechaCbte + ' </td>'                                           +
                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:11px; padding-right:1px; padding-left:1px; white-space: nowrap" colspan="3">' + nombreCbteMobile  + '</td>'   +
                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:11px; padding-right:1px; padding-left:1px; text-align: right">' + adec_mto_impon_exe + '</td>'                +
                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:11px; padding-right:1px; padding-left:1px; text-align: right">' + adec_mto_iva + '</td>'                      +
                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:11px; padding-right:10px; padding-left:1px; text-align: right">' + adec_mto_total + '</td>'                   +

                     '</tr>';

    $('#listado tbody').append(fila);

    if ( recorre == ( listadoFacturacion.length - 1 ) ) {

      var fila_total =  '<tr style="border-top:2px solid #1ab394">'                                                                                             +

                           '<td style="padding-left: 12px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="6" class="descarto text-center fontsize">'   +
                              '<strong>'                                                                                                                        +
                                'Total General: '                                                                                                               +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                           '<td style="padding-left: 3px; padding-right: 3px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                   +
                              '<strong>'                                                                                                                        +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_impon_exe_gral)                                                               +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                           '<td style="padding-left: 3px; padding-right: 3px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                   +
                              '<strong>'                                                                                                                        +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_iva_gral)                                                                 +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                           '<td style="padding-left: 3px; padding-right: 3px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                   +
                              '<strong>'                                                                                                                        +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_ng_gral)                                                                  +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                           '<td style="padding-left: 3px; padding-right: 3px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                   +
                              '<strong>'                                                                                                                        +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_percep_gral)                                                              +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                           '<td style="padding-left: 3px; padding-right: 5px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                   +
                              '<strong>'                                                                                                                        +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_total_gral)                                                               +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                           '<td name="columnaBotonConsultar" class="descarto"></td>'                                                                            +

                           '<td style="font-size:12px; padding-left: 5px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="4" class="soloMobile text-center fontsize">'   +
                              '<strong>'                                                                                                                        +
                                'Total General: '                                                                                                               +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                           '<td style="font-size:12px; padding-left: 1px; padding-right: 1px; text-align: right; color:#1ab394;" class="soloMobile fontsize" >' +
                              '<strong>'                                                                                                                        +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_impon_exe_gral)                                                               +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                           '<td style="font-size:12px; padding-left: 1px; padding-right: 1px; text-align: right; color:#1ab394;" class="soloMobile fontsize" >' +
                              '<strong>'                                                                                                                        +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_iva_gral)                                                                 +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              + 
                           '<td style="font-size:12px; padding-left: 1px; padding-right: 10px; text-align: right; color:#1ab394;" class="soloMobile " >'         +
                              '<strong>'                                                                                                                        +
                                formatearNumero(listadoFacturacion[recorre].adec_tot_mto_total_gral)                                                               +
                              '</strong>'                                                                                                                       +
                           '</td>'                                                                                                                              +
                        '</tr>';
      $('#listado tbody').append(fila_total);

    }

  }
}

function listarCobranza ( listadoCobranza , separaVendedor ) {

  var encabezado = '<tr style="height: 33.33px;">'                                                                                                                      +

                      '<th class="text-center " style="padding-left:3px; padding-right:3px"> <strong> Fecha </strong> </th>'                                            +
                      '<th class="text-center " style="padding-left:3px; padding-right:3px" colspan="2"> <strong> Cliente     </strong> </th>'                          +
                      '<th class="text-center " style="padding-left:3px; padding-right:3px" colspan="3" style="min-width:100px">'                                       +
                        '<strong> Comprobante </strong>'                                                                                                                +
                      '</th>'                                                                                                                                           +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px"> <strong> Monto Total Cobranza </strong> </th>'                             +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px" colspan="3" style="min-width:100px">'                               +
                        '<strong> Comprobante Cancelado </strong>'                                                                                                      +
                      '</th>'                                                                                                                                           +
                      '<th class="text-center descarto" style="padding-left:3px; padding-right:3px"> <strong> Monto Total</strong> </th>'                               +
                      '<th class="text-center" style="padding-left:3px; padding-right:3px"> <strong> Monto Cancelado</strong> </th>'                           +
                      '<th name="columnaBotonConsultar" class="descarto"></th>'                                                                                         +

                   '</tr>';

  $('#listado thead').append(encabezado);

  var an_cod_vendedor = '';
  var an_cod_vendedor_ant = '';

  for ( var recorre in listadoCobranza ) {

    var consultaCbte = "<button type='button' "                                       +
                                  "class='btn btn-primary btn-xs' "                   +
                                  "style='width:24; height:24'"                       +
                                  "onClick=consultarCbtes("                           +
                                  listadoCobranza[recorre].an_tipo_cbte_rbo    + ",'"     +  
                                  listadoCobranza[recorre].as_clase_cbte_rbo   + "','"    + 
                                  listadoCobranza[recorre].as_numero_cbte_rbo  + "')>"    +
                                  "<span class='glyphicon glyphicon-search' aria-hidden='false'></span>" +
                          "</button>";

    var consultaCbteMobile = "onClick=consultarCbtes("                           +
                                  listadoCobranza[recorre].an_tipo_cbte_rbo    + ",'"     +  
                                  listadoCobranza[recorre].as_clase_cbte_rbo   + "','"    + 
                                  listadoCobranza[recorre].as_numero_cbte_rbo  + "')"

    switch(listadoCobranza[recorre].an_tipo_cbte_rbo){
      case '1':
        var nombreCbte = 'FC Vtas.';
        var nombreCbteMobile = 'FC ' + listadoCobranza[recorre].as_clase_cbte_rbo + ' ' + listadoCobranza[recorre].as_numero_cbte_rbo;
        break;
      case '2':
        var nombreCbte = 'NC Vtas.';
        var nombreCbteMobile = 'NC ' + listadoCobranza[recorre].as_clase_cbte_rbo + ' ' + listadoCobranza[recorre].as_numero_cbte_rbo;
        break;
      case '3':
        var nombreCbte = 'ND Vtas.';
        var nombreCbteMobile = 'ND ' + listadoCobranza[recorre].as_clase_cbte_rbo + ' ' + listadoCobranza[recorre].as_numero_cbte_rbo;
        break;
      case '6':
        var nombreCbte = 'Recibo Cobro.';
        var nombreCbteMobile = 'RBO ' + listadoCobranza[recorre].as_clase_cbte_rbo + ' ' + listadoCobranza[recorre].as_numero_cbte_rbo;
        break;
    }

    switch(listadoCobranza[recorre].an_tipo_cbte_cancel){
      case '1':
        var nombreCbteCancel = 'FC Vtas.';
        var nombreCbteCancelMobile = 'FC ' +  listadoCobranza[recorre].as_clase_cbte_cancel + ' ' + listadoCobranza[recorre].as_numero_cbte_cancel;
        break;
      case '2':
        var nombreCbteCancel = 'NC Vtas.';
        var nombreCbteCancelMobile = 'NC ' +  listadoCobranza[recorre].as_clase_cbte_cancel + ' ' + listadoCobranza[recorre].as_numero_cbte_cancel;
        break;
      case '3':
        var nombreCbteCancel = 'ND Vtas.';
        var nombreCbteCancelMobile = 'ND ' +  listadoCobranza[recorre].as_clase_cbte_cancel + ' ' + listadoCobranza[recorre].as_numero_cbte_cancel;
        break;
      case '6':
        var nombreCbteCancel = 'Recibo Cobro.';
        var nombreCbteCancelMobile = 'RBO ' + listadoCobranza[recorre].as_clase_cbte_cancel + ' ' + listadoCobranza[recorre].as_numero_cbte_cancel;
        break;
    }

    var fecha_rbo  = formatearFecha(listadoCobranza[recorre].adt_fecha_rbo);

    var adec_mto_total_rbo            = formatearNumero(listadoCobranza[recorre].adec_mto_total_rbo);
    var adec_mto_total_cbte_cancel    = formatearNumero(listadoCobranza[recorre].adec_mto_total_cbte_cancel);
    var adec_mto_cbte_cancel          = formatearNumero(listadoCobranza[recorre].adec_mto_cbte_cancel);

    var adec_mto_total_rbo_vend       = formatearNumero(listadoCobranza[recorre].adec_mto_total_rbo_vend);
    var adec_mto_total_cbte_canc_vend = formatearNumero(listadoCobranza[recorre].adec_mto_total_cbte_canc_vend);
    var adec_mto_cbte_cancel_vend     = formatearNumero(listadoCobranza[recorre].adec_mto_cbte_cancel_vend);

    var adec_mto_total_rbo_gral       = formatearNumero(listadoCobranza[recorre].adec_mto_total_rbo_gral);
    var adec_mto_total_cbte_canc_gral = formatearNumero(listadoCobranza[recorre].adec_mto_total_cbte_canc_gral);
    var adec_mto_cbte_cancel_gral     = formatearNumero(listadoCobranza[recorre].adec_mto_cbte_cancel_gral);

    var an_cod_vendedor    = listadoCobranza[recorre].an_cod_vendedor

    if ( separaVendedor == 1 && an_cod_vendedor != an_cod_vendedor_ant ) {

      var fila_corte =  '<tr class="resaltador">'                                                                                                             +

                           '<td style="padding-left: 12px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="6" class="descarto text-center fontsize">'   +
                              '<strong>'                                                                                                                      +
                                'Vendedor: ' + an_cod_vendedor + ' - ' + listadoCobranza[recorre].as_apell_nomb_vend                                          +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                 +
                              '<strong>'                                                                                                                      +
                                adec_mto_total_rbo_vend                                                                                                       +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td class="descarto" colspan="3"></td>'                                                                                           +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                 +
                              '<strong>'                                                                                                                      +
                                adec_mto_total_cbte_canc_vend                                                                                                 +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                 +
                              '<strong>'                                                                                                                      +
                                adec_mto_cbte_cancel_vend                                                                                                     +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td class="descarto" name="columnaBotonConsultar"></td>'                                                                          +

                           '<td style="font-size:12px; padding-left: 10px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="6" class="soloMobile text-center fontsize">'   +
                              '<strong>'                                                                                                                      +
                                'Vendedor: ' + an_cod_vendedor + ' - ' + listadoCobranza[recorre].as_apell_nomb_vend                                          +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td style="font-size:12px; padding-left: 3px; padding-right: 10px; text-align: right; color:#1ab394;" class="soloMobile fontsize" >'               +
                              '<strong>'                                                                                                                      +
                                adec_mto_total_rbo_vend                                                                                                       +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +

                        '</tr>';

       $('#listado tbody').append(fila_corte);

       an_cod_vendedor_ant = an_cod_vendedor;

    }

    var fila       = '<tr style="height: 33.33px;">'                                                                                                          +

                        '<td class="descarto" style="padding-left: 5px;">' + fecha_rbo         + '</td>'                                                      +
                        '<td class="descarto">' + listadoCobranza[recorre].an_cod_cliente      + '</td>'                                                      +
                        '<td class="descarto">' + listadoCobranza[recorre].as_desc_cliente     + '</td>'                                                      +
                        '<td class="descarto" style="white-space: nowrap">' + nombreCbte       + '</td>'                                                      +
                        '<td class="descarto">' + listadoCobranza[recorre].as_clase_cbte_rbo   + '</td>'                                                      +
                        '<td class="descarto">' + listadoCobranza[recorre].as_numero_cbte_rbo  + '</td>'                                                      +
                        '<td class="descarto" style="padding-left: 2px; padding-right: 1px; text-align: right">' + adec_mto_total_rbo + '</td>'               +
                        '<td class="descarto" style="white-space: nowrap">' + nombreCbteCancel    + '</td>'                                                   +
                        '<td class="descarto">' + listadoCobranza[recorre].as_clase_cbte_cancel   + '</td>'                                                   +
                        '<td class="descarto">' + listadoCobranza[recorre].as_numero_cbte_cancel  + '</td>'                                                   +
                        '<td class="descarto" style="padding-left: 2px; padding-right: 1px; text-align: right">' + adec_mto_total_cbte_cancel + '</td>'       +
                        '<td class="descarto" style="padding-left: 2px; padding-right: 1px; text-align: right">' + adec_mto_cbte_cancel + '</td>'             +
                        '<td class="descarto" name="columnaBotonConsultar">' + consultaCbte + '</td>'                                                         +

                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:12px; padding-left: 10px;">' + fecha_rbo + '</td>'                +
                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:12px; padding-left: 2px; padding-right: 2px" colspan="3">'        + 
                          listadoCobranza[recorre].an_cod_cliente + ' - ' +  listadoCobranza[recorre].as_desc_cliente                                         + 
                        '</td>'                                                                                                                               +
                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:12px; padding-left: 2px; padding-right: 2px; white-space: nowrap" colspan="2">' + nombreCbteMobile  + '</td>' +
                        '<td class="soloMobile" ' + consultaCbteMobile + ' style="font-size:12px; padding-left: 2px; padding-right: 10px; text-align: right">' + adec_mto_total_rbo + '</td>'             +

                     '</tr>';

    $('#listado tbody').append(fila);

    if ( recorre == ( listadoCobranza.length - 1 ) ) {

       var fila_total =  '<tr class="resaltador">'                                                                                                            +

                           '<td style="padding-left: 12px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="6" class="descarto text-center fontsize">'   +
                              '<strong>'                                                                                                                      +
                                'Total General: '                                                                                                             +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                 +
                              '<strong>'                                                                                                                      +
                                adec_mto_total_rbo_gral                                                                                                       +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td class="descarto" colspan="3"></td>'                                                                                           +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                 +
                              '<strong>'                                                                                                                      +
                                adec_mto_total_cbte_canc_gral                                                                                                 +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td style="padding-left: 3px; padding-right: 1px; text-align: right; color:#1ab394;" class="descarto fontsize" >'                 +
                              '<strong>'                                                                                                                      +
                                adec_mto_cbte_cancel_gral                                                                                                     +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td name="columnaBotonConsultar" class="descarto"></th>'                                                                                         +

                           '<td style="font-size:12px; padding-left: 10px; text-align: left; color:#1ab394;" colspan="6" class="soloMobile text-center fontsize">'   +
                              '<strong>'                                                                                                                      +
                                'Total General: '                                                                                                             +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +
                           '<td style="font-size:12px; padding-right:10px; text-align: right; color:#1ab394;" class="soloMobile fontsize" >'                  +
                              '<strong>'                                                                                                                      +
                                adec_mto_total_rbo_gral                                                                                                       +
                              '</strong>'                                                                                                                     +
                           '</td>'                                                                                                                            +

                        '</tr>';
      $('#listado tbody').append(fila_total);

    }

  }

}