<?php
	$_SERVER['NO_CHECK'] = 1;
	require_once('../../init/init.php');
	echo 1308097048-time(),'</br>';
	dao_get_vender_vender_key::excute();
	dao_vender::get_vender_key();
	$codeAnt->debug->displayProfile();
?>