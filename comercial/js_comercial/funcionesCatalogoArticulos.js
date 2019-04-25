function mostrarIconoCat() {
  document.body.style.cursor='wait';
  document.getElementById("cargandoCatalogo").style.visibility = 'visible';
}
function ocultarIconoCat() {
  document.body.style.cursor='default';
  document.getElementById("cargandoCatalogo").style.visibility = 'hidden';
}

function checkbox_familias(value)
{
  if(value==true)
  {
    // habilitamos
    document.getElementById("ddlb_familias").disabled=false;
    document.getElementById("cbx_grupos").disabled=false;
  }else if(value==false){
    // deshabilitamos
    document.getElementById("ddlb_familias").disabled=true;
    document.getElementById("ddlb_grupos").disabled=true;
    document.getElementById("cbx_grupos").checked=false;
    document.getElementById("cbx_grupos").disabled=true;
  }
}


function checkbox_grupos(value)
{
  if(value==true)
  {
    document.getElementById("ddlb_grupos").disabled=false;
  }else if(value==false){
    document.getElementById("ddlb_grupos").disabled=true;
  }
}

//armado de la ventana modal con los precios..................//

function recuperarArticulos(rolLogin)
{
  if (document.getElementById("ddlb_familias").disabled==true) {
      var codFamilia   = '';
  }else{
      var codFamilia   = document.getElementById("ddlb_familias").value;
  }

  if (document.getElementById("ddlb_grupos").disabled==true) {
      var codGrupo   = '';
  }else{
      var codGrupo     = document.getElementById("ddlb_grupos").value;
  }


  var codArticulo  = document.getElementById("codArticulo").value;
  var descArticulo = document.getElementById("descripArticulo").value;
  var rol          = rolLogin;

  mostrarIconoCat();

   $.post("../../comercial/nv_comercial/buscarArticulos.php", 
    { cod_articulo:  codArticulo  , 
      desc_articulo: descArticulo , 
      cod_familia:   codFamilia ,
      cod_grupo:     codGrupo } ,
    function(data) {
      catalogo = JSON.parse(data);
      ocultarIconoCat();
      if ( catalogo.results_row.as_error_msg_js ){
        alert ("Error en la conexión con el servidor del cliente: " + catalogo.results_row.as_error_msg_js );
        $("#resultadoBusqueda tbody tr").remove();
        ocultarIconoCat();
        return;
      }
      if ( catalogo.results_row.as_return_msg ){
        alert ("Alerta!: " + catalogo.results_row.as_return_msg_js );
        $("#resultadoBusqueda tbody tr").remove();
        ocultarIconoCat();
        return;
      }

      if (catalogo.results_row.length>0){
        ///////////////////////////// ES ARRAY //////////////////////////////////
        var catalogoArticulos = catalogo.results_row
      }else{
        //////////////////////// TRANSFORMAR EN ARRAY ///////////////////////////
        var catalogoArticulos = [];
        var renglon = new Object();
        catalogoArticulos[0] = renglon;
        $.each(catalogo.results_row, function(key,value){
          catalogoArticulos[0][key] = value
        });
      }

      //<div class="contenedor-modal">
      $("#resultadoBusqueda tbody tr").remove();


      for (var recorre in catalogoArticulos) {

        var descFamilia  = encodeURI(catalogoArticulos[recorre].familartdesc );
        var descGrupo    = encodeURI(catalogoArticulos[recorre].gruposartdesc );
        var descArticulo = encodeURI(catalogoArticulos[recorre].articdesc );

        var precio_final   = parseFloat(catalogoArticulos[recorre].artic_prec_final);
        var precio_final   = precio_final.toFixed(2);


        var onClickConsultarArticulo  =  "onClick=consultarArticulo("                  + "'"    +
                                        descFamilia                                    + "','"  +  
                                        descGrupo                                      + "','"  +  
                                        catalogoArticulos[recorre].articcodadmin       + "','"  +
                                        descArticulo                                   + "','"  +
                                        catalogoArticulos[recorre].articprecvta        + "','"  +
                                        catalogoArticulos[recorre].articprecvta2       + "','"  +
                                        catalogoArticulos[recorre].articprecvta3       + "','"  +
                                        catalogoArticulos[recorre].articprecvta4       + "','"  +
                                        precio_final                                   + "','"  +
                                        catalogoArticulos[recorre].artic_prec_final_2  + "','"  +
                                        catalogoArticulos[recorre].artic_prec_final_3  + "','"  +
                                        catalogoArticulos[recorre].artic_prec_final_4  + "');"

        if (rol == 2) {  

              var filaDetalle = '<tr style="overflow-y: scroll" href="#"  data-toggle="modal" data-target="#miModal" class="resaltador"' + onClickConsultarArticulo + '>'        +
                                  '<td class="text-center consultaArticulo">'                                                                    +
                                    catalogoArticulos[recorre].familartdesc                                                                      +    
                                  '</td>'                                                                                                        +
                                  '<td class="text-center consultaArticulo">'                                                                    +
                                  catalogoArticulos[recorre].gruposartdesc                                                                       +
                                  '</td>'                                                                                                        +
                                  '<td class="text-center consultaArticulo">'                                                                    +
                                  catalogoArticulos[recorre].articcodadmin + ' - ' + catalogoArticulos[recorre].articdesc                        +
                                  '</td>'                                                                                                        +
                                  '<td class="text-center descarto consultaArticulo">'                                                           +
                                  catalogoArticulos[recorre].articprecvta                                                                        +
                                  '</td>'                                                                                                        +                                                                       
                                  '<td class="text-center descarto consultaArticulo">'                                                           +
                                  precio_final                                                                                                   +
                                  '</td>'                                                                                                        +                                                                                                            
                                '</tr>';
                              $('#resultadoBusqueda tbody').append(filaDetalle);  

        } else {
           var filaDetalle = '<tr style="overflow-y: scroll" href="#"  data-toggle="modal" data-target="#miModal" class="resaltador" ' + onClickConsultarArticulo + '>'         +
                                '<td class="text-center consultaArticulo">'                                                                    +
                                  catalogoArticulos[recorre].familartdesc                                                                      +    
                                '</td>'                                                                                                        +
                                '<td class="text-center consultaArticulo">'                                                                    +
                                catalogoArticulos[recorre].gruposartdesc                                                                       +
                                '</td>'                                                                                                        +
                                '<td class="text-center consultaArticulo">'                                                                    +
                                catalogoArticulos[recorre].articcodadmin + ' - ' + catalogoArticulos[recorre].articdesc                        +
                                '</td>'                                                                                                        +
                                '<td class="text-center descarto consultaArticulo">'                                                           + 
                                  catalogoArticulos[recorre].articprecvta                                                                      +
                                '</td>'                                                                                                        +
                                '<td class="text-center descarto consultaArticulo">'                                                           +
                                  catalogoArticulos[recorre].articprecvta2                                                                     +
                                '</td>'                                                                                                        +
                                '<td class="text-center descarto consultaArticulo">'                                                           +
                                 catalogoArticulos[recorre].articprecvta3                                                                      +
                                '</td>'                                                                                                        +
                                '<td class="text-center descarto consultaArticulo">'                                                           +
                                 catalogoArticulos[recorre].articprecvta4                                                                      +
                                '</td>'                                                                                                        +
                                '<td  style="display: none;">'                                                                                 +
                                 catalogoArticulos[recorre].artic_prec_final                                                                   +
                                '</td>'                                                                                                        +
                                '<td  style="display: none;">'                                                                                 +
                                catalogoArticulos[recorre].artic_prec_final_2                                                                  +
                                '</td>'                                                                                                        +
                                '<td style="display: none;">'                                                                                  +
                                  catalogoArticulos[recorre].artic_prec_final_3                                                                +
                                '</td>'                                                                                                        +
                                 '<td style="display: none;">'                                                                                 +
                                  catalogoArticulos[recorre].artic_prec_final_4                                                                +
                                '</td>'                                                                                                        +
                              '</tr>';
                            $('#resultadoBusqueda tbody').append(filaDetalle);
                             
                }
          }                                                    
  });
}

