<?php	

	if (isset($_POST['administradores'])){
		require_once("admin/nv_admin/admin_abm_administradores_ctrl.php");
	}elseif (isset($_POST['awaconfig'])) {
		require_once("admin/nv_admin/admin_abm_awaconfig_ctrl.php");
	}elseif (isset($_POST['log'])) {
		require_once("admin/ventanas/abm_log.php");
	}else{
		require_once("admin/nv_admin/admin_abm_administradores_ctrl.php");	
	}

?>