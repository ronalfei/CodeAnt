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

define('_ROOT',dirname(dirname(__FILE__)).'/');


ini_set('magic_quotes_sybase','Off');		//由于smarty的问题,因此这里必须得关闭.否则会出问题,新版本已经解决
ini_set('magic_quotes_runtime','Off');
date_default_timezone_set('PRC');

require_once(_ROOT.'config/config.php');
require_once(_SMARTY_ROOT.'Smarty.class.php');
require_once(_CORE_ROOT.'codeant/codeant.class.php');
require_once(_CORE_ROOT.'codeant/controller.class.php');
require_once(_CORE_ROOT.'codeant/module.class.php');
if(_USE_FIRE_PHP){
	require_once(_PLUGIN_ROOT.'FirePHPCore/fb.php');
}

//ob_start();		//you can start this firePHP
$codeAnt	= new codeant();
$codeant	= &$codeAnt;
$codeAnt->benchmark->mark('total_execute_time_start');
spl_autoload_register('codeAntAutoLoad');
?>
