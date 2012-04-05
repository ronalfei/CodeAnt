<?php
	require_once('../../init/init.php');
	
	$whereParams['user_id'] = $codeAnt->input->get('user_id', 2);

	if(!empty($whereParams['user_id'])){
		$userinfo = dao_user::getUserInfoById($whereParams['user_id']);
	}else{
		$userinfo = array();
	}

	$pageNum = $codeAnt->input->get('pagenum');

	$displayPage = 20;
	$gift_obj = new dao_gift();
	$total = dao_gift::getGiftTotal($whereParams);
	$pageObj = new page($total, $pageNum, $displayPage);
	$pageForm = $pageObj->returnForm();
	if(!empty($total)){
		$data = dao_gift::getGiftList($whereParams, $pageObj->limitSql);
	}else{
		$data = Array();
	}
	

	$codeAnt->tpl->assign_by_ref('data',$data);
	$codeAnt->tpl->assign_by_ref('userinfo',$userinfo);
	$codeAnt->tpl->assign_by_ref('pageform',$pageForm);

	$codeAnt->display();
?>
