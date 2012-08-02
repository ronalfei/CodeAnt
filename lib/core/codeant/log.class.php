<?php
class log
{
	static private $level = Array('debug'=>1, 'info'=>2, 'warning'=>3, 'error'=>4);


	static public function debug($term)
	{
		self::is_this_level(1)?self::WriteToFile('DEBUG', $term):"";
	}
	static public function info($term)
	{
		self::is_this_level(2)?self::WriteToFile('INFO', $term):"";
	}
	static public function warning($term)
	{
		self::is_this_level(3)?self::WriteToFile('WARNING', $term):"";
	}
	static public function error($term)
	{
		self::is_this_level(4)?self::WriteToFile('ERROR', $term):"";
	}

	static private function WriteToFile($level, $term)
	{
		$trace = debug_backtrace();
		$filename = $trace[1]['file'];
		$line = $trace[1]['line'];
		$term = self::switchTerm($term);
		$date = date("Y.m.d");
		$file_path = _OPTION_PATH.'codeAnt.'.$date.'.log';
		$ip = util::getUserIp();
		$agent = util::getUserBroswer();
		$datetime = date("Y-m-d H:i:s");
		$prefix = "[{$datetime}] [{$ip}] [{$agent}] [$level] {$_SERVER['REQUEST_URI']}({$filename}{$line}):";
		$data = $prefix.$term."\r\n";
		file_put_contents($file_path, $data, FILE_APPEND);
	}
	static private function is_this_level($level)
	{	
		$option_log_level = self::$level[strtolower(_OPTION_LOG_LEVEL)];
		if($level>=$option_log_level){
			return true;
		}else{
			return false;
		}
	}
	
	static private function switchTerm($term)
	{
		$type = strtolower(gettype($term));
		switch ($type){
			case 'array':
				return var_export($term, true);
			break;
			case 'object':
				return var_export($term, true);
			break;
			default:
				return $term;
			break;
		}
	}


}

?>
