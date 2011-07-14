<?php
/**
 * file:init.php
 * php文件的入口
 * author:fei.wang
 * date:2008.3.15
 *
 */
header('Content-Type:text/html;Charset=utf-8');
header('Cache-Control:no-Cache');
if(!defined('_ROOT'))
{
	define('_ROOT',dirname(dirname(__FILE__)).'/');
}

ini_set('magic_quotes_sybase','Off');		//由于smarty的问题,因此这里必须得关闭.否则会出问题,新版本已经解决
ini_set('magic_quotes_runtime','Off');
date_default_timezone_set('PRC');

require_once(_ROOT.'config/config.php');
require_once(_SMARTY_ROOT.'Smarty.class.php');
require_once(_CLASS_ROOT.'codeant.class.php');
if(_USE_FIRE_PHP){
	require_once(_LIB_ROOT.'FirePHPCore/fb.php');
}

//------判断是否需要登陆验证--------
//默认都需要验证,如设置了$_SERVER['NO_CHECK'],就需要登陆
if(!isset($_SERVER['NO_CHECK'])){
	require_once(_WEB_ROOT.'login.php');
}
//-----------------------------
//ob_start();		//for firePHP
$codeAnt	= new codeant();
$codeant	= &$codeAnt;
$codeAnt->benchmark->mark('total_execute_time_start');
//fb($codeAnt);    //这是一个使用firephp进行调试的例子
//$mq = new mq();	//创建消息队列对象memcacheq

?>