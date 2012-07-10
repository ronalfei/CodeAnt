<?php
class dao_user extends dao_core
{
	public function __construct()
	{
	}

	public function getUserList($limitSql)
	{
		$sql = "select * from user order by name desc $limitSql";
		return parent::codeAnt()->db->getAll($sql);
		
	}

	public function insertUser($setParams)
	{
		$setParams['user_id'] = self::createUserId();
        $setSql   = parent::codeAnt()->db->compileSetSql($setParams);
        $sql      = "insert into `user` $setSql ";
        return parent::codeAnt()->db->insert($sql);
	}
	
	public function modifyUser($params, $whereParams)
	{
		$setSql     = parent::codeAnt()->db->compileSetSql($params);
		$whereSql   = parent::codeAnt()->db->compileWhereSql($whereParams);
        $sql      = "update `user` $setSql $whereSql ";
        return parent::codeAnt()->db->update($sql);
	}

	public function deleteUser($userId)
	{
		$sql = "delete from user where user_id='{$userId}'";
		return parent::codeAnt()->db->delete($sql);
	}

	public function getUserTotal()
	{
		$result = parent::codeAnt()->db->selectOne('user', array( "count(1)"));
		return intval($result);
	}
	
	public function getUserInfoById($userId)
	{
		$whereParams = Array('user_id'=> $userId);
		return self::getUserInfo($whereParams);
	}

	public function getUserInfo($whereParams)
	{
		return parent::codeAnt()->db->select('user', '', $whereParams);
	}
	
	public function createUserId()
	{
		$time = microtime();
		$tmp = explode(" ", $time);
		$milTime = $tmp[1].$tmp[0]*100000000;
		$random = rand(10, 99);
		return $milTime.$random;
	}


}
?>
