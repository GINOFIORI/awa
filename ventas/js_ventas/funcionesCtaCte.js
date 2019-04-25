function mostrarIconoCtaCte() {
  document.body.style.cursor='wait';
  cargandoCtaCte  = document.getElementById("cargandoCtaCte");
  cargandoReporte = document.getElementById("cargandoReporte");

  if ( !( !(cargandoCtaCte) || (cargandoCtaCte=="") ) ) {
    cargandoCtaCte.style.visibility = 'visible';
  }

  if ( !( !(cargandoReporte) || (cargandoReporte=="") ) ) {
    cargandoReporte.style.visibility = 'visible';
  }
  
}

function ocultarIconoCtaCte() {
  document.body.style.cursor='default';
  cargandoCtaCte  = document.getElementById("cargandoCtaCte");
  cargandoReporte = document.getElementById("cargandoReporte");

  if ( !( !(cargandoCtaCte) || (cargandoCtaCte=="") ) ) {
    cargandoCtaCte.style.visibility = 'hidden';
  }

  if ( !( !(cargandoReporte) || (cargandoReporte=="") ) ) {
    cargandoReporte.style.visibility = 'hidden';
  }

}

function onChangeCliente(){
  $("#cuentaCorriente tbody tr").remove();
  var codCliente = document.getElementById("codCliente").value;
  seleccionarCliente(codCliente);
}

function consultarCbtes(tipoCbte,claseCbte,numeroCbte){

  mostrarIconoCtaCte();
  
  $.post("../../ventas/nv_ventas/recuperarCbtes.php", 
    { tipo_cbte_post:   tipoCbte , 
      clase_cbte_post:  claseCbte , 
      numero_cbte_post: numeroCbte }, 
    function(data) {
      comprobante = JSON.parse(data);
      if ( comprobante.results_row.as_error_msg_js ){
        ocultarIconoCtaCte();
        alert ("Error en la conexión con el servidor del cliente: " + comprobante.results_row.as_error_msg_js );
        return;
      }
      if ( comprobante.results_row.as_return_msg_js ){
        ocultarIconoCtaCte();
        alert ("Alerta!: " + comprobante.results_row.as_return_msg_js );
        return;
      }

      if (comprobante.results_row.length>0){
        //////////////////// ES ARRAY //////////////////////////
        var comprobanteConsultado = comprobante.results_row
      }else{
        ///////////////// TRANSFORMAR EN ARRAY /////////////////
        var comprobanteConsultado = [];
        var object = new Object();
        comprobanteConsultado[0] = object;
        $.each(comprobante.results_row, function(key, value) {
          comprobanteConsultado[0][key] = value
        });

      }

      switch(tipoCbte){
        case 1: case 2: case 3:
          consultarFCNDNC(comprobanteConsultado);
          ocultarIconoCtaCte();
          break;
        case 6:
          consultarRBO(comprobanteConsultado);
          ocultarIconoCtaCte();
          break;
      }

    }
  );
}

