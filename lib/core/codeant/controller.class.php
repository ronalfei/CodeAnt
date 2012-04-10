<?php
class controller 
{
	protected $codeAnt;
	
	public function __construct()
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
			return $this->codeAnt;
		}else{
			$var_name = addslashs($var_name);
			die("你访问的变量{$var_name}不存在");
		}
		
	}
}
