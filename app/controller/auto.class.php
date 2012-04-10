<?php
class auto extends controller
{
	public function index()
	{
		$this->codeAnt->display();
		//or
		//$this->codeAnt->tpl("frame/index.htm");
		$this->debug->display();
	}
}
?>
