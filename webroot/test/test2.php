<?php
$_SERVER['NO_CHECK'] = 1;
require_once('../../init/init.php');

function f($a){
	if($a===1){
		return false;
	}
}
//var_dump(f(2)); /* 结果是null*/



static $a = 5;
$b = &$a;
$a=null;
unset($a);
echo $a,'.';

echo $b,'.';

die();




class SomeIterator implements Iterator{
	private $myArray;
	function __construct($obj)
	{
		$this->myArray = $obj;
		//print_r($this->myArray);
	}
	function rewind() {
		return reset($this->myArray);
	}
	function current() {
		return current($this->myArray);
	}
	function key() {
		return key($this->myArray);
	}
	function next() {
		return next($this->myArray);
	}
	function valid() {
		return key($this->myArray) !== null;
	}
}

$obj = json_decode(json_encode(Array('1' => 'fei','2'=>'wang')));
$obj = new cache();
//var_dump(json_decode($obj));
$obj->iterateVisible1();



class MysqlResult implements Iterator
{
	private $result;
	private $position;
	private $row_data;
	 
	public function __construct ($result)
	{
		$this->result = $result;
		$this->position = 0;
	}
	 
	public function current ()
	{
		return $this->row_data;
	}
	 
	public function key ()
	{
		return $this->position;
	}
	 
	public function next ()
	{
		$this->position++;
		$this->row_data = mysql_fetch_assoc($this->result);
	}

	public function rewind ()
	{
		$this->position = 0;
		mysql_data_seek($this->result, 0);
		 
		/* The initial call to valid requires that data
		 pre-exists in $this->row_data
		 */
		$this->row_data = mysql_fetch_assoc($this->result);
	}

	public function valid ()
	{
		return (boolean) $this->row_data;
	}
}
$link = mysql_connect("192.168.106.157:12315","ronalfei","batisfei","12315");
//var_dump($link);
mysql_select_db('IBET', $link);
$obj = mysql_query("SELECT * FROM `USERS` limit 1");
$result = new MysqlResult($obj);
//var_dump($result);
echo "</br>";
foreach ($result as $pos => $row) {
	//var_dump($pos, $row);
}
?>