function consultarArticulo(familia,grupo,codArticulo,descArticulo,precio,precio_2,precio_3,precio_4,precio_final,precio_final_2,precio_final_3,precio_final_4) {

  var desc_familia   =  decodeURI(familia);
  var desc_grupo     =  decodeURI(grupo);
  var desc_articulo  =  decodeURI(descArticulo);

  var precio_final_2   = parseFloat(precio_final_2);
  var precio_final_2   = precio_final_2.toFixed(2);

  var precio_final_3   = parseFloat(precio_final_3);
  var precio_final_3   = precio_final_3.toFixed(2);

  var precio_final_4   = parseFloat(precio_final_4);
  var precio_final_4   = precio_final_4.toFixed(2);

  document.getElementById("filaFamilia").innerHTML         = (desc_familia);
  document.getElementById("filaGrupo").innerHTML           = (desc_grupo);
  document.getElementById("filaArticulo").innerHTML        = (codArticulo) + ' - ' + (desc_articulo);
  document.getElementById("filaPrecioVenta1").innerHTML    = (precio);
  document.getElementById("filaPrecioFinal1").innerHTML    = (precio_final);
  document.getElementById("filaPrecioVenta2").innerHTML    = (precio_2);
  document.getElementById("filaPrecioFinal2").innerHTML    = (precio_final_2);
  document.getElementById("filaPrecioVenta3").innerHTML    = (precio_3);
  document.getElementById("filaPrecioFinal3").innerHTML    = (precio_final_3);
  document.getElementById("filaPrecioVenta4").innerHTML    = (precio_4);
  document.getElementById("filaPrecioFinal4").innerHTML    = (precio_final_4);

}



                         
 