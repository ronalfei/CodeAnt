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

	public $controller;
	public $method;

	public function __construct()
	{
		require_once(_CORE_ROOT.'codeant/factory.class.php');
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
		$tpl = "{$this->controller}/{$this->method}"._TPL_EXT;
		$this->tpl->display($tpl);
		$this->debug();
	}
	private function setController($controller)
	{
		$this->controller = $controller;
	}
	private function setMethod($method)
	{
		$this->method = $method;
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
		    $controller	= _DEFAULT_CONTROLLER;
		    $method		= _DEFAULT_METHOD;
			$params		= Array();
		}else{
		    $controller = $uri[0];
		    $method = empty($uri[1])?_DEFAULT_METHOD:$uri[1];
		    $params = array_slice($uri, 2, -1);
		}

		$controller_file_path  = _CONTROLLER_ROOT."{$controller}.class.php";
		if(file_exists($controller_file_path)){
			include_once($controller_file_path);
		}else{
			die("文件{$controller}.class.php不存在");
		}
		$_controller = "c_{$controller}";				//控制器里面的方法必须以"_" 开头, 用来避开某些方法与关键字的冲突
		$_method = "_{$method}";						//控制器里面的方法必须以"_" 开头, 用来避开某些方法与关键字的冲突
		if(class_exists($_controller)){
			$object = new $_controller();
		}else{
			die("控制器:{$controller}不存在");
		}
		if(method_exists($object, $_method)){
			$this->setController($controller);
			$this->setMethod($method);
			call_user_func_array(array($object,$_method), $params);
		}else{
			die("该控制器:{$controller}的方法:{$method}不存在");
		}
		
	}
	
}

?>
