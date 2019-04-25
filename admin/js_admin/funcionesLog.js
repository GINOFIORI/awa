function mostrarIconoLog() {
  document.body.style.cursor='wait';
  document.getElementById("cargandoLog").style.visibility = 'visible';
}
function ocultarIconoLog() {
  document.body.style.cursor='default';
  document.getElementById("cargandoLog").style.visibility = 'hidden';
}

function recuperarLog (IdCliente,UrlCliente,ServidorCliente,BDCliente,IdEmpCliente,IdSucCliente,CaminoAwaDownload,CaminoAwaBR,UsuarioAdm,PassAdm,mostrarPass) {

	var fechaDesde = document.getElementById("fechaDesde").value;
  var fechaHasta = document.getElementById("fechaHasta").value;
  var usuario    = document.getElementById("usuarioBusqueda").value;
  var rolUsuario = document.getElementById("roles").value;

  if (mostrarPass == null){
    var revelarPass = 0;
  }else {
    if (mostrarPass == 1) {
      var revelarPass = 1;
    }else{
      var revelarPass = 0;
      alert("La constraseña ingresada es incorrecta.");
    }
  }

  $("#resultadoLog tbody tr").remove();

  mostrarIconoLog();

  $.post("../awa/admin/nv_admin/recuperarLog.php", 
  { fecha_desde:       fechaDesde,
    fecha_hasta:       fechaHasta,
    usuario_busqueda:  usuario,
    rol_usuario:       rolUsuario,
    IdCliente:         IdCliente, 
    UrlCliente:        UrlCliente,
    ServidorCliente:   ServidorCliente,
    BDCliente:         BDCliente,
    IdEmpCliente:      IdEmpCliente,
    IdSucCliente:      IdSucCliente,
    CaminoAwaDownload: CaminoAwaDownload,
    CaminoAwaBR:       CaminoAwaBR,
    UsuarioAdm:        UsuarioAdm,
    PassAdm:           PassAdm },//cierra $.post
	  function(data) {
    resultado = JSON.parse(data);
    ocultarIconoLog();
      
      if ( resultado.results_row.as_error_msg ){
        alert ("Error en la conexión con el servidor del cliente: " + resultado.results_row.as_error_msg ); 
        ocultarIconoLog();     
        return;
      }
      if ( resultado.results_row.as_return_msg ){
        alert ("Alerta!: " + resultado.results_row.as_return_msg );   
        ocultarIconoLog();
        return;
      }

      if (resultado.results_row.length>0){
        //////////////////// ES ARRAY //////////////////////////
        var listaresultado = resultado.results_row
      }else{
        ///////////////// TRANSFORMAR EN ARRAY /////////////////
        var listaresultado = [];
        var object = new Object();
        listaresultado[0] = object;
        $.each(resultado.results_row, function(key, value) {
          listaresultado[0][key] = value
        });
      }

      for (var recorre in listaresultado) {

        if (listaresultado[recorre].sisauditawarolusr == 1){
          $rolUsuario = 'Usuario Allways ERP';
        }else if (listaresultado[recorre].sisauditawarolusr == 2){
          $rolUsuario = 'Cliente';
        }else if (listaresultado[recorre].sisauditawarolusr == 3){
          $rolUsuario = 'Vendedor';
        }else  if (listaresultado[recorre].sisauditawarolusr == 4){
          $rolUsuario = 'Proveedor';
        }

        var opciones = { year: 'numeric', month: 'numeric', day: 'numeric' , hour: "2-digit" , minute: "2-digit" , second:"2-digit"  };
        var fechaHoraLog    = new Date(listaresultado[recorre].sisauditawafec)
          .toLocaleDateString('es',opciones)

        var fechaHoraLogString      = encodeURI(listaresultado[recorre].sisauditawafec.substr(0,23));
        var servidorCliente         = encodeURI(ServidorCliente);
        var caminoAwaBR             = encodeURI(CaminoAwaBR);      

        var onClickRecuperaInfoLog_1  = "onClick=recuperarInfoLog("               + "'"    +
                                        listaresultado[recorre].sisauditawaid     + "','"  +
                                        listaresultado[recorre].sisauditawaipusr  + "','"  +
                                        fechaHoraLogString                        + "','"  +
                                        IdCliente                                 + "','"  +
                                        UrlCliente                                + "','"  +
                                        servidorCliente                           + "','"  +
                                        BDCliente                                 + "','"  +
                                        IdEmpCliente                              + "','"  +
                                        IdSucCliente                              + "','"  +
                                        CaminoAwaDownload                         + "','"  +
                                        caminoAwaBR                               + "','"  +
                                        UsuarioAdm                                + "','"  +
                                        PassAdm                                   + "','"  +
                                        1                                         + "');"


        var onClickRecuperaInfoLog_2 = "onClick=recuperarInfoLog("                + "'"    +
                                        listaresultado[recorre].sisauditawaid     + "','"  +
                                        listaresultado[recorre].sisauditawaipusr  + "','"  +
                                        fechaHoraLogString                        + "','"  +
                                        IdCliente                                 + "','"  +
                                        UrlCliente                                + "','"  +
                                        servidorCliente                           + "','"  +
                                        BDCliente                                 + "','"  +
                                        IdEmpCliente                              + "','"  +
                                        IdSucCliente                              + "','"  +
                                        CaminoAwaDownload                         + "','"  +
                                        caminoAwaBR                               + "','"  +
                                        UsuarioAdm                                + "','"  +
                                        PassAdm                                   + "','"  +
                                        2                                         + "');"


        if (revelarPass == 0 ) {

          var filaDetalle = '<tr style="overflow-y: scroll" href="#"  data-toggle="modal" data-target="#miModal" class="resaltador">'                              +
                            '<td class="text-center fontsize descarto">'                                                                                           +
                              listaresultado[recorre].sisauditawaid                                                                                                +    
                            '</td>'                                                                                                                                +
                            '<td class="text-center fontsize descarto">'                                                                                           + 
                            listaresultado[recorre].sisauditawaipusr                                                                                               + 
                            '</td>'                                                                                                                                +
                            '<td class="text-center fontsize">'                                                                                                    +
                            fechaHoraLog                                                                                                                           +
                            '</td>'                                                                                                                                +
                            '<td class="text-center fontsize">'                                                                                                    +
                            'null'                                                                                                                                 +
                            '</td>'                                                                                                                                +
                            '<td class="text-center fontsize">'                                                                                                    +                         
                            listaresultado[recorre].sisauditawausr                                                                                                 +
                            '</td>'                                                                                                                                +     
                            '<td class="text-center fontsize descarto"><i class="fa fa-lock" aria-hidden="true"></i>'                                              +
                            '</td>'                                                                                                                                +                                                                       
                            '<td class="text-center fontsize">'                                                                                                    +
                            $rolUsuario                                                                                                                            +
                            '</td>'                                                                                                                                +
                            '<td style="width: 15px"><button style="width:38; height:34" class="btn btn-default" href="#" data-toggle="modal"' + onClickRecuperaInfoLog_1 + '> <i class="fa fa-share-square" aria-hidden="true"></i></button>'  +
                            '</td>'                                                                                                                                +
                            '<td style="width: 15px"><button style="width:38; height:34" class="btn btn-default" data-toggle="modal"' + onClickRecuperaInfoLog_2 + '> <i class="fa fa-download" aria-hidden="true"></i></button>'      +
                            '</td>'                                                                                                                                +                                                                                                              
                          '</tr>';
                          $('#resultadoLog tbody').append(filaDetalle); 
        }else if (revelarPass == 1 ) {

             var filaDetalle = '<tr style="overflow-y: scroll" href="#"  data-toggle="modal" data-target="#miModal" class="resaltador">'                           +
                            '<td class="text-center fontsize descarto">'                                                                                           +
                              listaresultado[recorre].sisauditawaid                                                                                                +    
                            '</td>'                                                                                                                                +
                            '<td class="text-center fontsize descarto">'                                                                                           + 
                            listaresultado[recorre].sisauditawaipusr                                                                                               + 
                            '</td>'                                                                                                                                +
                            '<td class="text-center fontsize">'                                                                                                    +
                            fechaHoraLog                                                                                                                           +
                            '</td>'                                                                                                                                +
                            '<td class="text-center fontsize">'                                                                                                    +
                            'null'                                                                                                                                 +
                            '</td>'                                                                                                                                +
                            '<td class="text-center fontsize">'                                                                                                    +                         
                            listaresultado[recorre].sisauditawausr                                                                                                 +
                            '</td>'                                                                                                                                +     
                            '<td class="text-center fontsize descarto">'                                                                                           +
                            listaresultado[recorre].sisauditawapassusr                                                                                             +
                            '</td>'                                                                                                                                +                                                                       
                            '<td class="text-center fontsize">'                                                                                                    +
                            $rolUsuario                                                                                                                            +
                            '</td>'                                                                                                                                +
                            '<td style="width: 15px"><button style="width:38; height:34" class="btn btn-default" data-toggle="modal"' + onClickRecuperaInfoLog_1 + '> <i class="fa fa-share-square" aria-hidden="true"></i></button>'  +
                            '</td>'                                                                                                                                +
                            '<td style="width: 15px"><button style="width:38; height:34" class="btn btn-default" data-toggle="modal" ' + onClickRecuperaInfoLog_2 + '> <i class="fa fa-download" aria-hidden="true"></i></button>'      +
                            '</td>'                                                                                                                                +                                                                                                                                                                                                                                           +                                                                                                              
                          '</tr>';
                          $('#resultadoLog tbody').append(filaDetalle);  
         
        }       

    }//cierra for
  }//cierra function 
  
  )//cierra lista de parámetros del .post

} //cierra function recuperarLog

