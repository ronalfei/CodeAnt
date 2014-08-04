<?php

//********缓存配置*********************
define('_MEMCACHE_ENABLE',true);					//是否使用memcache,默认false
$temp_config = serialize(array(
	array('127.0.0.1', 11216),
	//array('10.100.120.210', 11212),
	//array('10.100.120.210', 11411),
));
define('_MEMCACHE_HOST',$temp_config);
define('_MEMCACHE_EXPIRE', 0);					//默认期限为一小时
define('_CACHE_ENABLE',true);						//是否使用缓存
define('_MEMCACHE_AUTO_COMPRESS',false);			//是否开启memcache的自动压缩,默认关闭
if(_MEMCACHE_AUTO_COMPRESS){
	define('_MEMCACHE_AUTO_COMPRESS_MIN',20000);		//自动压缩的最小数据为20k,在自动压缩开关打开时才有效
	define('_MEMCACHE_AUTO_COMPRESS_RANK',0.2);			//自动压缩比为0.2(节约20%),在自动压缩开关打开时才有效
}
unset($temp_config);

?>
