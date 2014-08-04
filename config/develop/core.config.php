<?php

//webdomain config
define('_WEB_DOMAIN','/');
define('_CSS_URL', '/themes/default/css/');
define('_JS_URL', '/themes/default/js/');

//webroot config
define('_WEB_ROOT', _ROOT.'webroot/');
//var root config
define('_VAR_ROOT', _ROOT.'var/');




//Lib root config
define('_LIB_ROOT', _ROOT.'lib/');
//core root config
define('_CORE_ROOT', _LIB_ROOT.'core/');
//plugin root config
define('_PLUGIN_ROOT', _LIB_ROOT.'plugin/');
//class root config
define('_CLASS_ROOT', _LIB_ROOT.'common/');


//debug config
define('_DEBUG', 'Y');										//是否调试模式,必须是(Y,N)之一,调试模式下显示错误在页面上
define('_SQL_DEBUG', 'Y');									//是否在后台记录sql日志(Y-记录;N-不记录)
define('_SQL_PATH', _VAR_ROOT.'logs/sql/');					//sql日志的目录
define('_ACCESS_LOG_PATH', _VAR_ROOT.'logs/access/');		//url访问日志的目录
define('_ACCESS_LOG_LEVEL', 'DEBUG');						//DEBUG > INFO > WARNING >  ERROR
//************************************

//custom plugin config
define('_USE_FIRE_PHP', FALSE);								//是否使用FirePHP,默认为不使用


?>
