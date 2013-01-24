<?php

class memc
{
	private $handle=false;

	private $config;
	
	private $expire;

	private $enable;

	private $autoCompress;
	
    function __construct()
	{
		$this->setConfig(_MEMCACHE_HOST);
		$this->setExpire(_MEMCACHE_EXPIRE);
		$this->setCache();
		$this->autoCompress = _MEMCACHE_AUTO_COMPRESS;
    }
    public function connect()
    {
    	if($this->enable==false){
    		return false;
    	}
    	if(!$this->handle){
    		$this->handle = new Memcache();
	    	if ($this->config)
			{
				if (count($this->config) == 1)
				{
					$cf = (current($this->config));
					$this->handle->connect($cf[0],$cf[1]);
				}
				else
				{
					foreach($this->config as $k => $v)
					{
						$this->handle->addServer($v[0],$v[1]);
					}
				}
				$this->setAutoCompress();
			}
    	}
    }
    private function setAutoCompress()
    {
    	if($this->autoCompress){
    		$this->handle->setCompressThreshold(_MEMCACHE_AUTO_COMPRESS_MIN,_MEMCACHE_AUTO_COMPRESS_RANK);//20k超过就压缩,压缩比为0.2
    	}
    }
    public function setConfig($config)
    {
    	$this->config = unserialize($config);
    }
    public function setExpire($second)
    {
    	$this->expire = $second;	
    }
    public function setCache()
    {
    	$this->enable=_CACHE_ENABLE;
    }
	public function enableCache()
	{
		$this->enable=true;
	}
	public function enable()
	{
		$this->enable=true;
	}
	public function disableCache()
	{
		$this->enable=false;
	}
	public function disable()
	{
		$this->enable=false;
	}
	function set($key, $value,$ifCompress=0, $expire = 0)
	{
		if($this->enable==false){
    		return false;
    	}
		if(empty($expire)){
			$expire = $this->expire;
		}
		$this->connect();
		$ifCompress = intval($ifCompress);
		return $this->handle->set($key, $value, $ifCompress, $expire);
	}
	
	function replace($key, $value,$ifCompress=0, $expire = 0)
	{
		if(empty($expire)){
			$expire = $this->expire;
		}
		$this->connect();
		$ifCompress = intval($ifCompress);
		return $this->handle->replace($key, $value, $ifCompress, $expire);
	}

	/**
	 * get value
	 */
	function get($key)
	{
		$this->connect();
		if($this->enable){
			return $this->handle->get($key);
		}else{
			return false;
		}
	}

	function increment($key, $value)
    {
        $this->connect();
        return $this->handle->increment($key, $value);
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
	

	function del($key)
	{
		return $this->delete($key);
	}
	/**
	 * flush all
	 */
	function flush()
	{
		$this->connect();
		return $this->handle->flush();
	}

	/**
	 * get stats
	 */
	function stats()
	{
		$this->connect();
		return $this->handle->getStats();
	}

	function close()
	{
		if($this->handle){
			$this->handle->close();
			$this->handle=false;
		}
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
