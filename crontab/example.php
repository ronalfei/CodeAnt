#!/opt/app/php5/bin/php
<?php	
/**
 * @filesource
 * @abstract 作为进程来执行,一直发送消息队列里的消息到用户中心接口上.
 * @name send_feed.php
 * @example D:\PHP\php.exe d:/workspace/ibet/crontab/send_feed.php
 */
	$_SERVER['NO_CHECK'] = 'YES';//设置不需要进行http认证,并且必须放到init前面
	$program_path = dirname(__FILE__);
	require_once($program_path.'/../init/init.php');
	//die();
	$t1 = time()+microtime();
	set_time_limit(0);//设置脚本执行时间可以任意长
	ini_set('memory_limit','1024M');//设置内存使用最大为1G
	/**
	 * todo here :
	$feed = new common_feed();
	$fp = fopen("send_feed.log","a+");
	try{
		while(true){
			$msg = $feed->get_msg();
			//echo $msg;
			if($msg==false){
				sleep(5);
				$t = date("Y-m-d H:i:s");
				fwrite($fp,$t." sleep 5 \r\n");
			}else{
				$params = $feed->parseData($msg);
				//var_dump($params);
				$tmp_data = json_encode($params[3]->data);
				$vars = "appid={$params[0]->appid}&typeid={$params[1]->typeid}&email={$params[2]->email}&data={$tmp_data}";
				$t = date("Y-m-d H:i:s");
				$ret = $feed->curl_post("http://feed.i.sohu.com/api/writefeed.suc",$vars,0);
				fwrite($fp,$t." {$vars} {$ret}\r\n");
				if(!$ret){
					$mq->set($feed->qm,$msg);
				}
				unset($params);
				unset($tmp_data);
				unset($vars);
				unset($ret);
					
			}
			unset($t);
		}
	}catch(Exception $e){
		file_put_contents("error.log",$e->getMessage(),FILE_APPEND);
	}*/
?>