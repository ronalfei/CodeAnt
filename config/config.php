<?php

if(!defined('_ROOT'))								//root的定义在init.php文件中.
{
	echo "根目录_ROOT未定义";
}else{
	//***********站点通用定义*************
	if(PHP_OS=='WINNT'){
		define('_WEB_DOMAIN','/');
		//********数据库连接配置***************
		//DB_TYPE类型有mysql和mysqlii
		define('_DB_TYPE','mysql');								//配置数据库类型
		define('_DB_HOST','127.0.0.1');					//配置数据库主机名
		define('_DB_PORT','3306');								//配置数据库主机名
		define('_DB_USER','ronalfei');								//配置数据库连接用户名
		define('_DB_PASSWORD','batisfei');						//配置数据库连接密码
		define('_DB_NAME','FAMILYOS');							//配置默认连接数据库名
		define('_DB_CHARSET','utf8');							//配置数据库字符集
		//**************************************
	}else{
		define('_WEB_DOMAIN','/');
		//********数据库连接配置***************
		//DB_TYPE类型有mysql和mysqlii
		define('_DB_TYPE','mysqlii');								//配置数据库类型
		define('_DB_HOST','127.0.0.1');						//配置数据库主机名
		define('_DB_PORT','3306');								//配置数据库主机名
		define('_DB_USER','ronalfei');								//配置数据库连接用户名
		define('_DB_PASSWORD','batisfei');						//配置数据库连接密码
		define('_DB_NAME','FAMILYOS');							//配置默认连接数据库名
		define('_DB_CHARSET','utf8');							//配置数据库字符集
		//**************************************
	}
	if(_DB_TYPE=='mysql'||_DB_TYPE=='mysqlii'){
		define('MYSQL_RETURN_TYPE', MYSQL_ASSOC);
	}
	

	define('_APP_ROOT', _ROOT.'app/');
	define('_CONTROLLER_ROOT', _APP_ROOT.'controller/');	
	define('_MODULE_ROOT', _APP_ROOT.'module/');	
	define('_TPL_ROOT', _APP_ROOT.'templates/');
	define('_TPL_EXT', '.html');
	define('_DEFAULT_CONTROLLER', 'auto');
	define('_DEFAULT_METHOD', 'index');



	//define('_ADMIN_URL', _WEB_DOMAIN.'super/');
	define('_WEB_ROOT', _ROOT.'webroot/');
	define('_CSS_URL', '/themes/default/css/');
	define('_JS_URL', '/themes/default/js/');
	define('_LIB_ROOT', _ROOT.'lib/');
	define('_CORE_ROOT', _ROOT.'core/');
	define('_DEBUG', 'Y');									//是否调试模式,必须是(Y,N)之一,调试模式下显示错误在页面上
	define('_SQL_DEBUG', 'Y');								//是否在后台记录sql日志(Y-记录;N-不记录)
	define('_SQL_PATH', _ROOT.'logs/sql/');					//sql日志的目录
	define('_OPTION_PATH', _ROOT.'logs/option/');			//sql日志的目录
	//************************************

	//********缓存配置*********************
	define('_MEMCACHE_ENABLE',false);					//是否使用memcache,默认false
	$temp_config = serialize(array(
		array('10.11.5.207',11311),
	));
	define('_MEMCACHE_HOST',$temp_config);
	define('_MEMCACHE_EXPIRE',3600);					//默认期限为一小时
	define('_CACHE_ENABLE',true);						//是否使用缓存
	define('_MEMCACHE_AUTO_COMPRESS',false);			//是否开启memcache的自动压缩,默认关闭
	if(_MEMCACHE_AUTO_COMPRESS){
		define('_MEMCACHE_AUTO_COMPRESS_MIN',20000);		//自动压缩的最小数据为20k,在自动压缩开关打开时才有效
		define('_MEMCACHE_AUTO_COMPRESS_RANK',0.2);			//自动压缩比为0.2(节约20%),在自动压缩开关打开时才有效
	}
	unset($temp_config);
	//***************************************
	
	//*********消息队列服务器配置*************
	//$t_mq_config =serialize( array('host'=>'10.11.5.207','port'=>21112));
	//define('_MQ',$t_mq_config);
	//unset($t_mq_config);
	//***************************************
	
	
	
	//************smarty定义***************
	define('_SMARTY_VERSION', 3);										//根据你的smarty版本进行配置, 目前框架本身支持2和3
	define('_SMARTY_ROOT',_CORE_ROOT.'smarty/');
	define('_SMARTY_COMPILE_CHECK',TRUE);								//检查模版是否改动过,从而重新编译,上线后应该为false
	define('_SMARTY_DEBUGGING',FALSE);									//是否输出调试信息
	define('_SMARTY_CACHEING',FALSE);									//是否启用缓存(动态站点建议不启用)
	define('_SMARTY_TEMPLATE_DIR',_TPL_ROOT); 							//模版存放路径
	define('_SMARTY_COMPILE_DIR',_ROOT.'templates_c/');					//模版编译路径,单独提出方便清理
	define('_SMARTY_CACHE_DIR',_ROOT.'cache/');							//模版编译路径
	define('_SMARTY_CONFIG_DIR',_SMARTY_ROOT.'config/');				//模版config路径
	define('_SMARTY_LEFT_DELIMITER','{{');								//smarty脚本起始符
	define('_SMARTY_RIGHT_DELIMITER','}}');								//smarty脚本结束符
	//**************************************


	define('_USE_FIRE_PHP', FALSE);										//是否使用FirePHP,默认为不使用
	



	define('_SYS_NAME', "Family Manage System");

	define('_SYS_VERSION', "1.0");
	
}
/**
 * 配置用户名验证
 * 
 */
$check_users = array(
		'ronalfei'=> 'batisfei'
	);
//--------------------------------------

function codeAntAutoLoad($className)
{
	//可以根据索引来调整加载文件的先后顺序
	$file_path[1] = _CORE_ROOT.'class/'."{$className}.class.php"; //先到Core的class里找对象
	$file_path[2] = _CONTROLLER_ROOT."{$className}.class.php"; 
	$file_path[3] = _MODULE_ROOT."{$className}.class.php"; 
	$file_path[4] = _LIB_ROOT."{$className}.class.php"; 
	
	ksort($file_path);

	foreach($file_path as $path){
		if(file_exists($path)){
			require_once($path);
			break;
		}else{
			//因为smarty3.0 也用到了autoload函数, 这里就不能显示错误了.
			//debug_print_backtrace();
		}
	}

}

?>
