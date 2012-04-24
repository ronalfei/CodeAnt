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
		$ip = $this->getUserIp();
		$agent = $this->getUserBroswer();
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
	
	private function getUserIp()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;
	}

	private function getUserBroswer()
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
