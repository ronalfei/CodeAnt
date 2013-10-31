<?php

class unit
{
	/**
	 * 解压gzip的字符串
	 * @param gzip-string $data
	 * @return string
	 */
	static public function gzdecode ($data) {
		$flags = ord(substr($data, 3, 1));
		$headerlen = 10;
		$extralen = 0;
		$filenamelen = 0;
		if ($flags & 4) {
			$extralen = unpack('v' ,substr($data, 10, 2));
			$extralen = $extralen[1];
			$headerlen += 2 + $extralen;
		}
		if ($flags & 8) // Filename
		$headerlen = strpos($data, chr(0), $headerlen) + 1;
		if ($flags & 16) // Comment
		$headerlen = strpos($data, chr(0), $headerlen) + 1;
		if ($flags & 2) // CRC at end of file
		$headerlen += 2;
		$unpacked = @gzinflate(substr($data, $headerlen));
		if ($unpacked === FALSE){
			$unpacked = $data;
		}
		return $unpacked;
	}
	
	static public function curlPost($url ,$data){
		$ch = curl_init();
		if(is_array($data)) {
			$posts = self::arr2url($data);
			//echo $posts;
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
	static private function arr2url($arr = array()) {
		$str = '';
		$and = '';
		foreach($arr as $key => $val) {
			if(is_string($key)) {
				$str .= "$and$key=$val";
			}
			$and = '&';
		}
		return $str;
	}
}
?>