function consultarFCNDNC(comprobanteConsultado){

  var nombreCbte = '';

  switch(comprobanteConsultado[0].cbtesvtatipocbte){
    case '1':
      nombreCbte = 'Factura Ventas';
      break;
    case '2':
      nombreCbte = 'Nota Crédito Ventas';
      break;
    case '3':
      nombreCbte = 'Nota Débito Ventas';
      break;
  }

  // preparar campo de fecha /////////////////////////////////////////////////////
  var fechaCbteConsulta = formatearFecha(comprobanteConsultado[0].cbtesvtafec);
  ///////////////////////////////////////////////////////////////////////////////

  document.getElementById("cbtesvtafec").innerHTML = fechaCbteConsulta
  document.getElementById("comprobante").innerHTML = nombreCbte + ' ' + comprobanteConsultado[0].cbtesvtaclasecbte + ' ' + comprobanteConsultado[0].cbtesvtanum;

  document.getElementById("cbtesvtafecMobile").innerHTML = fechaCbteConsulta
  document.getElementById("comprobanteMobile").innerHTML = nombreCbte + ' ' + comprobanteConsultado[0].cbtesvtaclasecbte + ' ' + comprobanteConsultado[0].cbtesvtanum;

  var domicilio = '';

  if ( typeof(comprobanteConsultado[0].callesnomb)==='string' ){
    domicilio = comprobanteConsultado[0].callesnomb;
  }

  if (typeof(comprobanteConsultado[0].CbtesVtaAltDomicCbte)==='string'){
    domicilio = domicilio + ' ' + comprobanteConsultado[0].CbtesVtaAltDomicCbte;
  }

  if (typeof(comprobanteConsultado[0].CbtesVtaPisoDomicCbte)==='string'){
    domicilio = domicilio + ' Piso:' + comprobanteConsultado[0].CbtesVtaPisoDomicCbte;
  }

  if (typeof(comprobanteConsultado[0].CbtesVtaDptoDomicCbte)==='string'){
    domicilio = domicilio + ' Dpto.:' + comprobanteConsultado[0].CbtesVtaDptoDomicCbte;
  }

  if (typeof(comprobanteConsultado[0].CbtesVtaAdicDomicCbte)==='string'){
    domicilio = domicilio + ' (' + comprobanteConsultado[0].CbtesVtaAdicDomicCbte; + ')'
  }

  if (typeof(comprobanteConsultado[0].localicod)==='string'){
    domicilio = domicilio + '. ' + comprobanteConsultado[0].localicod;
  }

  if (typeof(comprobanteConsultado[0].localinomb)==='string'){
    domicilio = domicilio + ' - ' + comprobanteConsultado[0].localinomb;
  }

  if (typeof(comprobanteConsultado[0].provinnomb)==='string'){
    domicilio = domicilio + ', ' + comprobanteConsultado[0].provinnomb;
  }

  document.getElementById("clientvtasnomb").innerHTML = comprobanteConsultado[0].clientvtasnomb;
  document.getElementById("domicilio").innerHTML = domicilio;
  document.getElementById("formapagovtadesc").innerHTML = comprobanteConsultado[0].formapagovtadesc;
  document.getElementById("vendvtasnomb").innerHTML = comprobanteConsultado[0].vendvtasapell + ", " + comprobanteConsultado[0].vendvtasnomb;
  document.getElementById("condicvta").innerHTML = comprobanteConsultado[0].datosimposdesc;

  document.getElementById("clientvtasnombMobile").innerHTML = comprobanteConsultado[0].clientvtasnomb;
  document.getElementById("domicilioMobile").innerHTML = domicilio;
  document.getElementById("formapagovtadescMobile").innerHTML = comprobanteConsultado[0].formapagovtadesc;
  document.getElementById("vendvtasnombMobile").innerHTML = comprobanteConsultado[0].vendvtasapell + ", " + comprobanteConsultado[0].vendvtasnomb;
  document.getElementById("condicvtaMobile").innerHTML = comprobanteConsultado[0].datosimposdesc;

  $("#detalleComprobante tbody tr").remove();
  $("#detalleComprobanteMobile tbody tr").remove();

  for (var recorre2 in comprobanteConsultado ) {

    if ( (comprobanteConsultado[recorre2].cbtesvtadetcodadmin) === 'CONCEPTO' ){
      var descripcionRenglon = comprobanteConsultado[recorre2].cbtesvtadetdescadic
    }else{
      var descripcionRenglon = comprobanteConsultado[recorre2].cbtesvtadetarticdesc
    }

    if ( comprobanteConsultado[recorre2].cbtesvtaclasecbte === 'A' ) {
      var precioUnitario = formatearNumero ( comprobanteConsultado[recorre2].cbtesvtadetmtonetounit );
      var cantidad       = formatearNumero ( comprobanteConsultado[recorre2].cbtesvtadetcant );
      var montoTotal     = formatearNumero ( comprobanteConsultado[recorre2].cbtesvtadetmontoneto );
    }else{
      var montoTotal     = formatearNumero ( comprobanteConsultado[recorre2].cbtesvtadetmontotot );
      var cantidad       = formatearNumero ( comprobanteConsultado[recorre2].cbtesvtadetcant );
      var precioUnitario = parseFloat ( montoTotal ) / parseFloat ( cantidad );
      precioUnitario     = formatearNumero ( precioUnitario );
    }

    var filaDetalle =   '<tr class="resaltador">'                                         +
                          '<td class="text-center descarto" width="150px">'               +
                          comprobanteConsultado[recorre2].cbtesvtadetcodadmin             +
                          '</td>'                                                         + 
                          '<td class="text-center descarto" width="800px">'               +
                          descripcionRenglon                                              +
                          '</td>'                                                         +
                          '<td class="text-center descarto" width="150px">'               +
                          precioUnitario                                                  +
                          '</td>'                                                         +
                          '<td class="text-center descarto" width="150px">'               +
                          cantidad                                                        +
                          '</td>'                                                         +
                          '<td class="text-center descarto" width="150px">'               +
                          montoTotal                                                      +
                          '</td>'                                                         +
                          '<td class="text-center soloMobile" style="font-size: 10px" >'  +
                          comprobanteConsultado[recorre2].cbtesvtadetcodadmin             +
                          '</td>'                                                         + 
                          '<td class="text-center soloMobile" style="font-size: 10px" >'  +
                          descripcionRenglon                                              +
                          '</td>'                                                         +
                          '<td class="text-center soloMobile" style="font-size: 10px" >'  +
                          precioUnitario                                                  +
                          '</td>'                                                         +
                          '<td class="text-center soloMobile" style="font-size: 10px" >'  +
                          cantidad                                                        +
                          '</td>'                                                         +
                          '<td class="text-center soloMobile" style="font-size: 10px" >'  +
                          montoTotal                                                      +
                          '</td>'                                                         +
                        '</tr>';
    $('#detalleComprobante tbody').append(filaDetalle);
    $('#detalleComprobanteMobile tbody').append(filaDetalle);
  }

  if ( comprobanteConsultado[0].cbtesvtatipodto == "1" ){
    var descuento = "$ ";
  }else{
    var descuento = "% ";
  }

  if ( typeof(comprobanteConsultado[0].cbtesvtamontodto)==='string' ){
    descuento = descuento + comprobanteConsultado[0].cbtesvtamontodto
  }

  $("#totalesComprobante tbody tr").remove();
  $("#totalesComprobanteMobile tbody tr").remove();
  var totales = '<tr>'                                                +
                  '<td class="text-center">'                          +
                  formatearNumero ( comprobanteConsultado[0].cbtesvtamontototimpon )      +
                  '</td>'                                             +
                  '<td class="text-center">'                          +
                  formatearNumero ( comprobanteConsultado[0].cbtesvtamontototexen )       +
                  '</td>'                                             +
                  '<td class="text-center">'                          +
                  descuento                                           +
                  '</td>'                                             +
                  '<td class="text-center">'                          +
                  formatearNumero ( comprobanteConsultado[0].cbtesvtamontofinimpon )      +
                  '</td>'                                             +
                  '<td class="text-center descarto">'                 +
                  formatearNumero ( comprobanteConsultado[0].cbtesvtamontofinexen )       +
                  '</td>'                                             +
                  '<td class="text-center descarto">'                 +
                  formatearNumero ( comprobanteConsultado[0].cbtesvtamontototivari )      +
                  '</td>'                                             +
                  '<td class="text-center descarto">'                 +
                  formatearNumero ( comprobanteConsultado[0].cbtesvtamontoreten )         +
                  '</td>'                                             +
                  '<td class="text-center descarto">'                 +
                  formatearNumero ( comprobanteConsultado[0].cbtesvtamontotot )           +
                  '</td>'                                             +
                '</tr>';
  var totalesMobile = '<tr>'                                          +
                        '<td class="text-center soloMobile" style="font-size: 10px">'         +
                        comprobanteConsultado[0].cbtesvtamontofinexen +
                        '</td>'                                       +
                        '<td class="text-center soloMobile" style="font-size: 10px">'         +
                        comprobanteConsultado[0].cbtesvtamontototivari+
                        '</td>'                                       +
                        '<td class="text-center soloMobile" style="font-size: 10px">'         +
                        comprobanteConsultado[0].cbtesvtamontoreten   +
                        '</td>'                                       +
                        '<td class="text-center soloMobile" style="font-size: 10px">'         +
                        comprobanteConsultado[0].cbtesvtamontotot     +
                        '</td>'                                       +
                      '</tr>';
  $('#totalesComprobante tbody').append(totales);
  $('#totalesComprobanteMobile tbody').append(totalesMobile);

  $("#consultaCbtes").modal("show");
}

