<?php
/**
 * @name:mongodb类
 * @abstract: 因为默认已经有一个类叫mysqli,所以自己的类名定义为mongo
 * @author:fei.wang
 * @date:2011-5-12
 */
class mongodbi
{
	private		$connection;        //数据库连接标识
	private		$db;                //数据库连接标识
	private		$host;				//数据库主机名
	private 	$port;				//数据库端口
	private		$user;				//数据库连接用户名
	private		$password;			//数据库连接密码
	private		$db_name;			//默认数据库名称
	private		$options;			//
	private     $error;


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
		$this-> host		= $host;
		$this-> port		= $port;
		$this-> user		= $user;
		$this-> db_name     = $db_name;
		$this-> charset     = $charset;
		$this-> password	= $password;
	}

    public function connectDB()
    {
        if($this->connection){
            return true;
        }else{
            //创建数据库标识
            $dsn = "mongodb://{$this->host}:{$this->port}";
            try{
                $this->connection= new MongoClient($dsn);//不选择数据库
                return $this->changeBaseName($this->db_name);
            }catch(MongoConnectionException $e){
                $this->error = $e->getMessage();
                return false;
            }
        }
    }




    /** 
     * 改变连接的数据库名称
     *
     * @param string $basename
     */
    public function changeBaseName($basename)
    {   
        $this->db = $this->connection->selectDB($basename);
        return true;
    } 


    /**
     *获取所有的数据库
     *
     */
    public function getDbs(){
        $this->connectDB();
        return $this->connection->listDBs();
    }

    /**   
     * 更新记录   
     *   
     * @param $table  : 表名   
     * @param $where  : 更新条件   
     * @param $options: 更新选择
     *   
     * @return true/false   
     */
    public function update($table, $where, $new_data_array, $option=array())
    {
        $option['safe'] = 1;
        try{        
            $this->connectDB();
            $set_array = array('$set'=>$new_data_array);
            $this->db->$table->update($where, $set_array, $option);
            return true;
        }catch(MongoCursorException $e){
            $this->error = $e->message();
            return false;
        }
    }
    /**   
     * 删除记录   
     *   
     * @param $table  : 表名   
     * @param $where  : 删除条件   
     * @param $options: 删除选择  
     *   
     * @return true/false 
     */
    public function delete($table, $where, $option=array())
    {
        $option['safe'] = 1;
        try{
            $this->connectDB();
            $this->db->$table->remove($where);
            return true;
        }catch(MongoCursorException $e){
            $this->error = $e->message();
            return false;
        }
    }
    public function remove($table, $where, $option=array())
    {
        return $this->delete($table, $where, $option);
    }

    /**
     *插入数据
     * @param $table  : 表名
     * @param $array  :插入的数据
     * @param $wehre  :是否安全写入
     *
     */
    public function insert($table, $data_array, $option = array())
    {
        try{
            $this->connectDB();
            $this->db->$table->insert($data_array, $option);
            return true;
        }catch(MongoCursorException $e){
            $this->error = $e->message();
            return false;
        }
    }

    public function save($table, $data_array, $option=array())
    {
        return $this->save($table, $data_array, $option);
    }

    /**
     * 获取某个字段
     * @param $table  : 表名
     * @param $wehre  : 查询数据的条件
     * @param $fields : 要获取的字段名称
     * @return array
     */
    public function fetchOne($table, $where, $fields)
    {
        try{
            $this->connectDB();
            $array = $this->db->$table->findOne($where, $fields);
            return $array;
        }catch(MongoCursorException $e){
            $this->error = $e->message();
            return false;
        }
    }

    public function getOne($table, $where=array(), $fields=array())
    {
        return $this->fetchOne($table, $where, $fields);
    }
    /**
     * 获取一条数据
     * @param $table  : 表名
     * @param $wehre  : 查询数据的条件
     *
     * @return array
     */
    public function fetchRow($table, $where=Array())
    {
        try{
            $this->connectDB();
            $array = $this->db->$table->findOne($where);
            return $array;
        }catch(MongoCursorException $e){
            $this->error = $e->message();
            return false;
        }
    }

    public function getRow($table, $where=Array())
    {
        return $this->fetchRow($table, $where);
    }
    /**
     * 获取一条数据
     * @param $table  : 表名
     * @param $wehre  : 查询数据的条件
     * @param $fields : 要获取字段名称
     * @return array
     */
    public function fetchAll($table, $where=array(), $fields=array(), $options=array())
    {
        try{
            $this->connectDB();
            $row  = $this->db->$table->find($where, $fields);
            if(!empty($options['skip'])){     
                $row = $row->skip($options['skip']);     
            }
            if (!empty($options['limit'])){
                $row = $row->limit($options['limit']);     
            }
            if (!empty($options['sort'])){     
                $row = $row->sort($options['sort']);     
            }   
            return iterator_to_array($row,false);
        }catch(MongoCursorException $e){
            $this->error = $e->message();
            return false;
        }

    }
    
    public function getCount($table, $where=array())
    {
        try{
            $this->connectDB();
            return $this->db->$table->find($where)->count();
        }catch(MongoCursorException $e){
            $this->error = $e->message();
            return false;
        }
    }
    public function getAggregate($table, $ops)
    {
        try{
            $this->connectDB();
            return $this->db->$table->aggregate($ops);
        }catch(MongoCursorException $e){
            $this->error = $e->message();
            return false;
        }
    } 
    public function getAll($table, $where=array(), $fields=array(), $options=array())
    {   
        return $this->fetchAll($table, $where, $fields, $options);

    }

    /**
     * 获取当前错误信息 
     * 
     * 参数：无   
     * 
     * 返回值：当前错误信息
     */
    public function getError()     
    {     
        return $this->error;     
    }

    public function close()
    {
        $this->connection->close();
        $this->connection = false;
    }

    public function __destruct()
    {
        if(!empty($this->connection)){
            $this->close();
        }
    }

}

//test code here:
//$db = new mongodbi('10.100.1.246:30000','zhangtaiyang1', array());
//function update($db){
//$list = $db->fetchAll('user');
//$a = 1;
//foreach($list as $v){
//  $where['_id'] = $v['_id'];
//  $addData['$set'] = array('age'=>$a);
//  $status = $db->update('user',$where,$addData);
//  $a++;
//}
//}
//function getAll($db){
//  $data = $db->fetchAll('user');
//print_r($data);
//}
//function insert($db){
//  $one = $db->getAll('user',array(), array('age'), array('limit'=>'1','sort'=>array('age'=>-1)));
//  $array = array('name'=>'zhang','age'=>($one['0']['age']+1),'sex'=>'nan');
//  $status = $db->insert('user',$array);
//}
//update($db);
//insert($db);
//getAll($db);
//$obj = new mongo('10.100.1.246:30000');
//$obj->zhangtaiyang1->usre->update(array(['_id']=>'51e7c65c0b1637d14082d3f2'),array('$set'=>array('age'=>'18)));
//var_dump($obj->connection)
//$dbs = $obj->getDbs();
?>
