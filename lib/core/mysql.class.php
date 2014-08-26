<?php
/**
 * mysql类
 * author:fei.wang
 */
class mysql
{
    private		$link;				//数据库连接标识
    private		$host;				//数据库主机名或ip
    private		$port;				//数据库端口
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
    public function __construct($host,$port,$user,$password,$db_name,$charset)
    {
        $this -> host		= $host;
        $this -> port		= $port;
        $this -> user		= $user;
        $this -> db_name	= $db_name;
        $this -> charset	= $charset;
        $this -> password	= $password;

        $this -> dbdebug	= factory::createDBDebugObject();
    }

    private function connectDb()
    {
        if($this->link){
            return true;
        }else{
            //创建数据库连接ID
            $this -> link = mysql_connect("{$this->host}:{$this->port}",$this->user,$this->password) or $this->error("--Can't connect Mysql!".mysql_error());
            //选择需要使用的数据库
            $sql = "use $this->db_name";
            mysql_query($sql,$this->link) or $this->error( mysql_error());
            //设置数据库字符集
            $sql = "SET character_set_connection='".$this->charset."', character_set_results='".$this->charset."', character_set_client=binary";
            //$sql = "SET NAMES $this->charset";
            mysql_query($sql,$this->link);
        }
    }

    /**
     * 改变连接的数据库名
     *
     * @param string $basename
     */
    public function changeBaseName($basename)
    {
        $sql = "use $basename";
        $this->query($sql);
        $this->db_name  = $basename;
    }

    public function changeDBName($basename)
    {
        $this->changeBaseName($basename);
    }


    /**
     * 改变数据库服务的连接
     * Enter description here ...
     * @param unknown_type $host
     * @param unknown_type $port
     * @param unknown_type $user
     * @param unknown_type $password
     * @param unknown_type $db_name
     * @param unknown_type $charset
     */
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



    public function changeDBServer($host, $port, $user, $password, $db_name, $charset)
    {
        $this->changeDB($host, $port, $user, $password, $db_name, $charset);
    }

    /**
     * SQL语句执行函数
     *
     * @param string $sql
     * @return resource
     */
    private function query($sql)
    {
        $start_time = time()+microtime();

        $this->connectDb();
        $resource	= mysql_query($sql,$this->link) or $this->error("--Query Language Error:{$sql}". mysql_error());

        $end_time	= time()+microtime();
        $time		= strval($end_time-$start_time);

        $this->dbdebug->setQuery($this->host,'',$this->db_name,$time,$sql);
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
        $numRows  = mysql_num_rows($resource);
        mysql_free_result($resource) or $this->error("--Release Resource Failed".mysql_error() );
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
        while($row = mysql_fetch_array($resource))
        {
            $result=$row[0];
        }
        mysql_free_result($resource) or $this->error("--Release Resource Failed". mysql_error());
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
        while ($row = mysql_fetch_array($resource,$sort))
        {
            $result[] = $row;
        }
        mysql_free_result($resource) or $this->error("--Release Resource Failed". mysql_error()  );
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
        while ($row = mysql_fetch_object($resource))
        {
            $result[] = $row;
        }
        mysql_free_result($resource) or $this->error("--Release Resource Failed". mysql_error() );
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
            mysql_close($this->link) or $this->error("--Close Database Link Error". mysql_error());
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
            //return true;
            return $this->getInsertId();
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
        $sql	=	"select last_insert_id()";
        $lastId	=	$this->fetchOne($sql);
        if(empty($lastId)){
            $lastId = 0;
        }
        return $lastId;
    }


    public function compileSetValue($params)
    {
        $str = "";
        foreach($params as $key=>$value){
            $key = trim($key);
            if(strstr($key,'+')=='+self'){
                $str .= " ,`$key`=concat({$key}, '{$value}') ";
            }else{
                if(strtolower(trim($value))=='now()' || $value==='null'){
                    $str .= ",`$key`={$value} ";
                }else{
                    $str .= ",`$key`='{$value}' ";
                }
            }
        }
        $str = substr($str,1);
        return ' set '.$str;

    }

    public function autoInsert($tableName,$params)
    {
        $set = $this->compileSetValue($params);
        $sql = "insert into `$tableName` ".$set ;
        return $this->insert($sql);
    }

    public function autoUpdate($tableName,$setParams,$whereParams)
    {
        $set	= $this->compileSetValue($setParams);
        $where	= $this->compileWhereSql($whereParams);
        $sql	= " update `$tableName` ".$set.$where." limit 1";
        return $this->update($sql);
    }

    public function compileWhereSql($params)
    {
        $str = Array();

        foreach($params as $key=>$value){
            if(strpos($key,'+')===false){
                //查看是否键值中包含".",如a.username之类的key
                if(strpos($key, '.')>0){
                    $str[]	= " $key='{$value}' ";
                }else{
                    $str[]	= " `$key`='{$value}' ";
                }

            }else{
                $symbol	= explode('+',$key);
                if(trim($value)=='now()'||$symbol[1]=='between'||$symbol[1]=='in'){
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
        $ret = implode(' and ',$str);
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

}

?>
