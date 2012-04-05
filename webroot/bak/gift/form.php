<?php
	require_once('../../init/init.php');


	$type = $codeAnt->input->get('type');
	$user_id= $codeAnt->input->get('user_id');
	$user_info = dao_user::getUserInfoById($user_id);

	$data[0]['user_id'] = $user_info[0]['user_id'];
	$data[0]['name'] = $user_info[0]['name'];

	switch($type){
		case 'receive':
			break;
		
		case 'give':
			break;
		
		case 'modify':
			$gift_id = $codeAnt->input->get('gift_id', 1);
			$gift_data = dao_gift::getGiftInfoById($gift_id);
			break;

		default:
			break;
	}
	
	$codeAnt->tpl->assign_by_ref('action', $type);
	$codeAnt->tpl->assign_by_ref('data',$data);
	$codeAnt->tpl->assign_by_ref('gift_data',$gift_data);
	$codeAnt->display();
	

?>
