<?php

session_start();

if ( isset ( $_SESSION["admin"] )){
	require_once("admin/nv_admin/admin_ctrl.php");
}else{
	?>
	<script>
		window.location.href='index.php';
	</script>
	<?php
}


?>