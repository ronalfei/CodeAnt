<?php
/**
 * @name:mysqlii类
 * @abstract: 因为默认已经有一个类叫mysqli,所以自己的类名定义为mysqlii
 * @author:fei.wang
 * @date:2011-5-12
 */
class mysqlii
{
	private		$link;				//数据库连接标识
	private		$host;				//数据库主机名
	private 	$port;				//数据库端口
	private		$user;				//数据库连接用户名
	private		$password;			//数据库连接密码
	private		$db_name;			//默认数据库名称
	private		$charset;			//数据库连接字符集
	public		$dbdebug;


	/**
	 * Mysql构造函数
	 *
	 * @param string $host
	 * @param string $user
	 * @param string $password
	 * @param string $db_name
	 * @param string $charset
	 */
	public function __construct($host,$port,$user,$password,$db_name,$charset,$socket="")
	{
		$this -> host		= $host;
		$this -> port		= $port;
		$this -> user		= $user;
		$this -> db_name	= $db_name;
		$this -> charset	= $charset;
		$this -> password	= $password;
			
		$this -> dbdebug	= factory::createDBDebugObject();
	}

    public function escapeString($str)
    {
        $this->connectDb();
        return mysqli_real_escape_string( $this->link , $str);
    }

	private function connectDb()
	{
		if($this->link){
			return true;
		}else{
			//创建数据库连接ID
			$this -> link = mysqli_connect($this->host,$this->user,$this->password,$this->db_name,$this->port) or $this->error("--Can't connect Mysql!".mysqli_connect_error());
			//选择需要使用的数据库
			//设置数据库字符集
			mysqli_set_charset ($this->link , $this->charset );
		}
	}

	/**
	 * 改变连接的数据库
	 *
	 * @param string $basename
	 */
	public function changeBaseName($basename)
	{
		$sql = "use $basename";
		$this->query($sql);
		$this->db_name  = $basename;
	}

    public function changeDB($host,$port,$user,$password,$db_name,$charset)
    {
        if($this->link){
            $this->close();
            $this->link=false;
        }
        $this -> host       = $host;
        $this -> port       = $port;
        $this -> user       = $user;
        $this -> db_name    = $db_name;
        $this -> charset    = $charset;
        $this -> password   = $password;
    }


    public function loadDB($host,$port,$user,$password,$db_name,$charset)
    {
        $another_db = new self($host,$port,$user,$password,$db_name,$charset,"");
        return $another_db;
    }



	/**
	 * SQL语句执行函数
	 *
	 * @param string $sql
	 * @return resource
	 */
	public function query($sql)
	{
		$start_time = time()+microtime();
			
		$this->connectDb();
		$resource	= mysqli_query($this->link,$sql) or $this->error("--Query Language Error:{$sql}". mysqli_error($this->link).debug_print_backtrace() );
			
		$end_time	= time()+microtime();
		$time		= strval($end_time-$start_time);

		$this->dbdebug->setQuery("{$this->host}:{$this->port}",'',$this->db_name,$time,$sql);
		return $resource;
	}


	/**
	 * 返回sql查询的行数
	 *
	 * @param string $sql
	 * @return int rows
	 */
	public function fetchRows($sql)
	{
		$resource = $this->query($sql);
		$numRows  = mysqli_num_rows($resource);
		$this->mysqlii_free_result($resource) or $this->error("--Release Resource Failed".mysqli_error($this->link).debug_print_backtrace() );
		return $numRows;
	}


	/**
	 * @abstract 获取一个字段的数组结果
	 * @abstract sql语句中只能查询一个字段
	 * @param string $sql
	 * @return unknow
	 */
	public function fetchOne($sql)                        //使用此函数，sql语句中必须只有一条记录且只有一个字段
	{
			
		$resource	= $this->query($sql);
		$result		= '';
		while($row = mysqli_fetch_array($resource))
		{
			$result=$row[0];
		}
		$this->mysqlii_free_result($resource) or $this->error("--Release Resource Failed". mysqli_error($this->link).debug_print_backtrace() );
		return $result;
	}

	public function getOne($sql)
	{
		return $this->fetchOne($sql);
	}

	/**
	 * 获取多个字段的数组结果
	 * sql可以为多个字段
	 * 返回一个二维数组
	 * @param string $sql
	 * @return Array
	 */
	public function fetchArray($sql,$sort=MYSQL_RETURN_TYPE)
	{
		$result = array();
		$resource = $this->query($sql);
		while ($row = mysqli_fetch_array($resource,$sort))
		{
			$result[] = $row;
		}
		$this->mysqlii_free_result($resource) or $this->error("--Release Resource Failed". mysqli_error($this->link).debug_print_backtrace()  );
		return $result;
	}

