<?php
/**
 * 数据库扩展
 * 查看sql日志类
 *
 */

class dblog
{
	private static $sqlPath = _SQL_PATH;
	private static $color = array(0=>'red',1=>'blue');
	public static function viewSqlLogByDate($date)
	{
		$filename = self::$sqlPath . 'sql.'.$date.'.log';
		if(file_exists ( $filename)){
			$fa = file($filename);
			$len = count($fa);
			$i = 1;
			$max = 100;
			while($i<$max){
				$m = $i%2;
				$line = array_pop($fa);
				if(empty($line)){
					break;
				}else{
					echo "<font color='",self::$color[$m],"'>",$line,'</font></br></br>';
				}
				$i++;
			}
		}else{
			echo "sql日志不存在:<font color='red'>{$filename}</font>";
		}

	}

	public static function viewTodaySqlLog()
	{
		self::viewSqlLogByDate(date('Ymd'));
	}
}

?>