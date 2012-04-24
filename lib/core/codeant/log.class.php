<?php
class log
{
	private $level = Array('debug'=>1, 'info'=>2, 'warning'=>3, 'error'=>4);


	public function debug($term)
	{
		$this->is_this_level(1)?$this->WriteToFile('DEBUG', $term):"";
	}
	public function info($term)
	{
		$this->is_this_level(2)?$this->WriteToFile('INFO', $term):"";
	}
	public function warning($term)
	{
		$this->is_this_level(3)?$this->WriteToFile('WARNING', $term):"";
	}
	public function error($term)
	{
		$this->is_this_level(4)?$this->WriteToFile('ERROR', $term):"";
	}

	private function WriteToFile($level, $term)
	{
		$trace = debug_backtrace();
		$filename = $trace[1]['file'];
		$line = $trace[1]['line'];
		$term = $this->switchTerm($term);
		$date = date("Y.m.d");
		$file_path = _OPTION_PATH.'codeAnt.'.$date.'.log';
		$ip = util::getUserIp();
		$agent = util::getUserBroswer();
		$datetime = date("Y-m-d H:i:s");
		$prefix = "[{$datetime}] [{$ip}] [{$agent}] [$level] {$_SERVER['REQUEST_URI']}({$filename}{$line}):";
		$data = $prefix.$term."\r\n";
		file_put_contents($file_path, $data, FILE_APPEND);
	}
	private function is_this_level($level)
	{	
		$option_log_level = $this->level[strtolower(_OPTION_LOG_LEVEL)];
		if($level>=$option_log_level){
			return true;
		}else{
			return false;
		}
	}
	
	private function switchTerm($term)
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
