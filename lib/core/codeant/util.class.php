<?php
class util
{
	public static function getUserIp()
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
		$agent = $_SERVER['HTTP_USER_AGENT'];
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
		else
		{
		  @header('Browser:else');
		  return  'firefox';
		}
	}

}
?>
