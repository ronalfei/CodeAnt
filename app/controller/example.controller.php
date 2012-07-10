<?php
//------------------------------------------------------
//控制器类名必须以controller_开头,同时需要继承controller
//方法名必须以action_开头
//每个控制器都会有一个核心对象codeant,
//可以通过$this->codeant来调用该变量,以及codeant所包含的方法
//----------------------------------------------------------------

class controller_example extends controller
{
	public function action_index()
	{
		$this->codeant->display();
		//or
		//$this->codeAnt->tpl("frame/index.htm");
		//$this->codeAnt->debug();
	}
	public function action_bottom()
	{
		$this->codeant->display();
	}
	
}
?>
