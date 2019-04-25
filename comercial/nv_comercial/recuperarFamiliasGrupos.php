<?php

  include("../../includes/iniciar_sesion.php");
  include("../../includes/conexionWS_ajax.php");
 
  $comandoFamilias    = "FAMILIAS()";
  $datosFamilias      = conexionWS ( $modulo , $comandoFamilias );      


  $comandoGrupos      = "GRUPOS(0)";
  $datosGrupos        = conexionWS ( $modulo , $comandoGrupos ); 

  $DatosGruposCodFam  = array();
  $DatosGruposCodGrp  = array();
  $DatosGruposDescGrp = array();
  $DatosGruposActGrp  = array();

  $recorre = 0;

  $modulo = 7;

  foreach($datosGrupos->results_row as $item){
    $DatosGruposCodFam[$recorre]  = (integer) $item->familartcod;
    $DatosGruposCodGrp[$recorre]  = (integer) $item->gruposartcod;
    $DatosGruposDescGrp[$recorre] = (string)  $item->gruposartdesc;
    $DatosGruposActGrp[$recorre]  = (integer) $item->gruposartactivo;
    $recorre++; 
  }

?>