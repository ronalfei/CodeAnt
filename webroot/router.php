<?php
include_once("../init/init.php");


try{
	$codeAnt->run();
}catch(Exception $e){
	$exception  = "<br/>\r\n----------exception throw:--------------<br/>\r\n";
	$exception .= $e->getMessage().debug_print_backtrace();
	$exception .= "<br/>\r\n----------------------------------------<br/>\r\n";
	echo $exception;
	$codeAnt->log->error($exception);
}

?>
