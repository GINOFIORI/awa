<style type="text/css" name="estilo-para-arreglar-efecto-visual-cuando-muestra-modal">
  @media (max-width: 768px) {
    .padMobile {
      padding-left: 15px !important;
    }
  }
</style>
<div class="header" style="padding-bottom: 10px !important; background-color: #f8f8f8; border-color: #e7e7e7;">
  <div class ="container-fluid">
    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-6">
      <div class="navbar-header">
        <a class="img-responsive" style="margin: 0 auto; padding-top: 5px;" href=""><img src="img/allways.png" alt="Allways ERP" width="183" height="51" /></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-4 col-lg-6">
      <ul class="nav masthead-nav" style="list-style:none">
        <li style="" class="descartoWeb"><a href="" style="font-size: 13px; margin-top: 5px;font-weight: bold; color: #2b6ba2""> <i class="fa fa-user-circle"></i> <?PHP echo $_SESSION['datosLogin']; ?> </a></li>
        <li><span class="Estilo3"><b>Allways ERP Software de Gesti&oacute;n de Empresas</b></span></li>
        <li><span class="Estilo3 descarto"><b>M&oacute;dulo de Acceso Web - Administración</b></span></li>
        <li><a href="http://www.allwayserp.com.ar" target="_blank"><span class="Estilo3 descarto"><b>www.allwayserp.com.ar</b></span></a></li>
      </ul>
    </div>
  </div>
</div>

<div id="navbar" style="background-color: #a5bfd5">
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="form" name="formularioAdmin">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle " data-toggle="collapse" data-target="#myNavbar" style="border-color: #a5bfd5;background-color: #a5bfd5; border-width: 2px; padding-top: 3px; padding-bottom: 3px">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="button"><input type="submit" name="administradores" value = "Administradores" style="border:none; outline: none; outline-width: 0; background-color: transparent; padding: 15px 15px 15px 15px; border:0; font-weight: bold; color: #2b6ba2"></li>
        <li class="button"><input type="submit" name="awaconfig"       value = "Configuración de conexiones" style="border:none; outline: none; outline-width: 0; background-color: transparent; padding: 15px 15px 15px 15px; border:0; font-weight: bold; color: #2b6ba2"></li>
        <li class="button"><input type="submit" name="log"       value = "Log" style="border:none; outline: none; outline-width: 0; background-color: transparent; padding: 15px 15px 15px 15px; border:0; font-weight: bold; color: #2b6ba2"></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li style="padding-right: 10px" class="padMobile"><a href="cerrar_sesion.php" style=" border:0; color: #2b6ba2"><span class="button glyphicon glyphicon-log-in"></span> Cerrar Sesión</a></li>
    </div>
  </form>
</div>