<?php
class cexception extends Exception 
{
	public function __construct($message="", $code=0, Exception $previous=NULL)
	{
		if(_DEBUG=='Y'){
			echo $message;
		}
		parent::__construct($message, $code, $previous);
	}

}

?>
