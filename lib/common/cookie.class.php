<?php
class common_cookie
{
	public static function rawSet($cookie_name,$value,$expire = 0,$path, $domain,$secure = false,$httponly = false)
	{
		return setcookie($cookie_name,$value,$expire = 0,$path, $domain,$secure = false,$httponly = false);
	}
	
	public static function set($name,$value)
	{
		$value = self::encrypt($value);
		$domain = $_SERVER['HTTP_HOST'];
		return setcookie($name, $value, 0, '/', $domain);
	}
	
	public static function get($name)
	{
		$value = empty($_COOKIE[$name])?'':$_COOKIE[$name];
		return self::decrypt($value);
	}
	
	public static function encrypt($value)
	{
		return base64_encode(serialize($value));
	}
	
	public static function decrypt($value)
	{
		return unserialize(base64_decode($value));
	}
	
	public static function cookie_destroy()
	{
		return self::set(array());
	}

	/**********************************
	public static function isCookieLogin()
	{
		$value = self::get();
		if(empty($value['username'])){
			return false;
		}else{
			return $value;
		}
	}
	*********************************/
}
?>