function recuperarInfoLog (awaId, ipVisitante, fechaHoraLog, IdCliente,UrlCliente,servidorCliente,BDCliente,IdEmpCliente,IdSucCliente,CaminoAwaDownload,caminoAwaBR,UsuarioAdm,PassAdm,comandoInfo ) {

  var fechaHoraLogString = decodeURI(fechaHoraLog);
  var servidorCliente    = decodeURI(servidorCliente);
  var caminoAwaBR        = decodeURI(caminoAwaBR); 

  mostrarIconoLog();

  $.post("../awa/admin/nv_admin/recuperarInfoLog.php", 
    { awaId:                 awaId, 
      IpVisitante:           ipVisitante,
      fechaHoraLog:          fechaHoraLogString,
      comandoInfo:           comandoInfo,
      IdCliente:             IdCliente, 
      UrlCliente:            UrlCliente,
      ServidorCliente:       servidorCliente,
      BDCliente:             BDCliente,
      IdEmpCliente:          IdEmpCliente,
      IdSucCliente:          IdSucCliente,
      CaminoAwaDownload:     CaminoAwaDownload,
      CaminoAwaBR:           caminoAwaBR,
      UsuarioAdm:            UsuarioAdm,
      PassAdm:               PassAdm },//cierra $.post
      function(data) {
      resultado = JSON.parse(data);

      if ( resultado.results_row.as_error_msg ){ 
        if ( resultado.results_row.an_error_id == awaId ) { 
          alert ("Error en la conexión con el servidor del cliente: " + resultado.results_row.as_error_msg ); 
          ocultarIconoLog();     
          return;
        }
      }

      if ( resultado.results_row.as_return_msg ){
        if ( resultado.results_row.an_mensaje_id == awaId ) {
          alert ("Alerta!: " + resultado.results_row.as_return_msg );   
          ocultarIconoLog();
          return;
        }
      }

      if (resultado.results_row.length>0){
        //////////////////// ES ARRAY //////////////////////////
        var listaresultado = resultado.results_row
      }else{
        ///////////////// TRANSFORMAR EN ARRAY /////////////////
        var listaresultado = [];
        var object = new Object();
        listaresultado[0] = object;
        $.each(resultado.results_row, function(key, value) {
          listaresultado[0][key] = value
        });
      }

      if ( comandoInfo == 1 ){

        var eventoOnclick = "recuperarInfoLog('"+ awaId + "','" + ipVisitante + "','" + fechaHoraLog + "','" + IdCliente + "','" + UrlCliente + "','" + encodeURI(servidorCliente) + "','" + BDCliente + "','" + IdEmpCliente + "','" +IdSucCliente + "','" + CaminoAwaDownload + "','" + encodeURI(caminoAwaBR) + "','" + UsuarioAdm + "','" + PassAdm + "','2')"

        document.getElementById('comandoRecibidoModal').setAttribute('onClick',eventoOnclick);

        for (var recorre in listaresultado) {

          var comandoRecibido = listaresultado[recorre].as_comando_recib;
          comandoRecibido = comandoRecibido.split([';']);

          for ( var recorre2 in comandoRecibido ) {
            nombreElemento = 'mostrarComando' + recorre2.toString();
            document.getElementById(nombreElemento).innerHTML  = comandoRecibido[recorre2];
          }

          $(".mostrarComando14").remove();

          $("#comando").modal("show")

        }

      }else{ 

          // AQUI ABRIREMOS UNA NUEVA VENTANA CON LOS DATOS QUE SE HAN DEVUELTO EN EL COMANDO...

          var tabla = '<table style="width:100%" id="datosRecibidos"><tr>'
          var nombresColumnas = Object.keys(listaresultado[0]);

          for (var recorre in nombresColumnas) {
            tabla += '<th>' + nombresColumnas[recorre] + '</th>';
          }
          var objetosdesconocidos = 0;
          for (var recorre in listaresultado) {
            var valores = Object.values(listaresultado[recorre]);
            tabla += '<tr>';
            for (var recorre2 in valores) {
              if ( typeof(valores[recorre2])==='object' ){
                if (  Object.values(valores[recorre2]) ){
                  tabla += '<td><i>null</i></td>';
                }else{
                  tabla += '<td><i>¡¡valor desconocido!!</i></td>';
                }
              }else{
                tabla += '<td>' + valores[recorre2] + '</td>';
              }
            }
            tabla += '</tr>';
          }

          tabla += '</tr></table>';

          var ventana = window.open("","_blank","width=800,height=600");

          if (!ventana) return false;

          var html = "";
          html += "<html><head>"
          html += "<button onclick='copiar()'>Copiar al portapapeles</button>"
          html += "</br>";
          html += "<style>table { border-collapse: collapse; width: 100%;}th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd;}tr:hover {background-color:#f5f5f5;}</style>"
          html +="</head><body>";
          html += tabla;
          html += "</body>";
          html += "<script>"                                                              +
                    "function copiar() {"                                                 +
                    "  var el = document.getElementById('datosRecibidos'); "              +
                    "  var body = document.body, range, sel;  "                           +
                    "  if (document.createRange && window.getSelection) { "               +
                    "    range = document.createRange(); "                                +
                    "    sel = window.getSelection(); "                                   +
                    "    sel.removeAllRanges(); "                                         +
                    "    try { "                                                          +
                    "      range.selectNodeContents(el); "                                +
                    "      sel.addRange(range); "                                         +
                    "    } catch (e) { "                                                  +
                    "      range.selectNode(el); "                                        +
                    "      sel.addRange(range); "                                         +
                    "    } "                                                              +
                    "  } else if (body.createTextRange) { "                               +
                    "    range = body.createTextRange(); "                                +
                    "    range.moveToElementText(el); "                                   +
                    "    range.select(); "                                                +
                    "  } "                                                                +
                    "  document.execCommand('copy'); "                                    +
                    "  alert('Texto copiado al portapapeles.'); "                         +
                    "} "                                                                  +
                  "</script>";
          html += "</html>";

          ventana.document.write(html);
      }

      ocultarIconoLog();

    }//cierra function(data)

  )//cierra.post

}//cierra function recuperarInfoLog

