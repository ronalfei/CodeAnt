<?php
/**
 * @name:ladp类
 * @abstract: Ldap服务器操作类
 * @author:fei.wang
 * @date:2009-5-12
 */
class ldap
{
	private		$link;				//Ldap连接标识
	private		$host;				//Ldap主机名
	private 	$port;				//Ldap端口


	/**
	 * Ldap构造函数
	 *
	 * @param int $host
	 * @param int $port
	 */
	public function __construct($host,$port)
	{
		$this -> host		= $host;
		$this -> port		= $port;
		$this -> link		= false;
	}

	
	/**
	 * Ldap连接服务器
	 * return ID $link
	 */
	private function connectLdap()
	{
		if($this->link){
			return true;
		}else{
			//创建Ldap连接ID
			$this -> link = ldap_connect($this->host, $this->port) or die("--Can't connect Ldap Server!" . debug_print_backtrace() );
		}
	}


	/**
	 * 验证用户登录
	 * 
	 * @param string $username
	 * @param string $password
	 * @return Bool  $isBind
	 */
	public function auth($username, $password)
	{
		$this -> connectLdap();
		$isBind = ldap_bind($this->link, $username, $password);
		if(!$isBind){
			echo $this->errorMsg();
			return false;
		}else{
			return true;
		}
	}
	
	
	
	/**
	 * 返回当前的的错误信息
	 */
	private function errorMsg()
	{
		return ldap_error($this->link);
	}
	
	
	/**
	 * 取消绑定,等同于关闭连接
	 * 
	 */
	public function unbind()
	{
		if($this->link!==false){
			ldap_unbind($this->link);
			$this->link = false;
		}
	}
	
	
	/**
	 * unbind的别名
	 * 
	 */
	public function close()
	{
		$this->unbind();
	}
	
	
	/**
	 * 析构函数
	 * 
	 */
	public function __destruct()
	{
		$this->close();
	}
}

?>
