<?php

class curl
{
	/**
	 * @params url string
	 * @params data array(k1=>v1, k2=>v2)  
	 * @params options array(option1=>value1,option2=>value2)
	 * @return http respond string
	 *
	 */
	static function post($url, $data, $options=array())
	{
		$ch = curl_init();
		$posts = http_build_query($data);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		foreach($options as $k=>$v){
			curl_setopt($ch, $k, $v);
		}
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
?>
