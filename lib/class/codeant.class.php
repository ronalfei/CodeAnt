<?php
/**
 * CodeAnt
 * @author	blackAnimal
 * @version	0.0.1
 * @abstract 为了支持5.2,必须实例化该类后,才能调用各个对象
 * @abstract 5.3以后可以利用__callStatic来实现.也许代码会更加简洁
 */
class codeant
{
	/************ 不支持这种方式初始化,暂时保留***********************
	static public $benchmark= factory::createBenchmarkObject;
	static public $db		= factory::createDbObject;
	static public $tpl		= factory::createTplObject(factory::$benchmark);
	static public $input	= factory::createInputObject;
	static public $cache	= factory::createCacheObject;
	static public $debug	= factory::createDebugObject(factory::$benchmark);
	*******************************************************************/
	
	public $benchmark	= "";
	public $db			= "";
	public $tpl			= "";
	public $input		= "";
	public $memc		= "";
	public $debug		= "";

	public function __construct()
	{
		require_once(_CLASS_ROOT.'factory.class.php');
		$this->benchmark	= factory::createBenchmarkObject();
		$this->db			= factory::createDbObject();
		$this->tpl			= factory::createTplObject($this->benchmark);
		$this->input		= factory::createInputObject();
		if(_MEMCACHE_ENABLE){
			$this->memc			= factory::createMemcacheObject();
		}
		if(_DEBUG==='Y')
		{
			ini_set('display_errors',1);
			error_reporting(E_ALL);
			$this->debug		= factory::createDebugObject($this->benchmark);
		}
		else if(_DEBUG==='N')
		{
			ini_set('display_errors',0);
			error_reporting(E_ALL^E_NOTICE);
			//error_reporting(E_ALL);
			$this->debug		= factory::createNoDebugObject();
		}
		else
		{
			//nothing todo ;
		}
	}
}

?>