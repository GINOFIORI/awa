<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>NeoSistemas SRL | Cuenta Corriente Clientes</title>

    <link rel="stylesheet" type="text/css" href="../../css/estilo.css">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.css" rel="stylesheet">

    <!-- Hoja de estilo de cuenta corriente -->
    <link href="../../css/ctacte-style.css" rel="stylesheet">

    <link href="../../css/custom.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../css/font-awesome.css" rel="stylesheet" type="text/css">

    <link href="../../css/input-decorations.css" rel="stylesheet">
    <link href="../../css/resaltador.css" rel="stylesheet">    
    <link href="../../css/estiloCtaCte.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/jquery-1.10.2.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../css/all.min.css">
    <script type="text/javascript" src="../../js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="../../js/jszip.min.js"></script>

    
    <script src="../../js/funcionesComunes.js"></script>
    <script src="../../ventas/js_ventas/funcionesCtaCte.js"></script>
    <script type="text/javascript"></script>

    <script type="text/javascript">
      
    $.post("../../ventas/nv_ventas/recuperarCtaCte.php", 
      { cod_cliente: '100' , 
        fecha_desde: '2018-01-09' , 
        fecha_hasta: '2018-01-31' ,
        excl_anul:   '0' ,
        orden:       '1',
        excl_cancel: '0' }, 
      function(data) {
        ctacte = JSON.parse(data);

        
        var cuentaCorriente = ctacte.results_row;

        contador = 0;

        for (var recorre in cuentaCorriente ) {

          if ( cuentaCorriente[recorre].adec_monto_haber == 0 ){
            var monto_haber = '';
          }else{
            var monto_haber      = formatearNumero ( cuentaCorriente[recorre].adec_monto_haber );
            var monto_debe_haber = formatearNumero ( cuentaCorriente[recorre].adec_monto_haber * -1 );
            if (contador==0){
              alert('campo de la tabla: ' + cuentaCorriente[recorre].adec_monto_haber );
              alert('monto_haber:' + monto_haber );
              alert('monto_debe_haber:' + monto_debe_haber );
              contador++;
            }
          };
        }

      }
    )


    </script>

  <style>
    .modal-header, h4, .close {
        background-color: #2F4050;
        color:white !important;
        text-align: center;
        font-size: 10pt;

    }
    .modal-footer {
        background-color: #f9f9f9;
    }
  </style>
        
  </head>
  <body id="" style="">

      
</body>
</html>