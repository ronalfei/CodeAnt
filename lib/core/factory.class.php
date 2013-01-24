<?php
/**
 * 对象工厂
 * @author	blackAnimal
 * @version	0.0.9
 */
class factory
{

	static public function & createBenchmarkObject()
	{
		require_once(_CORE_ROOT.'benchmark.class.php');
		$benchmark = new benchmark();
		return $benchmark;
	}

	static public function & createTplObject($benchmark)
	{
		require_once(_CORE_ROOT.'tpl.class.php');
		$tpl	=	new tpl($benchmark);
		return $tpl;
	}

	static public function & createDbObject()
	{
		require_once(_CORE_ROOT.''._DB_TYPE.'.class.php');
		$db_type = _DB_TYPE;
		$db	=	new $db_type(_DB_HOST,_DB_PORT,_DB_USER,_DB_PASSWORD,_DB_NAME,_DB_CHARSET);
		return $db;
	}

	static public function & createDebugObject($benchmark)
	{
		require_once(_CORE_ROOT.'debug.class.php');
		$debug = new debug($benchmark);
		return $debug;
	}
	//为了兼容显示调试信息的error
	static public function & createNoDebugObject()
	{
		require_once(_CORE_ROOT.'nodebug.class.php');
		$nodebug = new nodebug();
		return $nodebug;
	}
	

	static public function & createDBDebugObject()
	{
		require_once(_CORE_ROOT.'dbdebug.class.php');
		$dbdebug = new dbdebug();
		return $dbdebug;
	}

	static public function & createEncryptObject()
	{
		require_once(_CORE_ROOT.'encrypt.class.php');
		$encrypt = new encrypt();
		return $encrypt;
	}
	static public function & createInputObject()
	{
		require_once(_CORE_ROOT.'input.class.php');
		$input = new input();
		return $input;
	}
	
	static public function & createPageObject($total,$pageNum,$displayPage )
	{
		require_once(_CORE_ROOT.'page.class.php');
		$page = new page($total,$pageNum,$displayPage);
		return $page;
	}
	
	static public function & createMemcacheObject()
	{
		require_once(_CORE_ROOT.'memc.class.php');
		$memcache = new memc();
		return $memcache;
	}
	static public function & createLogger()
	{
		require_once(_CORE_ROOT.'log.class.php');
		$logger = new log();
		return $logger;
	}
	static public function createUtil()
	{
		require_once(_CORE_ROOT.'util.class.php');
	}
}

?>
