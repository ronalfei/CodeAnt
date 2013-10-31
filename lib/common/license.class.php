<?php
/**
 * @name:license类
 * @abstract: License服务器操作类
 * @author:fei.wang
 * @date:2009-5-12
 */
class license
{
	private $licenseText;
	private $licenseKeyPath;
	
	/**
	 * License构造函数
	 *
	 * @param int $host
	 */
	public function __construct($license_filepath)
	{
		$this->licenseText = file_get_contents($license_filepath);
		$this->licenseKeyPath = dirname($license_filepath).'/license.key';
		$this->licenseKey = file_get_contents($this->licenseKeyPath);
	}
	
	/**
	 * 
	 * 生成licenseKey
	 * @param string $domain
	 * @param string $mac_addr
	 * @param string $expire_date
	 */
	
	public function createLicenseKey($domain, $mac_addr, $expire_date)
	{
		$text = $this->licenseText;
		$license_key_source = Array('domain'=>$domain
							,'mac_addr'=>$mac_addr
							,'expire_date'=>$expire_date
							,'subcounts'=>$subcounts
							,'total_size'=>$total_size
							,'text'=>$text);
		
		$license_key = $this->encode($license_key_source);
		file_put_content($this->licenseKeyPath,$license_key);
	}
	
	
	/**
	 * 
	 * 转换字符串为加密形式
	 * @param string $str
	 * @return string
	 */
	private function encode($str)
	{
		return base64_encode(gzdeflate(json_encode($str)));
	}
	
	
	/**
	 * 
	 * 解密字符串为原始的php数组形式
	 * @param string $str
	 * @return Array
	 */
	private function decode($str)
	{
		return base64_decode(gzinflate(json_decode($str)));
	}
	
	
	/**
	 * 
	 * 获取加密后的licenseKey
	 */
	public function decodeLicenseKey()
	{
		return $this->decode($this->licenseKey);
	}
	
	
	
	/**
	 * 获取主机mac地址
	 */
	public function getEthMac()
	{
		$mac_array = array();
		switch ( strtolower(PHP_OS) ){
			case "linux":
				$mac_array = $this->getMacForLinux();
				break;
			case "solaris":
				break;
			case "unix":
				break;
			case "aix":
				break;
			default:
				$mac_array = $this->getMacForWindows();
				break;
		}
		$temp_array = array();
		$mac_addr = "";
		foreach ( $mac_array as $value ){
			if (
			preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i"
			,$value 
			,$temp_array ) ){
				$mac_addr = $temp_array[0];
				break;
			}

		}
		unset($temp_array);
		return $mac_addr;
	}
	
	
	private function getMacForLinux()
	{
		@exec("ifconfig -a", $result);
		return $result;
	}
	
	private function getMacForWindows()
	{
		@exec("ipconfig /all", $result);
		if ( $result ){
			return $result;
		}else{
			$ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";
			if ( is_file($ipconfig) )
			@exec($ipconfig." /all", $result);
			else
			@exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $result);
			return $result;
		}
	}
	
	
	public function isValidateMac()
	{
		$licenseArray = $this->decodeLicenseKey();
		$mac = $this->getEthMac();
		if($licenseArray['mac_addr']==$mac){
			return true;
		}else{
			return false;
		}
	}
	
	public function isExpire()
	{
		$licenseArray = $this->decodeLicenseKey();
		if(time()>strtotime($licenseArray['expire_date'])){
			return false;
		}else{
			return true;
		}
	}
	
	
	public function getTotalSize()
	{
		return "10G";
	}
	
	public function getTotalSubCounts()
	{
		return 10;
	}
	/**
	 * 析构函数
	 * 
	 */
	public function __destruct()
	{
		
	}
}

?>
