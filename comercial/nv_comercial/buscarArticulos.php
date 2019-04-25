  <?php

    include("../../includes/iniciar_sesion.php");
    include("../../includes/conexionWS_ajax.php");

    $modulo = 7;

    if (isset($_POST['cod_articulo'])) {
      $codigoArticulo = $_POST['cod_articulo'];
    }else{
      $codigoArticulo = '33245';
      // CANDIDATO ArticCodAdmin 12294317
    }

    if (isset($_POST['desc_articulo'])) {
      $descripcionArticulo = $_POST['desc_articulo']; 
    }else{
      $descripcionArticulo = '';
    }

    if (isset($_POST['cod_familia'])) {
      $familiaSeleccionada = $_POST['cod_familia'];
    }else{
      $familiaSeleccionada = '0';
    }
    
    if (isset($_POST['cod_grupo'])) {
      $grupoSeleccioado = $_POST['cod_grupo']; 
    }else {
      $grupoSeleccioado = '0';
    }
    
    if (isset($_POST['cod_cliente'])) {
      $codigoCliente = $_POST['cod_cliente']; 
    }else {
      $codigoCliente = '0';
    }

    $comandoArticulos = "BUSCARARTICULOS(" . $codigoArticulo . "," . $descripcionArticulo . "," . $familiaSeleccionada . "," . $grupoSeleccioado . "," . $codigoCliente .  ")"; 
    $resultadoArt     = conexionWS ( $modulo , $comandoArticulos );

    echo json_encode($resultadoArt);

    //var_dump($resultadoArt);
?>
