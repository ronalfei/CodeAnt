<?php
/**
 * input类
 * author:fei.wang
 */
class input
{
	public function __construct()
	{
		
	}
	/**
	 * 
	 * @param string $key
	 * @param int $type(1-数字;2-字符;3-数组或其他)
	 * @return result
	 */
	public function get($key,$type=2)
	{
		$key = self::trim($key);
		$value = isset($_GET[$key])?$_GET[$key]:0;
		return $this->filter($value,$type);
	}
	
	public function post($key,$type=2)
	{
		$key = self::trim($key);
		$value = isset($_POST[$key])?$_POST[$key]:0;
		return $this->filter($value,$type);
	}
	public function request($key,$type=2)
	{
		$key = self::trim($key);
		$value = isset($_POST[$key])?$_POST[$key]:FALSE;
		if(!$value){
			$value = isset($_GET[$key])?$_GET[$key]:FALSE;
		}
		if(!$value){
			return '';
		}
		return $this->filter($value,$type);
	}
	public function string($type=2)
	{
		$key = self::trim($key);
		$value = isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:0;
		return $this->filter($value,$type);
	}
	public function uri()
	{
		return $_SERVER['DOCUMENT_URI'];
	}
	public function method()
	{
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}

	private function filter($value,$type)
	{
		switch($type){
			case 1:
				return intval($value);
				break;
			case 2:
                if(empty($value)){
                    return "";
                }else{
				    return self::trimXss(addslashes($value));
                }
				break;
			case 3:
                if(empty($value)){
                    return Array();
                }else{
				    return $value;
                }
				break;
			default:
				return $value;
				break;
		}
	}
	
	public static function trim($key)
	{
		return trim($key);
	}
	public static function trimXss($string)
	{
		return str_ireplace(array('<script','</'), array('script',' '), $string);
	}
}

?>
