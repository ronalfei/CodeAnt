<?php
/**
 * 数据库扩展
 * 调试sql类
 *
 */

class dbdebug
{
	private $queries = Array();


	public function setQuery($host,$port,$database,$time,$sql)
	{
		$key = $host.':'.$port.':'.$database;
		$this->queries[$key][] = Array('time'=>$time,'sql'=>$sql);
		if(_SQL_DEBUG=='Y'){
			if(file_exists ( _SQL_PATH)){
				$filename = _SQL_PATH.'sql.'.date('Ymd').'.log';
				$now  = date('H:i:s');
				$data = "[{$now} {$time}]\t".trim($sql)."; \r\n";
				//判断是否可写
				if( file_exists($filename) && !is_writable($filename) ){//文件存在且不可写
					file_put_contents($filename.'.tmp',$data,FILE_APPEND);
				}else{//文件不存在或者可写
					file_put_contents($filename,$data,FILE_APPEND);
                    if(php_sapi_name()=='cli'){
                        chmod($filename, 0777);
                    }
				}
			}else{
				echo 'sql日志路径不存在:'._SQL_PATH;
			}
		}
	}

	public function getQueries()
	{
		return $this->queries;
	}
}

?>
