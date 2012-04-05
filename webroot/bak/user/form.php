<?php
	require_once('../../init/init.php');


	$method = $codeAnt->input->get('method', 2);

	switch($method){
		case 'add':
			$data[0]['name'] = "";
			$data[0]['memo'] = "";
			$data[0]['phone'] = "";
		break;
		
		case 'modify':
			$user_id = $codeAnt->input->get('user_id', 2);
			$data = dao_user::getUserInfoById($user_id);
		break;

		default:
		break;
	}
echo $method;	
	$codeAnt->tpl->assign_by_ref('action',$method);
	$codeAnt->tpl->assign_by_ref('data',$data);
	$codeAnt->display();
	

?>
