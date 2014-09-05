<?php
class util
{
	public static function getUserIp( $offset=0 )
	{
		$onlineip = '';
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		$onlineips = explode(',', $onlineip);

		if(!empty($onlineips[$offset])){
			return $onlineips[$offset];
		}else{
			return $onlineips[0];
		}
	}
	
	public static function getUserBroswer()
	{
		$agent = empty($_SERVER['HTTP_USER_AGENT'])?'unkown':$_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/Firefox/i', $agent)) {
		  @header('Browser:Firefox');
		  return "firefox";
		}
		elseif(preg_match('/Chrome/i',$agent))
		{
		  @header('Browser:Chrome');
		  return 'chrome';
		}
		elseif(preg_match('/MSIE\s+6/',$agent))
		{
		  @header('Browser:IE6');
		  return 'ie6';
		}
		elseif(preg_match('/MSIE\s+7/',$agent))
		{
		  @header('Browser:IE7');
		  return 'ie7';
		}
		elseif(preg_match('/MSIE\s+8/',$agent))
		{
		  @header('Browser:IE8');
		  return 'ie8';
		}
		elseif(preg_match('/MSIE\s+9/',$agent))
		{
		  @header('Browser:IE9');
		  return 'ie9';
		}
        elseif(preg_match('/curl/i',$agent))
		{
		  @header('Browser:Curl');
		  return 'ie9';
		}
		else
		{
		  @header('Browser:unkown');
		  return  'firefox';
		}
	}
	/**
	 * 根据时间戳创建一个不会重复18位UUID
	 * Enter description here ...
	 */
	public static function createUuId()
	{
		
		$time   = microtime();
		$tmp    = explode(" ", $time);
        $t      = explode('.', $tmp[0]);
        $mt     = substr($t[1], 0,6);
		$milTime = $tmp[1].$mt;
		$rand = self::rand2();
		return $milTime.$rand;
	}
	
	private static function rand2()
	{
		global $codeAnt;
		$key = 'ca_uuid_random_int';
		if(_MEMCACHE_ENABLE){
			$number = $codeAnt->memcache->increment($key,1);
			$number = intval($number);
			if(empty($number)){
				$number = 10;
				$codeAnt->memcache->set($key, $number);
			}
			if($number>85){
				$codeAnt->memcache->set($key, 10);
			}
			$rand = $number;
		}else{
			$rand = rand(10, 99);
		}
		return $rand;
	}

}
?>