function consultarRBO(comprobanteConsultado){

  // preparar campo de fecha /////////////////////////////////////////////////////
  var fechaCbteConsulta = formatearFecha(comprobanteConsultado[0].reccobrovtasfec);
  ////////////////////////////////////////////////////////////////////////////////

  document.getElementById("reccobrovtasfec").innerHTML = fechaCbteConsulta
  document.getElementById("recibocobro").innerHTML = "Recibo Cobro X " + comprobanteConsultado[0].reccobrovtasnum

  var domicilio = '';

  if ( typeof(comprobanteConsultado[0].callesnomb)==='string' ){
    domicilio = comprobanteConsultado[0].callesnomb;
  }

  if (typeof(comprobanteConsultado[0].CbtesVtaAltDomicCbte)==='string'){
    domicilio = domicilio + ' ' + comprobanteConsultado[0].CbtesVtaAltDomicCbte;
  }

  if (typeof(comprobanteConsultado[0].CbtesVtaPisoDomicCbte)==='string'){
    domicilio = domicilio + ' Piso:' + comprobanteConsultado[0].CbtesVtaPisoDomicCbte;
  }

  if (typeof(comprobanteConsultado[0].CbtesVtaDptoDomicCbte)==='string'){
    domicilio = domicilio + ' Dpto.:' + comprobanteConsultado[0].CbtesVtaDptoDomicCbte;
  }

  if (typeof(comprobanteConsultado[0].CbtesVtaAdicDomicCbte)==='string'){
    domicilio = domicilio + ' (' + comprobanteConsultado[0].CbtesVtaAdicDomicCbte; + ')'
  }

  if (typeof(comprobanteConsultado[0].localicod)==='string'){
    domicilio = domicilio + '. ' + comprobanteConsultado[0].localicod;
  }

  if (typeof(comprobanteConsultado[0].localinomb)==='string'){
    domicilio = domicilio + ' - ' + comprobanteConsultado[0].localinomb;
  }

  if (typeof(comprobanteConsultado[0].provinnomb)==='string'){
    domicilio = domicilio + ', ' + comprobanteConsultado[0].provinnomb;
  }

  if (typeof(comprobanteConsultado[0].clientvtascuit)==='string'){
    var cuit = comprobanteConsultado[0].clientvtascuit;
  }else{
    var cuit = '';
  }

  document.getElementById("rboclientvtasnomb").innerHTML = comprobanteConsultado[0].clientvtasnomb;
  document.getElementById("rbodomicilio").innerHTML = domicilio;
  document.getElementById("clientvtascuit").innerHTML = cuit;

  $("#detalleRecibo tbody tr").remove();

  for (var recorre2 in comprobanteConsultado ) {

    if(typeof(comprobanteConsultado[0].cbtesvtatipocbte) !== 'string' ){
      break;
    }

    // preparar campo de fecha /////////////////////////////////////////////////////
    var fechaCbte = formatearFecha(comprobanteConsultado[0].reccobrovtasdetfec);
    /////////////////////////////////////////////////////////////////////////////////

    switch(comprobanteConsultado[0].cbtesvtatipocbte){
      case '1':
        nombreCbte = 'Factura Ventas';
        break;
      case '2':
        nombreCbte = 'Nota Crédito Ventas';
        break;
      case '3':
        nombreCbte = 'Nota Débito Ventas';
        break;
    }

    var filaRecibo =    '<tr class="resaltador">'                                         +
                          '<td class="text-center descarto" width="358px" colspan="3">'   +
                          nombreCbte                                                      +
                          ' '                                                             +
                          comprobanteConsultado[recorre2].cbtesvtaclasecbte               +
                          ' '                                                             +
                          comprobanteConsultado[recorre2].cbtesvtanum                     +
                          '</td>'                                                         +
                          '<td class="text-center descarto" width="100px">'               +
                          fechaCbte                                                       +
                          '</td>'                                                         +
                          '<td class="text-center descarto" width="100px">'               +
                          fechaCbte                                                       +
                          '</td>'                                                         +
                          '<td class="text-center descarto" width="100px">'               +
                          comprobanteConsultado[recorre2].reccobrovtasdetmtocbtes         +
                          '</td>'                                                         +
                          '<td class="text-center descarto" width="100px">'               +
                          comprobanteConsultado[recorre2].reccobrovtasdetmonto            +
                          '</td>'                                                         + 
                          '<td class="text-center descarto" width="120px">'               +
                          comprobanteConsultado[recorre2].reccobrovtasdetmonto            +
                          '</td>'                                                         + 
                          '<td class="text-center soloMobile" style="font-size: 10px" width="358px" colspan="3">'    +
                          nombreCbte                                                      +
                          ' '                                                             +
                          comprobanteConsultado[recorre2].cbtesvtaclasecbte               +
                          ' '                                                             +
                          comprobanteConsultado[recorre2].cbtesvtanum                     +
                          '</td>'                                                         +
                          '<td class="text-center soloMobile" style="font-size: 10px" width="50px">'                + 
                          fechaCbte                                                       +
                          '</td>'                                                         +
                          '<td class="text-center soloMobile" style="font-size: 10px" width="70px">'                +
                          comprobanteConsultado[recorre2].reccobrovtasdetmonto            +
                          '</td>'                                                         + 
                        '</tr>';
    $('#detalleRecibo tbody').append(filaRecibo);
  }

  $("#totalesRecibo tbody tr").remove();
  $("#totalesRboMobile tbody tr").remove();

  var totalesRbo = '<tr>'                                                +
                      '<td class="text-center">'                          +
                      comprobanteConsultado[0].reccobrovtasmontofin       +
                      '</td>'                                             +
                      '<td class="text-center">'                          +
                      comprobanteConsultado[0].reccobrovtasmontoreten     +
                      '</td>'                                             +
                      '<td class="text-center">'                          +
                      comprobanteConsultado[0].reccobrovtasmontochq       +
                      '</td>'                                             +
                      '<td class="text-center descarto" >'                +
                      comprobanteConsultado[0].reccobrovtasmontotrans     +
                      '</td>'                                             +
                      '<td class="text-center descarto">'                 +
                      comprobanteConsultado[0].reccobrovtasmontotarj      +
                      '</td>'                                             +
                      '<td class="text-center descarto">'                 +
                      comprobanteConsultado[0].reccobrovtasmontoefvo      +
                      '</td>'                                             +
                    '</tr>';

  var totalesRboMobile =  '<tr>'                                                +
                            '<td class="text-center soloMobile" style="font-size: 10px" >'              +
                            comprobanteConsultado[0].reccobrovtasmontotrans     +
                            '</td>'                                             +
                            '<td class="text-center soloMobile" style="font-size: 10px">'               +
                            comprobanteConsultado[0].reccobrovtasmontotarj      +
                            '</td>'                                             +
                            '<td class="text-center soloMobile" style="font-size: 10px">'               +
                            comprobanteConsultado[0].reccobrovtasmontoefvo      +
                            '</td>'                                             +
                          '</tr>';
  
  $('#totalesRecibo tbody').append(totalesRbo);
  $('#totalesRboMobile tbody').append(totalesRboMobile);

  $("#consultaRecibos").modal("show");
}

