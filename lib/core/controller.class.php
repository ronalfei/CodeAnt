<?php
class controller 
{
	private $codeAnt;
	public $db;
	
	public function __construct()
	{
		$this->setCodeAnt();
	}

	private function setCodeAnt()
	{
		global $codeAnt;
		$this->codeAnt = &$codeAnt;
		$this->db = $this->codeAnt->db;
	}

	public static function codeAnt()
	{
		global $codeAnt;
		return $codeAnt;
	}

	public function __get($var_name)
	{
	    global $codeAnt;
        $var_name = strtolower($var_name);
        switch($var_name){
            case 'codeant':
			    $autoGet = &$codeAnt;
			    return $autoGet; 
            break;

            default:
			    $var_name = addslashes($var_name);
			    throw new cexception("你访问的变量{$var_name}不存在");
            break;
        }
		
	}
}


?>
