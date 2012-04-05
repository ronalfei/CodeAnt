<?php
include_once("../init/init.php");


try{
	$codeAnt->run();
}catch(Exception $e){
	echo "<br/>\r\n----------exception throw:--------------<br/>\r\n";
	echo $e->getMessage().debug_print_backtrace();
	echo "<br/>\r\n----------------------------------------<br/>\r\n";
}
//$class		= $codeAnt->input->get('c');
//$function	= $codeAnt->input->get('f');
//$args		= $codeAnt->input->get('a');
//
//
//$params		= explode($args,'/');
//
//$object		= new $class();
//call_user_func_array($object, $function, $params);
//

?>
