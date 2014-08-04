<?php

define('_SMARTY_VERSION', 3);										//根据你的smarty版本进行配置, 目前框架本身支持2和3
define('_SMARTY_ROOT',_LIB_ROOT.'smarty/');
define('_SMARTY_COMPILE_CHECK',TRUE);								//检查模版是否改动过,从而重新编译,上线后应该为false
define('_SMARTY_DEBUGGING',FALSE);									//是否输出调试信息
define('_SMARTY_CACHEING',FALSE);									//是否启用缓存(动态站点建议不启用)
define('_SMARTY_TEMPLATE_DIR',_TPL_ROOT); 							//模版存放路径
define('_SMARTY_COMPILE_DIR',_VAR_ROOT.'templates_c/');				//模版编译路径,单独提出方便清理
define('_SMARTY_CONFIG_DIR',_SMARTY_ROOT.'config/');				//模版config路径
define('_SMARTY_CACHE_DIR',_VAR_ROOT.'cache/');						//模版config路径
define('_SMARTY_LEFT_DELIMITER','{{');								//smarty脚本起始符
define('_SMARTY_RIGHT_DELIMITER','}}');								//smarty脚本结束符

?>
