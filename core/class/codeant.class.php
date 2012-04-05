<?php
/**
 * CodeAnt
 * @author	blackAnimal
 * @version	0.0.1
 * @abstract 为了支持5.2,必须实例化该类后,才能调用各个对象
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
		require_once(_CORE_ROOT.'class/factory.class.php');
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
	
	public function debug()
	{
		$this->debug->display();
	}
	public function display()
	{
		$uri = $this->input->uri();
		$template = str_replace('.php', '.html', $uri);
		$tpl = substr($template,1);
		$this->tpl->display($tpl);
		$this->debug->display();
	}
	public function run()
	{
		$request_uri = $_SERVER['REQUEST_URI'];
		$tmp_uri = explode('?', $request_uri);
		$uri = array_values(
		            array_filter(
		                explode('/',
		                        str_replace('\\', '/', $tmp_uri[0])
		                )
		            )
		        );
		if(empty($uri[0])){//没有获取到控制器名称,则加载默认控制器
		    $controller = _DEFAULT_CONTROLLER;
		    $method = "index";
		}else{
		    $controller = $uri[0];
		    $method = empty($uri[1])?"index":$uri[1];
		    $params = array_slice($uri, 2, -1);
		}
		
		$object = new $controller();
		
		call_user_func_array(array($object,$method), $params);
	}
	
}

?>
