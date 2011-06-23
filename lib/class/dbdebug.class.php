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
				$time = date('H:i:s');
				$data = "[{$time}] ".trim($sql)."; \r\n";
				file_put_contents($filename,$data,FILE_APPEND);
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