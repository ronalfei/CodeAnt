<?php
header('Content-Type:text/html;Charset=utf-8');

if(isset($_SERVER['PHP_AUTH_USER'])&&isset($_SERVER['PHP_AUTH_PW'])&&!empty($_SERVER['PHP_AUTH_PW'])&&!empty($_SERVER['PHP_AUTH_PW'])){
	if(empty($check_users)){
		header("Location:index.php");
		die();
	}
	if($check_users[$_SERVER['PHP_AUTH_USER']]!=$_SERVER['PHP_AUTH_PW']){
		echo '当前时间:',date('Y-m-d H:i:s'),'<br/>','系统提示:用户名或密码错误!';
		header('WWW-Authenticate: Basic realm="Ibet"');
		header('HTTP/1.0 401 Unauthorized');
		die();
	}else{
		//直接不予理会,因为login.php是被加载到init文件中的.
	}
}else{
	header("Authentication Required");
	header('WWW-Authenticate: Basic realm="Ibet Center UserName:guest PassWord:guest"');
	header('HTTP/1.0 401 Unauthorized');
	echo '当前时间:',date('Y-m-d H:i:s'),'<br/>','<strong>系统提示</strong>:该系统需要先登录后才能进行操作!';
	die();
}

?>