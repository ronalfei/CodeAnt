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


ini_set('magic_quotes_sybase', 'Off');		//由于smarty的问题,因此这里必须得关闭.否则会出问题,新版本已经解决
ini_set('magic_quotes_runtime', 'Off');
ini_set('cgi.fix_pathinfo', 0);
date_default_timezone_set('PRC');

//-------load config file here--------------
//require_once(_ROOT.'config/config.php');
require_once(_ROOT.'config/core.config.php');
require_once(_ROOT.'config/app.config.php');
require_once(_ROOT.'config/db.config.php');
require_once(_ROOT.'config/memcache.config.php');
require_once(_ROOT.'config/smarty.config.php');
require_once(_ROOT.'config/custom.config.php');
//-------------------------------------------

require_once(_SMARTY_ROOT.'Smarty.class.php');
require_once(_CORE_ROOT.'codeant/codeant.class.php');
require_once(_CORE_ROOT.'codeant/controller.class.php');
require_once(_CORE_ROOT.'codeant/module.class.php');

if(_USE_FIRE_PHP){
	require_once(_PLUGIN_ROOT.'FirePHPCore/fb.php');
	//ob_start();			//you can start this firePHP
}

$codeAnt	= new codeant();
$codeant	= &$codeAnt;
$codeAnt->benchmark->mark('total_execute_time_start');

spl_autoload_register('codeAntAutoLoad');


function codeAntAutoLoad($className)
{
    $file_path = "";
    $temp   = explode('_',$className);
    if(count($temp) > 1){
        switch($temp[0]){
            case 'controller':
                $file_path = _CONTROLLER_ROOT."{$temp[1]}.class.php";
            break;
            case 'module':
                $file_path = _MODULE_ROOT."{$temp[1]}.class.php";
            break;

            default:
                $file_path = _CLASS_ROOT."{$className}.class.php";
            break;
        }
    }else{
        $file_path = _CLASS_ROOT."{$className}.class.php";
        //nothing todo
        //因为smarty3.0 也用到了autoload函数, 这里就不能显示错误了.
        //debug_print_backtrace();
    }
    if(file_exists($file_path)){
        require_once($file_path);
    }

}

register_shutdown_function("catch_fatal_error");

function catch_fatal_error()
{
	global $codeAnt;
	$error = error_get_last();
	if(!empty($error)){
		$tmp = var_export($error, true);
		$codeAnt->log->error($tmp);
	}
}


?>