	public function getArray($sql,$sort=MYSQL_RETURN_TYPE)
	{
		return $this->fetchArray($sql,$sort);
	}
	public function getAll($sql,$sort=MYSQL_RETURN_TYPE)
	{
		return $this->fetchArray($sql,$sort);
	}

	public function fetchRow($sql,$sort=MYSQL_RETURN_TYPE)
	{
		$temp = $this->fetchArray($sql,$sort);
		if(!empty($temp)){
			return $temp[0];
		}else{
			return $temp;
		}
	}
	public function getRow($sql,$sort=MYSQL_RETURN_TYPE)
	{
		return $this->fetchRow($sql,$sort);
	}
	
	public function getRows($sql)
	{
		return $this->fetchRow($sql);
	}
	
	public function fetchObject($sql)
	{
		$result = array();
		$resource = $this->query($sql);
		while ($row = mysqli_fetch_object($resource))
		{
			$result[] = $row;
		}
		$this->mysqlii_free_result($resource) or $this->error("--Release Resource Failed". mysqli_error($this->link).debug_print_backtrace()  );
		return $result;
	}
	public function getObject($sql)
	{
		return $this->fetchObject($sql);
	}

	
	public function getResource($sql)
	{
		return $this->query($sql);
	}
	
	/**
	 * 数据库关闭函数
	 * 并且销毁该数据库对象的实例
	 */
	public function close()
	{
		if($this->link){
			mysqli_close($this->link) or $this->error("--Close Database Link Error". mysqli_error($this->link).debug_print_backtrace()  );
			$this->link=false;
		}
	}


	/**
	 * 数据库更新函数
	 *
	 * @param string $sql
	 */
	public function update($sql)
	{
		return $this->query($sql);
	}


	/**
	 * 数据库插入函数
	 *
	 * @param string $sql
	 */
	public function insert($sql)
	{
		if($this->query($sql))
		{
			return true;
			//return $this->getInsertId();
		}
		else
		{
			return false;
		}
	}

	/**
	 * 获取最后一次插入数据库的id号
	 *
	 * @return int $lastId;
	 */
	public function getInsertId()
	{
		return mysqli_insert_id($this->link);
	}


    public function compileSetValue($params)
    {
        $str = "";
        foreach($params as $key=>$value){
            $key = trim($key);
            if(strstr($key,'+')=='+self'){
                $key = strstr($key, '+', true);
                $str  .= " ,`$key`=concat({$key}, '{$value}') ";
            }else{
                if(strtolower(trim($value))=='now()' || $value==='null'){
                    $str .= ",`$key`={$value} ";
                }else{
                    $value = $this->escapeString($value);
                    $str .= ",`$key`='{$value}' ";
                }
            }
        }
        $str = substr($str,1);
        return ' set '.$str;

    }

	public function compileSetSql($params)
	{
		return $this->compileSetValue($params);
	}
	
	public function autoInsert($tableName,$params)
	{
		$set = $this->compileSetValue($params);
		$sql = "insert into `$tableName` ".$set ;
		return $this->insert($sql);
	}

	public function autoReplace($tableName, $params)
	{
		$set = $this->compileSetValue($params);
		$sql = "replace into `$tableName` ".$set;
		return $this->insert($sql);
	}
	
	public function autoUpdate($tableName,$setParams,$whereParams)
	{
		$set	= $this->compileSetValue($setParams);
		$where	= $this->compileWhereSql($whereParams);
		$sql	= " update `$tableName` ".$set.$where;
		return $this->update($sql);
	}
	
