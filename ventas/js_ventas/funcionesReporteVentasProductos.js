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
  $("#reporteVentasProductos tbody tr").remove();
  var codCliente = document.getElementById("codCliente").value;
  document.getElementById("razonSocial").innerHTML    = '<i id="cargandoDatosCli" class="fa-li fa fa-spinner fa-spin" style="position: relative; visibility: "></i>'
  seleccionarCliente(codCliente);
}


function recuperarVentasProductos(rol){
  mostrarIconoRep();
  
  var fechaDesde  = document.getElementById("fechaDesde").value;
  var fechaHasta  = document.getElementById("fechaHasta").value;
  var tipoCorte   = document.getElementById("tipoCorte").value;

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

  $.post("../../ventas/nv_ventas/listadoVentasProductos.php", 
    { cod_cliente: codCliente, 
      fecha_desde: fechaDesde,
      fecha_hasta: fechaHasta, 
      tipo_corte: tipoCorte,
      separar_vendedores: separaVendedor,
      codigo_vendedor: codVendedor }, 
   function(data) {

      listadoVtasProd = JSON.parse(data);        

      if ( listadoVtasProd.results_row.as_error_msg_js ){
        $("#listadoVtasProd tbody tr").remove();
        ocultarIconoRep();
        alert ("Error en la conexión con el servidor del cliente: " + listadoVtasProd.results_row.as_error_msg_js );
        return;
      }

      if ( listadoVtasProd.results_row.as_return_msg_js ){
        $("#listadoVtasProd tbody tr").remove();
        ocultarIconoRep();
        alert ("Alerta!: " + listadoVtasProd.results_row.as_return_msg_js );
        return;
      }

      if (listadoVtasProd.results_row.length>0){
        ///////////////////////////// ES ARRAY //////////////////////////////////
        var reporteVentasProductos = listadoVtasProd.results_row
      }else{
        //////////////////////// TRANSFORMAR EN ARRAY ///////////////////////////
        var reporteVentasProductos = [];
        var renglon = new Object();
        reporteVentasProductos[0] = renglon;
        $.each(listadoVtasProd.results_row, function(key, value) {
          reporteVentasProductos[0][key] = value
        });
      }

      $('#listadoVtasProd tbody tr').remove();
      $('#listadoVtasProd tbody thead').remove();

     var cod_vendedor_ant;

    for (var recorre in reporteVentasProductos ) {

        if  (reporteVentasProductos[recorre].as_desc_grupo == "[object Object]"){ 
                desc_grupo = '- - -';
              }else{
                desc_grupo = reporteVentasProductos[recorre].as_desc_grupo;
          } 

        if  ( reporteVentasProductos[recorre].as_cod_admin == "[object Object]"){ 
                cod_admin_artic = '-';
              }else{
                cod_admin_artic = reporteVentasProductos[recorre].as_cod_admin;
            } 
        if  ( reporteVentasProductos[recorre].as_desc_articulo == "[object Object]"){ 
                desc_admin_artic = '-';
              }else{
                desc_admin_artic = reporteVentasProductos[recorre].as_desc_articulo;
            } 

        ////////// FORMATEO DE NÚMEROS PARA SEPARADOR DE MILES //////////    

        var mto_total_vend   = formatearNumero(reporteVentasProductos[recorre].adec_total_vend_mto);
        var cant_total_vend  = formatearNumero(reporteVentasProductos[recorre].adec_total_vend_cant);
        var cant_vta_renglon = formatearNumero(reporteVentasProductos[recorre].adec_cant_venta);
        var mto_vta_renglon  = formatearNumero(reporteVentasProductos[recorre].adec_monto_venta);
        var cant_vta_gral    = formatearNumero(reporteVentasProductos[recorre].adec_total_gral_cant);
        var mto_vta_gral     = formatearNumero(reporteVentasProductos[recorre].adec_total_gral_mto); 
    
        ////////// ENCABEZADO MOBILE SEGÚN TIPO CORTE ////////////

        if ( window.matchMedia("(orientation: portrait)").matches ) {

          if ( tipoCorte == 1 && ( window.matchMedia('(max-width: 400px)').matches ) ) {
            document.getElementById("encabezado2").className = 'descarto';
            document.getElementById("encabezado3").className = 'descarto';
            document.getElementById("encabezado1").className = 'text-center fontsize_2';
            document.getElementById("encabezado4").style.width = '70px';
            document.getElementById("encabezado5").style.width = '45px';
            document.getElementById("encabezado7").style.width = '45px';       
          }else if (tipoCorte == 2 && ( window.matchMedia('(max-width: 400px)').matches )) {
            document.getElementById("encabezado3").className   ='fontsize_2 text-center descarto';
            document.getElementById("encabezado1").className   = 'text-center fontsize_2';
            document.getElementById("encabezado2").className   = 'text-center fontsize_2';
            document.getElementById("encabezado5").style.width = '45px';
            document.getElementById("encabezado7").style.width = '45px';       
          }else if (tipoCorte == 3 && ( window.matchMedia('(max-width: 400px)').matches )) {
            document.getElementById("encabezado1").className   = 'fontsize_2 text-center descarto';
            document.getElementById("encabezado2").className   = 'fontsize_2 text-center descarto';
            document.getElementById("encabezado3").className   = 'text-center fontsize_2';
            document.getElementById("encabezado4").style.width = '70px';
            document.getElementById("encabezado5").style.width = '45px';
            document.getElementById("encabezado7").style.width = '45px';       
          }
        }

        document.getElementById("encabezado1").innerHTML = "Familia";
        document.getElementById("encabezado2").innerHTML = "Grupo";
        document.getElementById("encabezado3").innerHTML = "Artículo";
        document.getElementById("encabezado4").innerHTML = "Cantidad";
        document.getElementById("encabezado5").innerHTML = "%";
        document.getElementById("encabezado6").innerHTML = "Monto";
        document.getElementById("encabezado7").innerHTML = "%";

        document.getElementById("encabezado4").className = 'fontsize_2 text-center';
        document.getElementById("encabezado5").className = 'fontsize_2 text-center';
        document.getElementById("encabezado6").className = 'fontsize_2 text-center';
        document.getElementById("encabezado7").className = 'fontsize_2 text-center';

       if (window.matchMedia('(min-width: 1278px)').matches) {
          document.getElementById("encabezado1").style.width       = '250px !important';
          document.getElementById("encabezado2").style.width       = '250px';            
          document.getElementById("encabezado3").style.width       = '250px';
        }

        cod_vendedor = reporteVentasProductos[recorre].an_cod_vendedor;

        if ( window.matchMedia('(max-width: 400px)').matches ) {
          
          if (tipoCorte == 1) {
   
             if ( separaVendedor == 1 && cod_vendedor != cod_vendedor_ant )  {
              var header_vendedor  =  '<tr class="resaltador"  >'                                                                                                            +  
                                        '<td style="padding-left: 10px; padding-right: 1px; text-align: left; color:#1ab394;" class="text-center1 fontsize_2 column"><strong>' +
                                         'Vendedor: '                                                                                                                        +
                                          cod_vendedor + ' - ' + reporteVentasProductos[recorre].as_apell_nomb_vend                                                          +
                                         '</strong>'                                                                                                                         +
                                        '</td>'                                                                                                                              +
                                        '<td style="padding-right: 1px; text-align: left; color:#1ab394; " colspan="2" class="text-center1 fontsize_2 "><strong>'              +       
                                         'Cant. Total: '                                                                                                                     +
                                         cant_total_vend                                                                                                                      +
                                        '</td>'                                                                                                                              +                       
                                        '<td style="padding-right: 1px; text-align: left; color:#1ab394; " colspan="2" class="text-center1 fontsize_2 "><strong>'              +       
                                         'Monto Total: '                                                                                                                     +
                                         mto_total_vend                                                                                                                      +
                                        '</td>'                                                                                                                              +      
                                      '</tr>';         
                               $('#listadoVtasProd tbody').append(header_vendedor); 
              cod_vendedor_ant = cod_vendedor;
            } //cierra if separaVendedor

            var filaReporte = '<tr class="resaltador" >'                                                                                                            + 
                                '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                                                   +
                                reporteVentasProductos[recorre].as_desc_familia                                                                                     +
                                '</td>'                                                                                                                             +
                                '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                                                  + 
                                cant_vta_renglon                                                                                                                    +
                                '</td>'                                                                                                                             +
                                '<td style="text-align:center; padding-left: 1px; padding-right: 1px"  class="text-center fontsize_2">'                               +
                                reporteVentasProductos[recorre].adec_porc_cant_venta                                                                                +
                                '</td>'                                                                                                                             +
                                '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                               +
                                mto_vta_renglon                                                                                                                     +
                                '</td>'                                                                                                                             +
                                '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                                +
                                reporteVentasProductos[recorre].adec_porc_mto_venta                                                                                 +
                                '</td>'                                                                                                                             +
                              '</tr>';                                                                                                                              
                              $('#listadoVtasProd tbody').append(filaReporte); 

            if ( recorre == ( reporteVentasProductos.length - 1 ) ) {
              var fila_total =  '<tr style="border-top:2px solid #1ab394">'                                                                                         +  
                                  '<td style="color:#1ab394;"  class="text-center fontsize_2">'                                                                       +
                                    '<strong>'                                                                                                                      +
                                    'Total Vendido: '                                                                                                               +
                                    '</strong>'                                                                                                                     +
                                  '</td>'                                                                                                                           +
                                  '<td style="padding-right:0px; padding-left:0px; text-align: center; color:#1ab394;" class="text-center fontsize_2">'               +
                                    '<strong>'                                                                                                                      +
                                   cant_vta_gral                                                                                                                    +
                                    '</strong>'                                                                                                                     +
                                  '</td>'                                                                                                                           +
                                   '<td>'                                                                                                                           +
                                  '</td>'                                                                                                                           +
                                  '<td style="padding-right:0px; padding-left:0px; text-align: center; color:#1ab394;"  class="fontsize_2" >'                         +
                                    '<strong>'                                                                                                                      +
                                    mto_vta_gral                                                                                                                    +   
                                  '</td>'                                                                                                                           +   
                                  '<td>'                                                                                                                            +
                                  '</td>'                                                                                                                           +
                                '</tr>';
                              $('#listadoVtasProd tbody').append(fila_total); 
                } //recorre cantidad filas para total                    

          }else if (tipoCorte == 2 ) {

            if ( separaVendedor == 1 && cod_vendedor != cod_vendedor_ant )  {
              var header_vendedor  =  '<tr class="resaltador"  >'                                                                                                          +  
                                       '<td style="padding-left: 10px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="2"  class="text-center1 fontsize_2 column"><strong>'  +
                                       'Vendedor: '                                                                                                                        +
                                        cod_vendedor + ' - ' + reporteVentasProductos[recorre].as_apell_nomb_vend                                                          +
                                       '</strong></td>'                                                                                                                    +                       
                                       '<td style="padding-right: 1px; text-align: left; color:#1ab394; " colspan="2" class="text-center1 fontsize_2 "><strong>'             +       
                                       'Cant. Total: '                                                                                                                     +
                                        cant_total_vend                                                                                                                    +
                                       '</td>'                                                                                                                             +                       
                                       '<td style="padding-right: 1px; text-align: left; color:#1ab394; " colspan="2" class="text-center1 fontsize_2 "><strong>'             +       
                                       'Monto Total: '                                                                                                                     +
                                        mto_total_vend                                                                                                                     +
                                       '</td>'                                                                                                                             +      
                                      '</tr>';         
                               $('#listadoVtasProd tbody').append(header_vendedor); 
              cod_vendedor_ant = cod_vendedor;
            } //cierra separaVendedor
  
            var filaReporte =   '<tr class="resaltador" >'                                                                                                          + 
                                  '<td style="padding-left: 1px; padding-right: 1px" class="text-center  fontsize_2">'                                                +
                                  reporteVentasProductos[recorre].as_desc_familia                                                                                   +
                                  '</td>'                                                                                                                           +
                                  '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2 " >'                                               +
                                  desc_grupo                                                                                                                        + 
                                  '</td>'                                                                                                                           + 
                                  '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                                                + 
                                  cant_vta_renglon                                                                                                                  +
                                  '</td>'                                                                                                                           +
                                  '<td style="text-align:center; padding-left: 1px; padding-right: 1px"  class="text-center fontsize_2">'                             +
                                  reporteVentasProductos[recorre].adec_porc_cant_venta                                                                              +
                                  '</td>'                                                                                                                           +
                                  '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                              +
                                  mto_vta_renglon                                                                                                                   +
                                  '</td>'                                                                                                                           +
                                  '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                              +
                                  reporteVentasProductos[recorre].adec_porc_mto_venta                                                                               +
                                  '</td>'                                                                                                                           +
                                '</tr>';                                                                                                                              
                                $('#listadoVtasProd tbody').append(filaReporte); 

          if ( recorre == ( reporteVentasProductos.length - 1 ) ) {               
            var fila_total =  '<tr style="border-top:2px solid #1ab394">'                                                                                         +  
                                '<td style="color:#1ab394;"  class="text-center fontsize_2">'                                                                       +
                                  '<strong>'                                                                                                                      +
                                  'Total Vendido: '                                                                                                               +
                                  '</strong>'                                                                                                                     +
                                '</td>'                                                                                                                           +
                                '<td>'                                                                                                                            +
                                '</td>'                                                                                                                           +
                                '<td style="padding-right:0px; padding-left:0px; text-align: center; color:#1ab394;" class="text-center fontsize_2">'               +
                                  '<strong>'                                                                                                                      +
                                 cant_vta_gral                                                                                                                    +
                                  '</strong>'                                                                                                                     +
                                '</td>'                                                                                                                           +
                                 '<td>'                                                                                                                           +
                                '</td>'                                                                                                                           +
                                '<td style="padding-right:0px; padding-left:0px; text-align: center; color:#1ab394;"  class="fontsize_2" >'                         +
                                  '<strong>'                                                                                                                      +
                                  mto_vta_gral                                                                                                                    +   
                                '</td>'                                                                                                                           +   
                                '<td>'                                                                                                                            +
                                '</td>'                                                                                                                           +
                                '</tr>';
                            $('#listadoVtasProd tbody').append(fila_total); 
              } //recorre cantidad filas para total                       
          
        }else if (tipoCorte == 3) {

             if ( separaVendedor == 1 && cod_vendedor != cod_vendedor_ant )  {
              var header_vendedor  =  '<tr class="resaltador"  >'                                                                                                              +  
                                         '<td style="padding-left: 10px; padding-right: 1px; text-align: left; color:#1ab394;"  class="text-center1 fontsize_2 column"><strong>' +
                                         'Vendedor: '                                                                                                                          +
                                          cod_vendedor + ' - ' + reporteVentasProductos[recorre].as_apell_nomb_vend                                                            +
                                         '</strong></td>'                                                                                                                      +
                                         '<td style="padding-right: 1px; text-align: left; color:#1ab394; " colspan="2" class="text-center1 fontsize_2 "><strong>'               +         
                                         'Cant. Total: '                                                                                                                       +
                                         cant_total_vend                                                                                                                       +
                                         '</td>'                                                                                                                               +                        
                                         '<td style="padding-right: 1px; text-align: left; color:#1ab394; " colspan="2" class="text-center1 fontsize_2 "><strong>'               +       
                                         'Monto Total: '                                                                                                                       +
                                         mto_total_vend                                                                                                                        +
                                         '</td>'                                                                                                                               + 
                                        '</tr>';         
                               $('#listadoVtasProd tbody').append(header_vendedor); 
              cod_vendedor_ant = cod_vendedor;
            }

            var filaReporte = '<tr class="resaltador" >'                                                                                                        + 
                                '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                            +
                                cod_admin_artic + ' - ' + desc_admin_artic                                                                                      +
                                '</td>'                                                                                                                         +                                   
                                '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                                              + 
                                cant_vta_renglon                                                                                                                +
                                '</td>'                                                                                                                         +
                                '<td style="text-align:center; padding-left: 1px; padding-right: 1px"  class="text-center fontsize_2">'                           +
                                reporteVentasProductos[recorre].adec_porc_cant_venta                                                                            +
                                '</td>'                                                                                                                         +
                                '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                            +
                                mto_vta_renglon                                                                                                                 +
                                '</td>'                                                                                                                         +
                                '<td style="text-align:center; padding-left: 1px; padding-right: 1px"class="text-center fontsize_2">'                             +
                                reporteVentasProductos[recorre].adec_porc_mto_venta                                                                             +
                                '</td>'                                                                                                                         +
                              '</tr>';                                                                                                                        
                              $('#listadoVtasProd tbody').append(filaReporte); 

          if ( recorre == ( reporteVentasProductos.length - 1 ) ) {
                          
            var fila_total =  '<tr style="border-top:2px solid #1ab394">'                                                                                         +  
                                  '<td style="color:#1ab394;"  class="text-center fontsize_2">'                                                                       +
                                    '<strong>'                                                                                                                      +
                                    'Total Vendido: '                                                                                                               +
                                    '</strong>'                                                                                                                     +
                                  '</td>'                                                                                                                           +
                                  '<td style="padding-right:0px; padding-left:0px; text-align: center; color:#1ab394;" class="text-center fontsize_2">'               +
                                    '<strong>'                                                                                                                      +
                                   cant_vta_gral                                                                                                                    +
                                    '</strong>'                                                                                                                     +
                                  '</td>'                                                                                                                           +
                                   '<td>'                                                                                                                           +
                                  '</td>'                                                                                                                           +
                                  '<td style="padding-right:0px; padding-left:0px; text-align: center; color:#1ab394;"  class="fontsize_2" >'                         +
                                    '<strong>'                                                                                                                      +
                                    mto_vta_gral                                                                                                                    +   
                                  '</td>'                                                                                                                           +   
                                  '<td>'                                                                                                                            +
                                  '</td>'                                                                                                                           +
                                '</tr>';
                            $('#listadoVtasProd tbody').append(fila_total); 
              } //recorre cantidad filas para total  
          }//cierra tipos de corte                                              
            }else {
          
          if ( separaVendedor == 1 && cod_vendedor != cod_vendedor_ant )  {
            var header_vendedor  =  '<tr class="resaltador"  >'                                                                                                          +  
                                       '<td style="padding-left: 10px; padding-right: 1px; text-align: left; color:#1ab394;" colspan="3"  class="text-center1 fontsize_2 column"><strong>'      +
                                       'Vendedor: '                                                                                                                      +
                                        cod_vendedor + ' - ' + reporteVentasProductos[recorre].as_apell_nomb_vend                                                        +
                                       '</strong></td>'                                                                                                                  +
                                        '<td style="padding-right: 1px; text-align: left; color:#1ab394; " colspan="2" class="text-center1 fontsize_2 "><strong>'          +       
                                       'Cant. Total: '                                                                                                                   +
                                       cant_total_vend                                                                                                                   +
                                       '</td>'                                                                                                                           +                       
                                       '<td style="padding-right: 1px; text-align: left; color:#1ab394; " colspan="2" class="text-center1 fontsize_2 "><strong>'           +       
                                       'Monto Total: '                                                                                                                   +
                                       mto_total_vend                                                                                                                    +
                                       '</td>'                                                                                                                           +
                                      '</tr>';         
                             $('#listadoVtasProd tbody').append(header_vendedor); 
            cod_vendedor_ant = cod_vendedor;
          }

        var filaReporte = '<tr class="resaltador" >'                                                                                                              + 
                            '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                                                     +
                            reporteVentasProductos[recorre].as_desc_familia                                                                                       +
                            '</td>'                                                                                                                               +
                            '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                                                     +
                            desc_grupo                                                                                                                            + 
                            '</td>'                                                                                                                               +  
                            '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                                  +
                            cod_admin_artic + ' - ' + desc_admin_artic                                                                                            +
                            '</td>'                                                                                                                               +                                   
                            '<td style="padding-left: 1px; padding-right: 1px" class="text-center fontsize_2" >'                                                    + 
                            cant_vta_renglon                                                                                                                      +
                            '</td>'                                                                                                                               +
                            '<td style="text-align:center; padding-left: 1px; padding-right: 1px"  class="text-center fontsize_2">'                                 +
                            reporteVentasProductos[recorre].adec_porc_cant_venta                                                                                  +
                            '</td>'                                                                                                                               +
                            '<td style="text-align:center; padding-left: 1px; padding-right: 1px" class="text-center fontsize_2">'                                  +
                            mto_vta_renglon                                                                                                                       +
                            '</td>'                                                                                                                               +
                            '<td style="text-align:center; padding-left: 1px; padding-right: 1px"class="text-center fontsize_2">'                                   +
                            reporteVentasProductos[recorre].adec_porc_mto_venta                                                                                   +
                            '</td>'                                                                                                                               +
                          '</tr>';                                                                                                                        
                            $('#listadoVtasProd tbody').append(filaReporte); 

      if ( recorre == ( reporteVentasProductos.length - 1 ) ) {
            var fila_total =  '<tr style="border-top:2px solid #1ab394">'                                                                                         +  
                                '<td style="color:#1ab394;" class="text-center fontsize_2">'                                                                        +
                                  '<strong>'                                                                                                                      +
                                  'Total Vendido: '                                                                                                               +
                                  '</strong>'                                                                                                                     +
                                '</td>'                                                                                                                           +
                                '<td style="padding-left: 25px; padding-right: 1px; text-align: center; color:#1ab394;" class="fontsize_2" >'                       +
                                '</td>'                                                                                                                           +
                                '<td style="padding-left: 25px; padding-right: 1px; text-align: center; color:#1ab394;" class="fontsize_2" >'                       +
                                '</td>'                                                                                                                           +
                                '<td style="text-align: center; padding-left: 1px; padding-right: 1px; color:#1ab394;" class="text-center fontsize_2">'             +
                                  '<strong>'                                                                                                                      +
                                   cant_vta_gral                                                                                                                  +
                                  '</strong>'                                                                                                                     +
                                '</td>'                                                                                                                           +
                                '<td style="padding-left: 25px; padding-right: 1px; text-align: center; color:#1ab394;" class="fontsize_2" >'                       +
                                '</td>'                                                                                                                           +
                                '<td style="text-align: center; padding-left: 1px; padding-right: 1px; color:#1ab394;" class="text-center fontsize_2" >'            +
                                  '<strong>'                                                                                                                      +
                                  mto_vta_gral                                                                                                                    +
                                  '</strong>'                                                                                                                     +
                                '</td>'                                                                                                                           +
                                '<td style="padding-left: 25px; padding-right: 1px; text-align: center; color:#1ab394;" class="fontsize_2" >'                       +
                                '</td>'                                                                                                                           +
                              '</tr>';
                            $('#listadoVtasProd tbody').append(fila_total); 
        } //recorre cantidad filas para total
      } //cierra else de if(window.matchMedia('(max-width: 768px)').matches)
    }// cierra for
    ocultarIconoRep();
  } // cierra llamada a .post
  );
} //cierra función 

