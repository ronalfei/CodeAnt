<?php
/**
 * CodeAnt
 * @author	blackAnimal
 * @version	0.2.1
 * @abstract 
 */
class codeant
{
    public $response    = '';

    public $benchmark	= "";
    public $db			= "";
    public $tpl			= "";
    public $input		= "";
    public $memcache	= "";
    public $debug		= "";
    public $log			= "";

    public $requestMethod;

    public $controller;
    public $action;
    public $method;
    public $binding;


    public function __construct()
    {
        require_once(_CORE_ROOT.'factory.class.php');
        require_once(_CORE_ROOT.'cexception.class.php');
        //require_once(_CORE_ROOT.'error.class.php');
        $this->benchmark	= factory::createBenchmarkObject();
        $this->db			= factory::createDbObject();
        $this->tpl			= factory::createTplObject($this->benchmark);
        $this->input		= factory::createInputObject();
        $this->log			= factory::createLogger();
        factory::createUtil();

        if(_MEMCACHE_ENABLE){
            $this->memcache	= factory::createMemcacheObject();
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
    private function setMethod($action)
    {
        $this->method = $action;
    }

    private function setRequestMethod()
    {
        $this->requestMethod = empty($_SERVER['REQUEST_METHOD'])?'unkown':strtolower($_SERVER['REQUEST_METHOD']);
    }


    private function dispatch($uri_array)
    {
        $uri = implode($uri_array, '/');
        $map = config_router::$map;
        $new_uri_array  = array();
        $binding        = array();
        foreach($map as $k => $v){
            if(preg_match($k, $uri, $binding) === 1){ //because preg_match return 0 or 1 as nomatch or match , error as false
                $new_uri_array = $v;
                $this->binding = $binding;
                break;
            }            
        }
        return $new_uri_array;
    }
    public function run()
    {
        header("X-FrameWork-By: CodeAnt");
        $request_uri = $_SERVER['REQUEST_URI'];
        $this->setRequestMethod();
        $tmp_uri = explode('?', $request_uri);
        $uri = array_values(
                array_filter(
                    explode('/',
                    str_replace('\\', '/', $tmp_uri[0])
                )
            )
        );
        $uri = $this->dispatch($uri);   //带进去原始数组, 返回一个新的数组
        if(empty($uri)){
            http_response_code(404);
            die("uri not found"); 
        }
        if(empty($uri[$this->requestMethod])){
            http_response_code(405);
            die("method not allowed"); 
        }else{
            $controller = $uri[$this->requestMethod][0];
            $action = empty($uri[$this->requestMethod][1])?_DEFAULT_METHOD:$uri[$this->requestMethod][1];
            $params = array_slice($uri[$this->requestMethod], 2);
        }


        $controller_file_path  = _CONTROLLER_ROOT."{$controller}.controller.php";
        if(file_exists($controller_file_path)){
            include_once($controller_file_path);
        }else{
            throw new cexception("控制器{$controller}.controller.php不存在");
        }
        $_controller = "controller_{$controller}";					//控制器里面的方法必须以"controller_" 开头, 用来避开某些方法与关键字的冲突
        $_action = "action_{$action}";								//控制器里面的方法必须以"action_" 开头, 用来避开某些方法与关键字的冲突
        if(class_exists($_controller)){
            $object = new $_controller();
        }else{
            throw new cexception("控制器:{$controller}不存在");
        }
        if(method_exists($object, $_action)){
            $this->setController($controller);
            $this->setMethod($action);
            $this->log->info($this->requestMethod);
            call_user_func_array(array($object,$_action), $params);
        }else{
            throw new cexception ("该控制器:{$controller}的方法:{$action}不存在");
        }

    }


    public function response($code, $status, $data)
    {
        $this->json_response($code, $status, $data);
    }

    public function json_response($http_code, $status, $data)
    {
        $code = intval($http_code);
        $response['data'] = $data;
        $response['code'] = $code;
        $response['status'] = $status;
        $response_json = json_encode($response);
        header('Content-Type:application/json; Charset=utf-8');
        echo $response_json;
    }

    public function rest_response($http_code, $status, $data)
    {
        $code = intval($http_code);
        $response['data'] = $data;
        $response['status'] = $status;
        $response['code'] = $code;
        $response_json = json_encode($response);
        http_response_code($code);
        header('Content-Type:application/json; Charset=utf-8');
        //header("Status: {$code}");
        echo $response_json;
    }

}

?>
