<?php
class cexception extends Exception 
{
	public function __construct($message="", $code=0, Exception $previous=NULL)
	{
		$trace = debug_backtrace();
		$filename = $trace[1]['file'];
		$line = $trace[1]['line'];
		$message = $message."({$filename}{$line})";
		if(_DEBUG=='Y'){
			echo $message;
		}
		parent::__construct($message, $code, $previous);
	}

}

?>
