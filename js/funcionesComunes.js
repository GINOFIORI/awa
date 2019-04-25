function formatearFecha ( fechaBD ) {
	// ESTA FUNCION RECIBE UNA FECHA EN EL FORMATO QUE SE OBTIENE DESDE LA BASE DE DATOS Y LA DEVUELVE TRANSFORMADA EN FORMATO DE FECHA EN ESPAÑOL

  if ( typeof ( fechaBD ) == 'string' ) {
    var fechaSinHora = fechaBD.substr(0,10);
    fechaSinHora = fechaSinHora.replace(/-/g, '\/').replace(/T.+/, '');
  }
  
  var fecha = new Date(fechaSinHora);

  if ( fecha == "Invalid Date"){
    return '';
  }else{
    return fecha.toLocaleDateString("es-ES");
  };

}

function formatearNumero ( numero , decimales = 2 ) {

  var numeroFormateado = parseFloat(numero);
  numeroFormateado     = numeroFormateado.toFixed(decimales);

  return numeroFormateado.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

}