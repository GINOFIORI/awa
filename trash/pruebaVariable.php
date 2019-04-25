<?php
            
echo '<head>
            
              <title>'.$_SERVER[PHP_SELF].'</title>
            
      </head>
            
      <html>
            
      <body>';
$variable_php="neosistemas";
echo '<script languaje="JavaScript">
            
      var varjs="'.$variable_php.'";
            
      alert(varjs);
            
</script>';
echo "<a href=$_SERVER[PHP_SELF]>Recargar la Página</a>";
            
echo '</body>
            
      </html>';
?>