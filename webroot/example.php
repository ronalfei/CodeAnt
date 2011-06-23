<?php
	$_SERVER['NO_CHECK'] = 1;
	require_once('../init/init.php');
	$user = new common_user();
	//$codeAnt->cache->enable();
	$display	= 10;
	$pagenum	= $codeAnt->input->get('pagenum',1);
	
	$params['category_id'] = $codeAnt->input->get('cid',1);
	
	$total		= web_casino::getCasinoTotal($params);
	$page		= new page($total,$pagenum,$display);
	$casino_list= web_casino::getCasinoList($params,$page->limitSql);
	//fb($casino_list);
	
	$category		= web_casino::getCategory();		//获取设置为显示的类别
	
	$codeAnt->tpl->assign_by_ref('category',$category);

	$codeAnt->tpl->assign_by_ref('pageform',$page->returnForm());
	
	$codeAnt->tpl->assign_by_ref('casino_list',$casino_list);
	
	$codeAnt->tpl->display('web/list.html');
	$codeAnt->debug->displayProfile();
?>