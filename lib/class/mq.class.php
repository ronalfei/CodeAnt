<?php

class mq
{
	private $handle=false;
	private $config;
	
    function __construct()
	{
		$this->setConfig(_MQ);
    }
    public function connect()
    {
    	if(!$this->handle){
    		$this->handle = new Memcache();
    		$this->handle->connect($this->config['host'],$this->config['port']);
    	}
    }
    public function setConfig($config)
    {
    	$this->config = unserialize($config);
    }
   

	function set($queue_name, $value)
	{
		$this->connect();
		return $this->handle->set($queue_name, $value);
	}
	
	/**
	 * get value
	 */
	function get($queue_name)
	{
		$this->connect();
		return $this->handle->get($queue_name);
	}

	function close()
	{
		if($this->handle){
			return $this->handle->close();
		}
	}
	/**
	 * remove value from cache
	 *
	 */
	function delete($key)
	{
		$this->connect();
		return $this->handle->delete($key);
	}

	/**
	 * close connet
	 */
	public function __destruct()
	{
		return $this->close();
    }
}
?>