	public function compileWhereSql($params)
	{
		$str = Array();
		if(!is_array($params)){
			return ' where  1 ';
		}
		foreach($params as $key=>$value){
			if(empty($value) && $value!==0){
				continue;
			}else{
				$key = trim($key);
				if(strpos($key,'+')===false){
					//查看是否键值中包含".",如a.username之类的key
					if(strpos($key, '.')>0){
						$str[]	= " $key='{$value}' ";
					}else{
						$str[]	= " `$key`='{$value}' ";
					}
					
				}else{
					$symbol	= explode('+',$key);
					if(strtolower(trim($value))=='now()'||$symbol[1]=='between'||$symbol[1]=='in'){
						if(strpos($symbol[0], ')')>0 ){
							$str[]	= " {$symbol[0]} {$symbol[1]} {$value} ";
						}else{
							$str[]	= " {$symbol[0]} {$symbol[1]} {$value} ";
						}
					}else{
						if(strpos($symbol[0], ')')>0 ){
							$str[]	= " {$symbol[0]} {$symbol[1]} '{$value}' ";
						}else{
							$str[]	= " {$symbol[0]} {$symbol[1]} '{$value}' ";
						}
					}
				}
			}
		}
		if(empty($str)){
			$ret = 1;
		}else{
			$ret = implode(' and ',$str);
		}
		return ' where '.$ret;
		
	}
	
	
	public function select($tableName,$field=array(),$where=array(),$order='',$sort='',$start=0,$limit=0)
	{
		//1.解析需要查询的字段,如果空,则默认为*号
		if(empty($field))
		{
			$field[] = '*';
		}
		$fields	= implode(',',$field);
		//2.编译where语句
		$wheres	= $this->compileWhereSql($where);
		//3.解析order by语句
		if(!empty($order)&&!empty($sort)){
			$orders = " order by {$order} {$sort} ";
		}else{
			$orders = " ";
		}
		//4.解析limit语句
		if(empty($start)){
			if(empty($limit)){
				$limits = " ";
			}else{
				$limits = " limit {$limit} ";
			}
		}else{
			if(empty($limit)){
				$limits = " ";
			}else{
				$limits = " limit {$start},{$limit} ";
			}
		}
		//5.得到sql
		$sql = " select {$fields} from {$tableName} {$wheres} {$orders} {$limits}";
		
		return $this->getAll($sql);
	}
	
	public function selectOne($tableName,$field=array(),$where=array(),$order='',$sort='',$start=0,$limit=0)
	{
		$result = $this->select($tableName,$field,$where,$order,$sort,$start,$limit);
		$index = $field[0];
		if(!empty($result[0][$index])){
			return $result[0][$index];
		}else{
			return "";
		}
	}
	
	
	private function mysqlii_free_result($resource)
	{
		mysqli_free_result($resource);
		return true;
	}
	
	
	
	/**
	 * 数据库删除函数
	 *
	 * @param string $sql
	 */
	public function del($sql)
	{
		$this->query($sql);
	}
	public function delete($sql)
	{
		$this->del($sql);
	}
	/**
	 * 析构函数
	 *
	 */
	public function __destruct()
	{
		if($this->link)
		{
			$this->close();
		}
	}
	

	/**
	 * 通常用这个执行多条的插入和更新
	 * Enter description here ...
	 * @param string $sql
	 * @param i-int,d-double,s-string,b-blob $params_type
	 * @param array $array_bind_param
	 */
	public function prepareExec($sql,$params_types,$array_bind_param)
	{
		if ($stmt =	mysqli_prepare($this->link,$sql) or $this->error(mysqli_error($this->link)))
		{
			$length = strlen($params_types);//有几个绑定类型,肯定就有几个绑定变量
			foreach ($array_bind_param as &$value){
				$exec = '$stmt->bind_param(\''.$params_types .'\'';
				for($i=0;$i<$length;$i++) {
					$exec .= ' , $value['.$i.'] ';
				}
				$exec .= ");";
				echo '</br>',$exec ,'</br>';
				eval($exec);
				$stmt->execute();
				$exex = null;
			}
			$stmt->close();
		}else{
			var_dump(mysqli_stmt_get_warnings ( $stmt ));
			debug_print_backtrace();
		}

	}
	private function error($string)
	{
		$t = "";
		$trace = debug_backtrace();
		if(!empty($trace)){
			foreach($trace as $v){
				$args = json_encode($v['args']);
				$t .= "{$v['file']}({$v['line']})->{$v['function']}->[$args]\r\n";
			}
		}
		$string .= "\r\n{$t}";	
		throw new cexception(($string));
	}
	
	public function beginTransaction()
	{
		$this->query("select version()");
		$this->disableAutoCommit();
	}
	public function commit()
	{
		if(mysqli_commit($this->link)==true){
		    $this->query("select 'commit'");
			$this->enableAutoCommit();
			return true;
		}else{
			$this->rollback();
		    $this->query("select 'rollback'");
			$this->enableAutoCommit();
			return false;
		}
	}
	public function rollback()
	{
		mysqli_rollback($this->link);
		$this->enableAutoCommit();
	}
	public function enableAutoCommit()
	{
		mysqli_autocommit($this->link, TRUE);
	}
	public function disableAutoCommit()
	{
		mysqli_autocommit($this->link, FALSE);
	}
}

?>
