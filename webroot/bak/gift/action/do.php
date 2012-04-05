<?php
	require_once('../../../init/init.php');


	$action = $codeAnt->input->post('action');

	switch($action){
		case 'receive':
			$params['user_id'] = $codeAnt->input->post('user_id',2);
			$params['name'] = $codeAnt->input->post('name',2);
			$params['money'] = $codeAnt->input->post('money',2);
			$params['gift'] = $codeAnt->input->post('gift',2);
			$params['memo'] = $codeAnt->input->post('memo',2);
			$params['insert_time'] = 'now()';
			dao_gift::receiveGift($params);
			//js::parentHref("/gift/list.php?user_id={$params['user_id']}");
			js::reloadParent();
		break;
		
		case 'give':
			$params['user_id'] = $codeAnt->input->post('user_id',2);
			$params['name'] = $codeAnt->input->post('name',2);
			$params['money'] = $codeAnt->input->post('money',1);
			$params['gift'] = $codeAnt->input->post('gift',2);
			$params['memo'] = $codeAnt->input->post('memo',2);
			$params['insert_time'] = 'now()';
			dao_gift::giveGift($params);
			//js::parentHref("/gift/list.php?user_id={$params['user_id']}");
			js::reloadParent();

		break;

		case 'modify':
			$gift_id = $codeAnt->input->post('gift_id',1);
			$params['money'] = $codeAnt->input->post('money',1);
			$params['gift'] = $codeAnt->input->post('gift',2);
			$params['memo'] = $codeAnt->input->post('memo',2);
			dao_gift::modifyGift($params,$gift_id);
			js::reloadParent();


		break;

		default:
		break;
	}
	

?>
