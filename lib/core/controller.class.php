<?php
class controller 
{
	private $codeAnt;
	
	public function __construct()
	{
		$this->setCodeAnt();
	}

	private function setCodeAnt()
	{
		global $codeAnt;
		$this->codeAnt = &$codeAnt;
	}

	public static function codeAnt()
	{
		global $codeAnt;
		return $codeAnt;
	}

	public function __get($var_name)
	{
		if(strtolower($var_name)=='codeant'){
			global $codeAnt;
			$autoGet = &$codeAnt;
			return $autoGet; 
		}else{
			$var_name = addslashes($var_name);
			throw new cexception("你访问的变量{$var_name}不存在");
		}
		
	}
}


?>
