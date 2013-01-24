<?php
/**
* 这个类暂时没有什么意义了
*/

class error
{
	static public function codeant_handler($no,$str,$file,$line)
	{
		$message = "CodeAnt Error:{$no} {$str} {$file} {$line}";
		switch($no){
			case E_WARNING:

			case E_USER_ERROR:
				throw new cexception($message);
				break;
        	default:
				break;
		}
		return true;
	}
}
