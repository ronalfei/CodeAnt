<?php
include_once("../init/init.php");


try{
	$codeAnt->run();
}catch(Exception $e){
	echo "<br/>\r\n----------exception throw:--------------<br/>\r\n";
	echo $e->getMessage().debug_print_backtrace();
	echo "<br/>\r\n----------------------------------------<br/>\r\n";
}

?>
