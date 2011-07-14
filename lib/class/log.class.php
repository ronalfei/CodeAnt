<?php
class log
{
	
	/**
	 * 写日志到文本
	 * $where采用swith的值,what为自己写入,将动作描述清楚即可
	 * @param $case $where
	 * @param string $what
	 */
	static private function writeLogToFile($where,$what)
	{
		$params['what']		= $what;
		$params['when']		= date('Y-m-d H:i:s');

		$dir = _ROOT.'logs/option/';
		if(file_exists ( $dir)){
			$filename = $dir.'option.'.date('Ymd').'.log';
			$data = "[{$params['when']}]  {$params['what']} .\r\n";
			file_put_contents($filename,$data,FILE_APPEND);
		}else{
			echo '操作日志路径不存在:'.$dir;
		}
	}
	
	
	
	/**
	 * 写日志
	 * option默认为0或者为空,此时数据库和文本都写入,当option为:1-写入文件 
	 * @param $case $where
	 * @param string $what
	 * @param int $option(1,2)
	 */
	static public function writeLog($what,$option=0)
	{
		switch($option)
		{
			case 1:
				self::writeLogToFile($where, $what);
				break;
			case 2:
				self::writeLogToFile($where, $what);
				break;
			default:
				self::writeLogToFile($where, $what);
				break;
		}
	}
	


}
?>