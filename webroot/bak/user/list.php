<?php
	require_once('../../init/init.php');
	
	$pageNum = $codeAnt->input->get('pagenum');
	$displayPage = 20;
	$total = dao_user::getUserTotal();
	$pageObj = new page($total, $pageNum, $displayPage);
	$pageForm = $pageObj->returnForm();
	if(!empty($total)){
		$data = dao_user::getUserList($pageObj->limitSql);
	}else{
		$data = Array();
	}
	$codeAnt->tpl->assign_by_ref('data',$data);
	$codeAnt->tpl->assign_by_ref('pageform',$pageForm);

	$codeAnt->display();
?>
