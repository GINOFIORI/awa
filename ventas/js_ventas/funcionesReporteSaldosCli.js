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
    document.getElementById("buscarCli").disabled=false;
  }else{
    document.getElementById("codCliente").disabled=true;
    document.getElementById("buscarCli").disabled=true;
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
  $("#reporteSaldoCLi tbody tr").remove();
  var codCliente = document.getElementById("codCliente").value;
  document.getElementById("razonSocial").innerHTML    = '<i id="cargandoDatosCli" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: "></i>'
  seleccionarCliente(codCliente);
}

function recuperarSaldo(rol){
  mostrarIconoRep();
  var fechaRef    = document.getElementById("fechaReferencia").value;
  var tipoListado = document.getElementById("tipoListado").value;
  var tipoOrden   = document.getElementById("tipoOrden").value;
  var tipoSaldos  = document.getElementById("tipoSaldos").value;

  if ( document.getElementById("seleccionarCliente").checked){var codCliente = document.getElementById("codCliente").value;} else{var codCliente = 0;}

  var codRol = rol; 

  if (codRol == 3) {
    var codVendedor    = document.getElementById("listaVendedores").value;
    var separaVendedor = 1;
  }else{
    if ( document.getElementById("todosVendedores").checked){var codVendedor = 0;} else{var codVendedor = document.getElementById("listaVendedores").value;}
    if ( document.getElementById("separarVendedores").checked ){var separaVendedor = 1;}else{var separaVendedor = 0;}
  }

  if ( !(fechaRef) || (fechaRef=="") ){
    document.getElementById("fechaReferencia").style.border="solid 1px red";
    ocultarIconoRep();
    alert("La fecha de referencia no es válida!");
    return;
  }else{
    document.getElementById("fechaReferencia").style.border="";
  }

  if ( ( document.getElementById("seleccionarCliente").checked &&  codCliente == null ) ) {
      alert("El cliente no es válido!");
      ocultarIconoRep();
      return;
  }

  comandoSaldosCli = "LISTADOSALDOSCLIENTES("+fechaRef+","+tipoListado+","+tipoOrden+","+tipoSaldos+","+codCliente+","+separaVendedor+","+codVendedor+")";

  $.post("../../ventas/nv_ventas/listadoSaldosClientes.php", 
    { cod_cliente: codCliente, 
      fecha_ref: fechaRef, 
      tipo_listado: tipoListado,
      tipo_orden: tipoOrden,
      tipo_saldos: tipoSaldos, 
      separar_vendedores: separaVendedor,
      codigo_vendedor: codVendedor }, 
   function(data) {
      reporteSaldo = JSON.parse(data);        

      if ( reporteSaldo.results_row.as_error_msg_js ){
        $("#reporteSaldoCLi tbody tr").remove();
        ocultarIconoRep();
        alert ("Error en la conexión con el servidor del cliente: " + reporteSaldo.results_row.as_error_msg_js );
        return;
      }

      if ( reporteSaldo.results_row.as_return_msg_js ){
        $("#reporteSaldoCLi tbody tr").remove();
        ocultarIconoRep();
        alert ("Alerta!: " + reporteSaldo.results_row.as_return_msg_js );
        return;
      }

      if (reporteSaldo.results_row.length>0){
        ///////////////////////////// ES ARRAY //////////////////////////////////
        var saldosCliente = reporteSaldo.results_row
      }else{
        //////////////////////// TRANSFORMAR EN ARRAY ///////////////////////////
        var saldosCliente = [];
        var renglon = new Object();
        saldosCliente[0] = renglon;
        $.each(reporteSaldo.results_row, function(key, value) {
          saldosCliente[0][key] = value
        });
      }

      $('#reporteSaldoCLi tbody tr').remove();
      $('#reporteSaldoCLi tbody thead').remove();


      var cod_vendedor_ant;
      var cod_cliente_ant;
      var saldoCliAcum = 0;


     for (var recorre in saldosCliente ) {

        if  (saldosCliente[recorre].as_telefonos_cli == "[object Object]"){ 
                telefono_cli = '-';
              }else{
                telefono_cli = saldosCliente[recorre].as_telefonos_cli;
              } 

        if  ( saldosCliente[recorre].as_cuit_cli == "[object Object]"){ 
                cuit_cli = '-';
              }else{
                cuit_cli = saldosCliente[recorre].as_cuit_cli;
              } 

        if ( tipoListado == 2) {
            ////////// RESUMIDO ////////////
            document.getElementById("encabezado3").style.width       = '250px';
            document.getElementById("encabezado4").style.width       = '230px';
            document.getElementById("encabezado5").className         = "descarto2";
            document.getElementById("encabezado6").className         = "descarto2";    

            document.getElementById("encabezado1").innerHTML         = "Cliente";
            document.getElementById("encabezado2").innerHTML         = "Cuit";
            document.getElementById("encabezado3").innerHTML         = "Teléfono";
            document.getElementById("encabezado4").innerHTML         = "Saldo";

            cod_vendedor = saldosCliente[recorre].an_cod_vendedor;

            if (separaVendedor == 1) {

              if ( cod_vendedor !== cod_vendedor_ant ) {

                var header_vendedor  =  '<tr class="resaltador"  >'                                                                                                               + 
                                         '<td style="padding-left: 10px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="3" class="text-center fontsize_2"><strong>'             +
                                         'Vendedor: '                                                                                                                             +
                                          cod_vendedor + ' - ' + saldosCliente[recorre].as_apell_nomb_vend                                                                        +
                                         '</strong></td>'                                                                                                                         +                               
                                         '<td style=" text-align: left; color:#1ab394;" class="text-center fontsize_2"><strong>' +
                                         'Total vendedor: '                                                                                                                         +
                                         saldosCliente[recorre].adec_total_vend                                                                                                   +
                                         '</td>'                                                                                                                                  +
                                        '</tr>';        
                                 $('#reporteSaldoCLi tbody').append(header_vendedor); 
                cod_vendedor_ant = cod_vendedor;
              }
                   
                var filaReporte   =   '<tr class="resaltador"  >'                                                                              + 
                                       '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                       +
                                        saldosCliente[recorre].an_cod_cliente + ' - ' + saldosCliente[recorre].as_nomb_cliente                 +
                                        '</td>'                                                                                                +
                                        '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                     +
                                        cuit_cli                                                                                               + 
                                        '</td>'                                                                                                + 
                                        '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="fontsize_2">'               +
                                        telefono_cli                                                                                           +
                                        '</td>'                                                                                                +                                 
                                        '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                     +
                                        saldosCliente[recorre].adec_saldo_cbte                                                                 +
                                        '</td>'                                                                                                +
                                      '</tr>';
                                    $('#reporteSaldoCLi tbody').append(filaReporte); 
          }else {
               
           var filaReporte   =   '<tr class="resaltador"  >'                                                                             + 
                                  '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                      +
                                  saldosCliente[recorre].an_cod_cliente + ' - ' + saldosCliente[recorre].as_nomb_cliente                 +
                                  '</td>'                                                                                                +
                                  '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                     +
                                   cuit_cli                                                                                              + 
                                  '</td>'                                                                                                + 
                                  '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="fontsize_2">'               +
                                  telefono_cli                                                                                           +
                                  '</td>'                                                                                                +                                 
                                  '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                     +
                                  saldosCliente[recorre].adec_saldo_cbte                                                                 +
                                  '</td>'                                                                                                +
                                '</tr>';
                                $('#reporteSaldoCLi tbody').append(filaReporte); 
                          }    
          }else if (tipoListado==3) {
            ////////// DETALLADO //////////// 
            document.getElementById("encabezado3").className          = 'descarto1 text-center';
            document.getElementById("encabezado6").className          = 'descarto1 text-center';

            document.getElementById("encabezado1").innerHTML         = "Comprobante";
            document.getElementById("encabezado2").innerHTML         = "Fecha";
            document.getElementById("encabezado3").innerHTML         = "Fecha Vencimiento";
            document.getElementById("encabezado4").innerHTML         = "Importe Comprobante";
            document.getElementById("encabezado5").innerHTML         = "Saldo Comprobante";
            document.getElementById("encabezado6").innerHTML         = "Saldo Acumulado";

            document.getElementById("encabezado1").className         = 'text-center fontsize_2';
            document.getElementById("encabezado2").className         = 'fontsize_2 text-center';
            document.getElementById("encabezado4").className         = 'fontsize_2 text-center';
            document.getElementById("encabezado5").className         = 'fontsize_2 text-center';


            cod_cliente = saldosCliente[recorre].an_cod_cliente; 
            cod_vendedor = saldosCliente[recorre].an_cod_vendedor;

            if (separaVendedor == 1) {

              if ( cod_vendedor !== cod_vendedor_ant ) {

                var header_vendedor  =  '<tr class="resaltador"  >'                                                                                                        +  
                                         '<td style="padding-left: 10px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="3"  class="text-center1 fontsize_2 column"><strong>'      +
                                         'Vendedor: '                                                                                                                      +
                                          cod_vendedor + ' - ' + saldosCliente[recorre].as_apell_nomb_vend                                                                 +
                                         '</strong></td>'                                                                                                                  + 
                                         '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="descarto" >'                                         +
                                         '</td>'                                                                                                                           +                                  
                                         '<td style="text-align: left; color:#1ab394; "class="text-center1 fontsize_2 "><strong>' +       
                                         'Total Vendedor: '                                                                                                                +
                                         saldosCliente[recorre].adec_total_vend                                                                                            +
                                         '</td>'                                                                                                                           +
                                         '<td style="text-align:center; padding-left: 1px; padding-right: 1px" >'                                                          +
                                         '</td>'                                                                                                                           +                                                                                                              +
                                        '</tr>';        
                                 $('#reporteSaldoCLi tbody').append(header_vendedor); 
                cod_vendedor_ant = cod_vendedor;
              }

              if ( cod_cliente !== cod_cliente_ant ) { 

              var header_cliente  =   '<tr>'                                                                                              +   
                                       '<td style="padding-right: 1px; text-align: left" class="text-center1 fontsize_2 cliente" colspan="2"><strong>' +
                                       'Cliente: '                                                                                        +
                                        cod_cliente + ' - ' + saldosCliente[recorre].as_nomb_cliente                                      +
                                       '</strong></td>'                                                                                   + 
                                       '<td style="text-align: left;" class="text-center1  fontsize_2">'                                    +
                                       '<u>Teléfono:</u> '                                                                                +
                                       telefono_cli                                                                                       +
                                       '</td>'                                                                                            + 
                                       '<td style="text-align:center;" class="descarto" >'                                                +
                                       '</td>'                                                                                            +                                    
                                       '<td style="text-align: left" colspan="3" class="text-center1 fontsize_2 "><strong>'                 +
                                       'Total Cliente: '                                                                                  +
                                       saldosCliente[recorre].adec_total_cli                                                              +
                                       '</td>'                                                                                            +
                                      '</tr>'                                                                                             +
                                      '<tr>'                                                                                              +
                                        '<td style="text-align: left; border-top:none" class="text-center1 fontsize_2 cliente" colspan="2">'           + 
                                        '<u>Domicilio:</u> '                                                                              +
                                        saldosCliente[recorre].as_domic_cli                                                               + 
                                        '<td style="text-align: left; border-top:none;" colspan="2" class="text-center1 fontsize_2 " >'     +
                                        '<u>Localidad:</u> '                                                                              +
                                        saldosCliente[recorre].as_localid_cli                                                             + 
                                        '</td>'                                                                                           +
                                      '</tr>' ;        
                               $('#reporteSaldoCLi tbody').append(header_cliente); 
              cod_cliente_ant = cod_cliente;
              saldoCliAcum = 0;                                                                         

            } 
          
            if ( cod_cliente == cod_cliente_ant ) {
                    saldoCliAcum  = parseFloat(saldosCliente[recorre].adec_saldo_cbte) + parseFloat(saldoCliAcum);
                    var saldoCliAcum = saldoCliAcum.toFixed(2);
            } 

            var fecha_cbte     = formatearFecha(saldosCliente[recorre].adt_fecha_cbte);
            
            var fecha_cbte_vto = formatearFecha(saldosCliente[recorre].adt_fecha_cbte);

            var filaReporte    =   '<tr class="resaltador" >'                                                                                                             + 
                                      '<td style="padding-left: 1px; padding-right: 1px" class="text-center  fontsize_2">'                                                  +
                                      saldosCliente[recorre].as_tipo_cbte + '  ' + saldosCliente[recorre].as_clase_cbte  + ' - ' + saldosCliente[recorre].as_numero_cbte  +
                                      '</td>'                                                                                                                             +
                                      '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2 " >'                                                 +
                                      fecha_cbte                                                                                                                          + 
                                      '</td>'                                                                                                                             + 
                                      '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="descarto" >'                                           +
                                      fecha_cbte_vto                                                                                                                      +
                                      '</td>'                                                                                                                             +                                   
                                      '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                                                  + 
                                      saldosCliente[recorre].adec_monto_cbte                                                                                              +
                                      '</td>'                                                                                                                             +
                                      '<td style="text-align:center; padding-left: 1px; padding-right: 1px"  class="text-center fontsize_2">'                               +
                                      saldosCliente[recorre].adec_saldo_cbte                                                                                              +
                                      '</td>'                                                                                                                             +
                                      '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="descarto" >'                                           +
                                      saldoCliAcum                                                                                                                        +
                                      '</td>'                                                                                                                             +
                                    '</tr>';                                                                                                                              
                                    $('#reporteSaldoCLi tbody').append(filaReporte); 
              }else{  //separaVendedor

              if ( cod_cliente !== cod_cliente_ant ) {

              var header_cliente  =   '<tr>'                                                                                                +   
                                       '<td style="padding-right: 1px; text-align: left" class="text-center1 fontsize_2 cliente" colspan="2" ><strong>'   +
                                       'Cliente: '                                                                                          +
                                        cod_cliente + ' - ' + saldosCliente[recorre].as_nomb_cliente                                        +
                                       '</strong></td>'                                                                                     + 
                                       '<td style="text-align: left;" class="text-center1  fontsize_2">'                                      +
                                       '<u>Teléfono:</u> '                                                                                  +
                                       telefono_cli                                                                                         +
                                       '</td>'                                                                                              + 
                                       '<td style="text-align:center;" class="descarto" >'                                                  +
                                       '</td>'                                                                                              +                                    
                                       '<td style="text-align: left" colspan="3" class="text-center1 fontsize_2 "><strong>'                   +
                                       'Total Cliente: '                                                                                    +
                                       saldosCliente[recorre].adec_total_cli                                                                +
                                       '</td>'                                                                                              +
                                      '</tr>'                                                                                               +                                                                                                                         
                                      '<tr>'                                                                                                +
                                        '<td style="text-align: left; border-top:none" class="text-center1 fontsize_2 cliente" colspan="2">'             + 
                                        '<u>Domicilio:</u> '                                                                                +
                                        saldosCliente[recorre].as_domic_cli                                                                 + 
                                        '<td style="text-align: left; border-top:none;" colspan="2" class="text-center1 fontsize_2" >'        +
                                        '<u>Localidad:</u> '                                                                                +
                                        saldosCliente[recorre].as_localid_cli                                                               + 
                                        '</td>'                                                                                             +
                                      '</tr>' ;        
                               $('#reporteSaldoCLi tbody').append(header_cliente); 
              cod_cliente_ant = cod_cliente;
              saldoCliAcum = 0;                                                                         

            } 
          
            if ( cod_cliente == cod_cliente_ant ) {
                    saldoCliAcum  = parseFloat(saldosCliente[recorre].adec_saldo_cbte) + parseFloat(saldoCliAcum);
                    var saldoCliAcum = saldoCliAcum.toFixed(2);
            } 

            var fecha_cbte     = formatearFecha(saldosCliente[recorre].adt_fecha_cbte);
            
            var fecha_cbte_vto = formatearFecha(saldosCliente[recorre].adt_fecha_cbte);

            var filaReporte    =   '<tr class="resaltador" >'                                                                                                             + 
                                      '<td style="padding-left: 1px; padding-right: 1px" class="text-center ">'                                                           +
                                      saldosCliente[recorre].as_tipo_cbte + '  ' + saldosCliente[recorre].as_clase_cbte  + ' - ' + saldosCliente[recorre].as_numero_cbte  +
                                      '</td>'                                                                                                                             +
                                      '<td style="padding-left: 1px; padding-right: 1px" class="text-center " >'                                                          +
                                      fecha_cbte                                                                                                                          + 
                                      '</td>'                                                                                                                             + 
                                      '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="descarto" >'                                           +
                                      fecha_cbte_vto                                                                                                                      +
                                      '</td>'                                                                                                                             +                                   
                                      '<td style="padding-left: 1px; padding-right: 1px" class="text-center class="descarto" " >'                                         + 
                                      saldosCliente[recorre].adec_monto_cbte                                                                                              +
                                      '</td>'                                                                                                                             +
                                      '<td style="text-align:center; padding-left: 1px; padding-right: 1px" >'                                                            +
                                      saldosCliente[recorre].adec_saldo_cbte                                                                                              +
                                      '</td>'                                                                                                                             +
                                      '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="descarto" >'                                           +
                                      saldoCliAcum                                                                                                                        +
                                      '</td>'                                                                                                                             +
                                    '</tr>';                                                                                                                              
                                    $('#reporteSaldoCLi tbody').append(filaReporte); 
                                   

              }
                                   

          }
      }
      ocultarIconoRep();
    }
  );
}

