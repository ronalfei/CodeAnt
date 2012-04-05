<?php
class dao_gift extends dao_core
{

	public function getGiftTotal($whereParams)
	{
		$whereSql = parent::codeAnt()->db->compileWhereSql($whereParams);
		$sql = "select count(1) from gift $whereSql";
		return parent::codeAnt()->db->getOne($sql);
		
	}

	public function getGiftList($whereParams, $limitSql)
	{
		$whereSql = parent::codeAnt()->db->compileWhereSql($whereParams);
		$sql = "select * from `gift` $whereSql order by `gift_id` desc $limitSql";
		return parent::codeAnt()->db->getAll($sql);
	}

	private function insertGift($giftParams)
	{
        $setSql   = parent::codeAnt()->db->compileSetSql($giftParams);
        $sql      = "insert into gift $setSql";
        return parent::codeAnt()->db->insert($sql);
	}

	public function receiveGift($giftParams)
	{
		return self::insertGift($giftParams);
	}

	public function giveGift($giftParams)
	{
		if(!empty($giftParams['money']) & $giftParams['money']>0){
			$giftParams['money'] *= -1;
		}
		return self::insertGift($giftParams);
	}

	public function getGiftInfoById($gift_id)
	{
		$sql = "select * from gift where gift_id={$gift_id}";
		return parent::codeAnt()->db->getRow($sql);
	}
	
	public function modifyGift($params, $gift_id)
	{
		$setSql = parent::codeAnt()->db->compileSetSql($params);
		$sql = " update gift {$setSql} where gift_id={$gift_id}";
		return parent::codeAnt()->db->update($sql);
	}
	
}
?>
