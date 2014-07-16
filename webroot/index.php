<?php


try{
	include_once("../init/init.php");
	$codeAnt->run();
}catch(Exception $e){
	$exception  = "<br/>\r\n----------exception throw:--------------<br/>\r\n";
    $exception .= $e->getMessage();
    $exception .= "<br/>\r\n----------------------------------------<br/>\r\n";
    $codeAnt->log->error($exception);
}catch(cexception $e){
	$exception  = "<br/>\r\n----------cexception throw:--------------<br/>\r\n";
	$exception .= $e->getMessage();
	$exception .= "<br/>\r\n----------------------------------------<br/>\r\n";
	$codeAnt->log->error($exception);
	//echo $exception;
}catch(SmartyException $se){
	$exception = $se->getMessage();
	$codeAnt->log->error($exception);
}


?>
