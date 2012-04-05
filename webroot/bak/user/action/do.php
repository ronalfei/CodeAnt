<?php
	require_once('../../../init/init.php');


	$action= $codeAnt->input->request('action');

	switch($action){
		case 'add':
			$params['name'] = $codeAnt->input->post('name',2);
			$params['phone'] = $codeAnt->input->post('phone',2);
			$params['memo'] = $codeAnt->input->post('memo',2);
			$params['insert_time'] = 'now()';
			dao_user::insertUser($params);
			js::parentHref("/user/list.php");
			break;
		
		case 'modify':
			$where['user_id'] = $codeAnt->input->post('user_id',2);
			$params['name'] = $codeAnt->input->post('name',2);
			$params['phone'] = $codeAnt->input->post('phone',2);
			$params['memo'] = $codeAnt->input->post('memo',2);
			dao_user::modifyUser($params, $where);
			js::reloadParent();
			break;

		case 'delete':
			$user_id = $codeAnt->input->get('user_id',2);
			if(empty($user_id)){
				js::reloadParent();
			}else{
				dao_user::deleteUser($user_id);
				js::reloadParent();
			}
			
			break;

		default:
		break;
	}
	

?>
