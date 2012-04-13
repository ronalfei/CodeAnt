<?php
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
