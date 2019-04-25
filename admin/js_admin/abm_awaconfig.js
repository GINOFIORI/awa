
function test(IdCliente,UrlCliente,ServidorCliente,BDCliente,IdEmpCliente,IdSucCliente,CaminoAwaDownload,CaminoAwaBR,UsuarioAdm,PassAdm){

  var nombre = 'testing_' + IdCliente;
  var icono = document.getElementById(nombre);
  icono.classList.add("fa-spin");


  $.post("../awa/admin/nv_admin/test.php", 
    { IdCliente:         IdCliente, 
      UrlCliente:        UrlCliente,
      ServidorCliente:   ServidorCliente,
      BDCliente:         BDCliente,
      IdEmpCliente:      IdEmpCliente,
      IdSucCliente:      IdSucCliente,
      CaminoAwaDownload: CaminoAwaDownload,
      CaminoAwaBR:       CaminoAwaBR,
      UsuarioAdm:        UsuarioAdm,
      PassAdm:           PassAdm },
    function(data) {

      console.log('Datos devueltos conexionWS_ajax_admin gino: ' + data);
      
      resultado = JSON.parse(data);
      
      if ( resultado.results_row.as_error_msg ){
        icono.classList.remove("fa-spin");
        alert ("Error en la conexión con el servidor del cliente: " + resultado.results_row.as_error_msg_js );      
        return;
      }
      if ( resultado.results_row.as_return_msg ){
        icono.classList.remove("fa-spin");
        alert ("Alerta!: " + resultado.results_row.as_return_msg_js );   
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

      icono.classList.remove("fa-spin");

    }
  )

}