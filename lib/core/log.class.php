<?php
class log
{
	static private $level = Array('debug'=>1, 'info'=>2, 'warning'=>3, 'error'=>4);


	static public function debug($term, $display=false)
	{
		self::is_this_level(1)?self::WriteToFile('DEBUG', $term, $display):"";
	}
	static public function info($term, $display=false)
	{
		self::is_this_level(2)?self::WriteToFile('INFO', $term, $display):"";
	}
	static public function warning($term, $display=false)
	{
		self::is_this_level(3)?self::WriteToFile('WARNING', $term, $display):"";
	}
	static public function error($term, $display=false)
	{
		self::is_this_level(4)?self::WriteToFile('ERROR', $term, $display):"";
	}

	static private function WriteToFile($level, $term, $display)
	{
		$trace = debug_backtrace();
		$filename = $trace[1]['file'];
		$line = $trace[1]['line'];
		$term = self::switchTerm($term);
		$date = date("Y.m.d");
		$file_path = _ACCESS_LOG_PATH.'codeAnt.'.$date.'.log';
		$ip = util::getUserIp();
		$agent = util::getUserBroswer();
		//$datetime = date("Y-m-d H:i:s");
		$datetime = date("H:i:s");
        $request_uri = empty($_SERVER['REQUEST_URI'])?$_SERVER['SCRIPT_FILENAME']:$_SERVER['REQUEST_URI'];
		$prefix = "[{$datetime}] [{$ip}] [{$agent}] [$level] {$request_uri}({$filename}{$line}):";
		$data = $prefix.$term."\r\n";
		file_put_contents($file_path, $data, FILE_APPEND);
		if($display){
			self::output($data);
		}
	}
	static private function is_this_level($level)
	{	
		$option_log_level = self::$level[strtolower(_ACCESS_LOG_LEVEL)];
		if($level>=$option_log_level){
			return true;
		}else{
			return false;
		}
	}
	
	static private function output($data)
	{
		echo $data, "</br>";
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
