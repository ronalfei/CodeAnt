<?php
/**
 * class rabbitmq 
 * 对rabbitMq的简单发消息的操作接口
 * @author  zhangtaiyang blackAnimal
 *
 */
class rabbitmq{
	private $host;
	private $port;
	private $loginname;
	private $password;
	private $connection;
	private $channel;
	private $exchange;
	private $queue;
	
	//属性的初始化
	public function __construct($host,$port,$loginname,$password){
		$this->host   	= $host;
		$this->port		= $port;
		$this->loginname= $loginname;
		$this->password = $password;
	}
	
	
	/*
	 *AMQPConnection操作
	 */
	//创建
	public function connect(){
		if($this->connection){
			return true;
		}else{
			$amqp_config['host']		= $this->host;
			$amqp_config['vhost']		= '/';
			$amqp_config['port']		= $this->port;
			$amqp_config['login']	= $this->loginname;
			$amqp_config['password']	= $this->password;
			$this->connection = new AMQPConnection($amqp_config);
			$this->connection->connect();
			if ($this->connection->isConnected()) {
			    $this->channel = new AMQPChannel($this->connection);
			} else {
			    return false;
			}
			
		}
	}
	
	
	public function declareExchange($name='', $type=AMQP_EX_TYPE_DIRECT, $flag=AMQP_DURABLE )
	{
		$this->exchange = new AMQPExchange($this->channel);
		if(empty($name)){
			$name = time();
		}
		$this->exchange->setName($name);
		$this->exchange->setType($type);
		$this->exchange->setFlags($flag);
		$this->exchange->declare();
	}
	
	public function declareQueue($queue_name, $queue_flag)
	{
		$this->queue = new AMQPQueue($this->channel);
		$this->queue->setName($queue_name);
		$this->queue->setFlags($queue_flag);
		return $this->queue->declare();
	}
	
	public function queueBindExchange($exchange_name, $router_key)
	{
		return $this->queue->bind($exchange_name, $router_key);
	}
	
	
	public function push($message, $queue_name)
	{
		return $this->exchange->publish($message, $queue_name);
	}

	//关闭连接与AMQP连接。
	public function disconnect(){
		if($this->connection){
			$this->connection->disconnect();
			$this->connection	== FALSE;
			$this->channel		== FALSE;
		}
	}
	
	//删除Exchange
	public function deleteExchange($exchange_name){
		return $this->exchange->delete($exchange_name);
	}
/****************************************************
 * 以下是对队列读取的操作暂不开放

	public function get_message($message, $queue_name, $routing_key,$exchange_name='', $exchange_type = AMQP_EX_TYPE_DIRECT, $flags = 0){
		if($this->qu->declare($exchange_name, $exchange_type, $flags)){
			$messages = $this->qu->get($flags = AMQP_NOACK);
			$this->qu->ack($messages['delivery_tag']);
			return $messages;
		}else{
			echo 'AMQPExchange Statement failure';
		}
	}
	//从路由取消绑定队列
	public function qu_unbind( $exchange_name ,$routing_key ){
		if(!empty($exchange_name) && !empty($routing_key)){
			return $this->qu->unbind( $exchange_name ,$routing_key);
		}else{
			echo 'Missing Parameters';
		}
	}
	//删除队列及其内容。
	public function qu_delete($exchange_name){
		return $qu->delete($$exchange_name);
	}
	
	//清除队列内容
	public function qu_purge($queue_name){
		if(!empty($queue_name)){
			return $this->qu->purge($queue_name);
		}else{
			echo 'Missing Parameters';
		}
	}
	
***************************************************************/
}
?>
