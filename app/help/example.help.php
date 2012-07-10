<?php
//------------------------------------------------------
//help类名必须以help_开头,同时需要继承help
//每个help都会有一个核心对象codeant,
//可以通过$this->codeant来调用该变量,以及codeant所包含的方法
//----------------------------------------------------------------

class help_example extends help
{
	public function getUserId()
	{
		$this->codeant->display();
		//or
		//$this->codeAnt->tpl("frame/index.htm");
		//$this->codeAnt->debug();
	}
	public function getUserInfo()
	{
		$this->codeant->display();
	}
	
}
?>
