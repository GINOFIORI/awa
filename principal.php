
<?php 

include ("includes/iniciar_sesion.php");
include ("includes/menu/valores_menu_principal.php");
include ("includes/descrip_roles.php");
/* este es un cambio prueba*/
$recorre = 0;

?>

<!DOCTYPE HTML>

<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Principal</title>

<link rel="stylesheet" type="text/css" href="css/estilo.css" />
<link href="css/jquery.gritter.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="css/dashboard.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/animate.css" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

</head>

<body>

<div id="wrapper" style="padding-right: 0; margin-right: 0;">
  <nav class="navbar-default navbar-static-side" role="navigation" style="height: 100%; overflow-y: scroll;">
    <div class="sidebar-collapse">
      <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
          <div class="dropdown profile-element"> 
            <span style="text-align: center;">
              <img src="img\allways.png" alt="Allways ERP" width="183" height="51"/>
              <div>
              <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="vertical-align: middle;">
                <span class="block m-t-xs" style="font-size: 14pt;"><strong class="font-bold"><?php echo $_SESSION["DescripcionEmp"];?></strong></span>  
                <span class="block m-t-xs" style="line-height: 16pt;"> <strong class="font-bold"><?php echo $_SESSION['datosLogin'];?></strong></span>
                <span class="text-muted text-xs block" style="line-height: 20pt; font-size: 10pt;"><?php echo $descrip_roles[$_SESSION["rol"]];?><b class="caret"></b></span> 
              </a>
              <ul class="dropdown-menu animated fadeInLeft m-t-xs">
                <li><a href="profile.php"><i class="fa fa-user-circle"></i> Perfil</a></li>
                <li><a href="cerrar_sesion.php"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
              </ul>
              </div>
            </span>
          </div>
        </li>
        <div class="navbar-header soloMobile" style="margin-top: 10px;">
          <button type="button" id="menu" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="border-color: #1ab394; background-color: #1ab394 !important;border-width: 2px; padding-top: 8px; padding-bottom: 3px;">
            <i class="fa fa-bars" aria-hidden="true" style="font-size: 13pt;"> Menú</i>
          </button>
        </div>
        <div class="collapse navbar-collapse soloMobile animated fadeInRight m-t-xs" id="myNavbar" style="border-color: #1ab394 !important;">
          <li class="active">
            <?php 
            foreach ($menu_principal as $key => $item ) {
            $recorre++;
            ?>
            <div class="panel panel-default " >
              <div class="panel-heading" >
                <h4 class="panel-title">
                  <i class="<?php echo $menu_principal_iconos[$key]; ?>" aria-hidden="true" style="vertical-align: -3px;"></i> <a  data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $recorre; ?>" class="nombreMenu" style="vertical-align: middle; display: block;"><?php echo $key; ?></a>
                </h4>
              </div>
              <div id="collapse<?php echo $recorre; ?>" class="panel-collapse collapse">
              <?php
                foreach ( $item as $key2 => $item2 ) {
              ?>
                <div class="panel-body">
                  <ul style="list-style: none; padding-left: 1px; vertical-align: middle;">
                    <li>
                      <i class="fa fa-caret-right" style="vertical-align: inherit !important;"></i>
                      <a <?php if($item2==''){echo "style='color:lightgrey !important; cursor: context-menu;'";}; ?> href="#ancla" class="ancla" style="font-size:11pt !important;" OnClick="cargarModulo('<?php echo $item2 ?>')">
                          <?php echo $key2;?>
                      </a>
                    </li>
                  </ul>
                </div>
              <?php } ?>
              </div>
            </div>
            <?php } ?>
            </li> <!--aca cierra li active-->
          </div>
       </ul>
    </div> 
  </nav>
</div>

<div id="page-wrapper" class="gray-bg dashbard-1">
  <div class="container-fluid">
    <div class="row border-bottom" id="page-wrapper-header" >
      <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <ul class="masthead-nav navbar-right" style="list-style: none;">
          <li><span class="Estilo3"><b>Allways ERP Software de Gesti&oacute;n para Empresas</b></span></li>
          <li style="float: right;"><span class="Estilo3"><b>M&oacute;dulo de Acceso Web</b></span></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="embed-container"> 
    <a id="ancla">
      <iframe id="espera" name="espera" frameborder="0" height="100%" width="100%" style="display: none" src="cargando.html" ></iframe>
      <iframe id="no_disponible" name="no_disponible" frameborder="0" height="100%" width="100%" style="display: none" src="includes/no_disponible.html" ></iframe>
      <iframe id="content" name="content" frameborder="0" height="100%" width="100%" style="overflow: auto;" >Su navegador no soporta el contenido de esta p&aacute;gina </iframe>
    </a>
  </div>
  
</div>

<script type="text/javascript">

function cargarModulo(elemento){

 /* window.open(elemento,"_self"); */
  
  if( elemento == '' || elemento == null ){
    $("#espera").hide();
    $("#content").show();
  }else{
    $("#espera").show();
    $("#content").hide();
    $("#content").attr('src',elemento);
    document.getElementById('content').onload = function() {
        $("#content").fadeIn(1000);
        $("#espera").fadeout(1000);
    }
  }
 
}

  function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e10; i++) {
      if ((new Date().getTime() - start) > milliseconds){
        break;
      }
    }
  }

</script>

</body>
</html>