function descargarDuplicadoElectronico(tipoCbte,claseCbte,numeroCbte){
  mostrarIconoCtaCte();
  
  $.post("../../ventas/nv_ventas/descargarCbtes.php" , 
    { tipo_cbte_post:   tipoCbte , 
      clase_cbte_post:  claseCbte , 
      numero_cbte_post: numeroCbte}, 
    function(data) {
      var link = data.substr( data.indexOf('path') + 4  , 200);
      var link = link.substr( 0 , link.indexOf('/path' ) );
      window.open(link, link);
      ocultarIconoCtaCte();
    }
  );
}

function recuperarCuentaCorriente(){
  mostrarIconoCtaCte();
  var codCliente = document.getElementById("codCliente").value;
  var fechaDesde = document.getElementById("fechaDesde").value;
  var fechaHasta = document.getElementById("fechaHasta").value;
  var orden      = document.getElementById("orden").value;
  if ( document.getElementById("noAnulados").checked ){var exclAnul = 1;}else{var exclAnul = 0;}
  if ( document.getElementById("noCancelados").checked ){var exclCancel = 1;}else{var exclCancel = 0;}

  if ( !(codCliente) || (codCliente=="") || (isNaN(codCliente)) ){
    document.getElementById("codCliente").style.border="solid 1px red";
    ocultarIconoCtaCte();
    alert("El cliente ingresado es inválido!");
    return;
  }else{
    document.getElementById("codCliente").style.border="";
  }

  if ( !(fechaDesde) || (fechaDesde=="") ){
    document.getElementById("fechaDesde").style.border="solid 1px red";
    ocultarIconoCtaCte();
    alert("El período de fechas es inválido!");
    return;
  }else{
    document.getElementById("fechaDesde").style.border="";
  }

  if ( !(fechaHasta) || (fechaHasta=="") ){
    document.getElementById("fechaHasta").style.border="solid 1px red";
    ocultarIconoCtaCte();
    alert("El período de fechas es inválido!");
    return;
  }else{
    document.getElementById("fechaHasta").style.border="";
  }

  if ( fechaDesde > fechaHasta ){
    document.getElementById("fechaDesde").style.border="solid 1px red";
    document.getElementById("fechaHasta").style.border="solid 1px red";
    ocultarIconoCtaCte();
    alert("El período de fechas es inválido!");
    return;
  }

  $.post("../../ventas/nv_ventas/recuperarCtaCte.php", 
    { cod_cliente: codCliente  , 
      fecha_desde: fechaDesde , 
      fecha_hasta: fechaHasta ,
      excl_anul:   exclAnul ,
      orden:       orden,
      excl_cancel: exclCancel }, 
    function(data) {
      ctacte = JSON.parse(data);
      if ( ctacte.results_row.as_error_msg_js ){
        $("#cuentaCorriente tbody tr").remove();
        ocultarIconoCtaCte();
        alert ("Error en la conexión con el servidor del cliente: " + ctacte.results_row.as_error_msg_js );
        return;
      }
      if ( ctacte.results_row.as_return_msg_js ){
        $("#cuentaCorriente tbody tr").remove();
        ocultarIconoCtaCte();
        alert ("Alerta!: " + ctacte.results_row.as_return_msg_js );
        return;
      }

      $("#cuentaCorriente tbody tr").remove();

      if (ctacte.results_row.length>0){
        ///////////////////////////// ES ARRAY //////////////////////////////////
        var cuentaCorriente = ctacte.results_row
      }else{
        //////////////////////// TRANSFORMAR EN ARRAY ///////////////////////////
        var cuentaCorriente = [];
        var renglon = new Object();
        cuentaCorriente[0] = renglon;
        $.each(ctacte.results_row, function(key, value) {
          cuentaCorriente[0][key] = value
        });
      }
      ///////////////////// SALDO INICIAL ///////////////////////////////////////

      var filaSaldoInicial =  '<tr class="resaltador">'                   +
                                '<td class="text-right" colspan="13">'    +
                                '<strong> Saldo anterior: '                +
                                cuentaCorriente[0].adec_saldo_inicial  +
                                '</strong>'                               +
                                '</td>'                                   +
                              '</tr>';

      $('#cuentaCorriente tbody').append(filaSaldoInicial);

      for (var recorre in cuentaCorriente ) {
      ///////////////////// VALORES PARA EL COMPROBANTE ... /////////////////////
        switch(cuentaCorriente[recorre].an_tipo_cbte){
          case '1':
            var nombreCbte = 'FC Vtas.';
            var nombreCbteMobile = 'FC';
            break;
          case '2':
            var nombreCbte = 'NC Vtas.';
            var nombreCbteMobile = 'NC';
            break;
          case '3':
            var nombreCbte = 'ND Vtas.';
            var nombreCbteMobile = 'ND';
            break;
          case '6':
            var nombreCbte = 'Recibo';
            var nombreCbteMobile = 'RC';
            break;
        }

        // preparar campos de fecha /////////////////////////////////////////////////////
        var fechaCbteBD = formatearFecha(cuentaCorriente[recorre].adt_fecha_cbte);
        var fechaVtoBD  = formatearFecha(cuentaCorriente[recorre].adt_fecha_vto);
        var fechaCancBD = formatearFecha(cuentaCorriente[recorre].adt_fecha_canc);
        ////////////////////////////////////////////////////////////////////////////////

        if ( cuentaCorriente[recorre].adec_monto_debe == 0 ){
          var monto_debe = '';
        }else{
          var monto_debe       = formatearNumero ( cuentaCorriente[recorre].adec_monto_debe );
          var monto_debe_haber = formatearNumero ( cuentaCorriente[recorre].adec_monto_debe );
        };

        if ( cuentaCorriente[recorre].adec_monto_haber == 0 ){
          var monto_haber = '';
        }else{
          var monto_haber = formatearNumero ( cuentaCorriente[recorre].adec_monto_haber );
          var monto_debe_haber = formatearNumero ( cuentaCorriente[recorre].adec_monto_haber * -1 );
        };

        var saldo_acum = formatearNumero ( cuentaCorriente[recorre].adec_saldo_acum );

        if ( cuentaCorriente[recorre].an_pago_ctdo == 1){
          var cbx_ctdo = '<span class="glyphicon glyphicon-check" aria-hidden="false"></span>';
        }else{
          var cbx_ctdo = '<span class="glyphicon glyphicon-unchecked" aria-hidden="false"></span>';
        };

        if ( cuentaCorriente[recorre].an_cbte_canc == 1){
          var cbx_cancel = '<span class="glyphicon glyphicon-check" aria-hidden="false"></span>';
        }else{
          var cbx_cancel = '<span class="glyphicon glyphicon-unchecked" aria-hidden="false"></span>';
        };

        if ( cuentaCorriente[recorre].an_ajuste_cbte == 1){
          var cbx_ajuste = '<span class="glyphicon glyphicon-check" aria-hidden="false"></span>';
        }else{
          var cbx_ajuste = '<span class="glyphicon glyphicon-unchecked" aria-hidden="false"></span>';
        };

        ////////////////// Estilos Personalizados Según Orden //////////////////

        if ( ( orden == 2) &&
             ( cuentaCorriente[recorre].an_tipo_cbte == 1 || cuentaCorriente[recorre].an_tipo_cbte == 3 ) &&
             ( cuentaCorriente[recorre].an_pago_ctdo !==1 ) ){
          var negrita = "font-weight:bold; ";
        }else{
          var negrita = "";
        };

        if ( cuentaCorriente[recorre].an_cbte_anul == 1 ){
          var color = "color:#8B0000; ";
        }else{
          var color = "";
        }

        var estilo_renglon = 'style="cursor:pointer; ' + negrita + color + '"';

        //////////////////// Boton de consulta de descarga de cbtes electronicos ////////////////////
        
        if ( !(cuentaCorriente[recorre].an_tipo_cbte == 6) ){
          var botonDuplElectr = "<button type='button' "                      +
                                        "class='btn btn-primary btn-xs' "     +
                                        "onClick=descargarDuplicadoElectronico("    +
                                        cuentaCorriente[recorre].an_tipo_cbte    + ",'"    +  
                                        cuentaCorriente[recorre].as_clase_cbte   + "','"   + 
                                        cuentaCorriente[recorre].as_numero_cbte  + "')>"   +
                                        "<span class='glyphicon glyphicon-print' aria-hidden='false'></span>" +
                                "</button>";
        }else{
          var botonDuplElectr = "<button type='button' "                      +
                                        "class='btn btn-primary btn-xs' "     +
                                        "style='background-color: grey; border: grey' >"    +
                                        "<span class='glyphicon glyphicon-print' aria-hidden='false'></span>" +
                                "</button>";
        }

        var consultaCbte =  "onClick=consultarCbtes("                 +
                            cuentaCorriente[recorre].an_tipo_cbte     + ",'"    +  
                            cuentaCorriente[recorre].as_clase_cbte    + "','"   + 
                            cuentaCorriente[recorre].as_numero_cbte   + "')" 

        var filaCtaCte  =   '<tr class="resaltador" '+ estilo_renglon + ' >' +
                              '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="descarto" ' + consultaCbte + '>'                     +
                              fechaCbteBD                             +
                              '</td>'                                 + 
                              '<td style="text-align:center; padding-left: 1px; padding-right: 1px; font-size: 12px" class="soloMobile" ' + consultaCbte + '>'  +
                              fechaCbteBD                             +
                              '</td>'                                 + 
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-center descarto" ' + consultaCbte + '>'      +
                              nombreCbte                              +
                              '</td>'                                 +
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-center descarto" ' + consultaCbte + '>'      +
                              cuentaCorriente[recorre].as_clase_cbte  + 
                              '</td>'                                 +
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-center descarto" ' + consultaCbte + '>'      +
                              cuentaCorriente[recorre].as_numero_cbte + 
                              '</td>'                                 +
                              '<td style="padding-left: 1px; padding-right: 1px; font-size: 12px" class="text-center soloMobile" ' + consultaCbte + '>'         +
                              nombreCbteMobile  + ' ' + cuentaCorriente[recorre].as_clase_cbte + ' ' + cuentaCorriente[recorre].as_numero_cbte                  + 
                              '</td>'                                 +
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-center descarto" ' + consultaCbte + '>'     +
                              fechaVtoBD                              +
                              '</td>'                                 +
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-right descarto" ' + consultaCbte + '>'      +
                              monto_debe                              +  
                              '</td>'                                 +
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-right descarto" ' + consultaCbte + '>'      +
                              monto_haber                             + 
                              '</td>'                                 +
                              '<td style="padding-left: 1px; padding-right: 1px; font-size: 12px" class="text-right soloMobile" ' + consultaCbte + '>'          +
                              monto_debe_haber                        +
                              '</td>'                                 + 
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-right descarto" ' + consultaCbte + '>'                             +
                              saldo_acum                              +
                              '</td>'                                 +  
                              '<td style="padding-left: 1px; padding-right: 1px; font-size: 12px" class="text-right soloMobile" ' + consultaCbte + '>'          +
                              saldo_acum                              +
                              '</td>'                                 +  
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-right descarto" ' + consultaCbte + '>'                             +
                              cbx_ctdo                                +
                              '</td>'                                 + 
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-right descarto" ' + consultaCbte + '>'                             + 
                              cbx_cancel                              +
                              '</td>'                                 +  
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-right descarto" ' + consultaCbte + '>'                             +
                              fechaCancBD                             +
                              '</td>'                                 +  
                              '<td style="padding-left: 1px; padding-right: 1px" class="text-center descarto" ' + consultaCbte + '>'                            +
                              cbx_ajuste                              +
                              '</td>'                                 +   
                              '<td style="padding-left: 2px; padding-right: 1px; text-align: left; display: inline-block;">'                                    +
                              botonDuplElectr                         +
                              '</td>'                                 + 
                            '</tr>';
      $('#cuentaCorriente tbody').append(filaCtaCte);
      };
      ocultarIconoCtaCte();
    }
  );
}

function imprimirCtaCte(){
  document.getElementById("mostrarOcultarFiltros").click();
  document.getElementById("divHeaderDeImpresion").style.display = "";
  window.print();
  document.getElementById("mostrarOcultarFiltros").click();
  document.getElementById("divHeaderDeImpresion").style.display = "none";
}


