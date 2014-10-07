<?php
class StockPriceDb extends CBaseMysqlDb
{
	private static $instance = null;

	public static function GetInstance()
	{
		if(self::$instance == null){self::$instance = new StockPriceDb();}
		return self::$instance;
	}
	public function __construct()
	{
		parent::__construct(ConfigManager::$config['params']['database']['stock_price']['host'],
				ConfigManager::$config['params']['database']['stock_price']['user'],
				ConfigManager::$config['params']['database']['stock_price']['password'],
				ConfigManager::$config['params']['database']['stock_price']['database']);
	}

	public function queryDailyPrice($conditions)
	{
		return $this->queryByArray('tb_dailyprice',$conditions);
	}
	public function addDailyPrice($params)
	{
		return $this->addArray('tb_dailyprice',$params);
	}
	public function updateDailyPrice($params,$conditions)
	{
		return $this->updateArray('tb_dailyprice',$params,$conditions);
	}
	public function deleteDailyPrice($conditions)
	{
		return $this->deleteByArray('tb_dailyprice',$conditions);
	}
	public function countDailyPrice($conditions)
	{
		return $this->countByArray('tb_dailyprice',$conditions);
	}
	public function searchDailyPrice($conditions)
	{
		return $this->queryLikeByArray('tb_dailyprice',$conditions);
	}
}