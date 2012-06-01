<?php
class util
{
	public static function getUserIp()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;
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
