<?php

//DB_TYPE类型有mysql和mysqlii和pdodb
define('_DB_TYPE','mysqlii');							//配置数据库类型
define('_DB_HOST','127.0.0.1');							//配置数据库主机名
define('_DB_PORT','3306');								//配置数据库主机名
define('_DB_USER','ronalfei');							//配置数据库连接用户名
define('_DB_PASSWORD','batisfei');						//配置数据库连接密码
define('_DB_NAME','FAMILYOS');							//配置默认连接数据库名
define('_DB_CHARSET','utf8');							//配置数据库字符集
if(_DB_TYPE=='mysql'||_DB_TYPE=='mysqlii'){
	define('MYSQL_RETURN_TYPE', MYSQL_ASSOC);
}
if(_DB_TYPE=='pdodb'){
	define('_PDO_TYPE', 'mysql');						//如果定义数据库类型为pdodb后,需要给pdodb再次配置数据库类型
}
	
?>
