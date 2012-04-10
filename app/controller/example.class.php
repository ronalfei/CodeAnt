<?php
class example extends controller
{
	public function index()
	{
		$this->codeant->display();
		//or
		//$this->codeAnt->tpl("frame/index.htm");
		//$this->codeAnt->debug();
	}
	public function bottom()
	{
		$this->codeant->display();
	}
	
	public function menu()
    {
        $this->codeant->display();
    }

	public function content()
    {
        $this->codeant->display();
    }
	
	public function top()
	{
		$this->codeant->display();
	}
}
?>
