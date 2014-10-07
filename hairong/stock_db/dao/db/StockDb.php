<?php
class StockDb extends CBaseMysqlDb
{
	private static $instance = null;

	public static function GetInstance()
	{
		if(self::$instance == null){self::$instance = new StockDb();}
		return self::$instance;
	}
	public function __construct()
	{
		parent::__construct(ConfigManager::$config['params']['database']['stock']['host'],
				ConfigManager::$config['params']['database']['stock']['user'],
				ConfigManager::$config['params']['database']['stock']['password'],
				ConfigManager::$config['params']['database']['stock']['database']);
	}

	public function queryData($conditions)
	{
		return $this->queryByArray('tb_data',$conditions);
	}
	public function addData($params)
	{
		return $this->addArray('tb_data',$params);
	}
	public function updateData($params,$conditions)
	{
		return $this->updateArray('tb_data',$params,$conditions);
	}
	public function deleteData($conditions)
	{
		return $this->deleteByArray('tb_data',$conditions);
	}
	public function countData($conditions)
	{
		return $this->countByArray('tb_data',$conditions);
	}
	public function searchData($conditions)
	{
		return $this->queryLikeByArray('tb_data',$conditions);
	}

	public function queryFundflow_day($conditions)
	{
		return $this->queryByArray('tb_fundflow_day',$conditions);
	}
	public function addFundflow_day($params)
	{
		return $this->addArray('tb_fundflow_day',$params);
	}
	public function updateFundflow_day($params,$conditions)
	{
		return $this->updateArray('tb_fundflow_day',$params,$conditions);
	}
	public function deleteFundflow_day($conditions)
	{
		return $this->deleteByArray('tb_fundflow_day',$conditions);
	}
	public function countFundflow_day($conditions)
	{
		return $this->countByArray('tb_fundflow_day',$conditions);
	}
	public function searchFundflow_day($conditions)
	{
		return $this->queryLikeByArray('tb_fundflow_day',$conditions);
	}

	public function queryFundflow_time($conditions)
	{
		return $this->queryByArray('tb_fundflow_time',$conditions);
	}
	public function addFundflow_time($params)
	{
		return $this->addArray('tb_fundflow_time',$params);
	}
	public function updateFundflow_time($params,$conditions)
	{
		return $this->updateArray('tb_fundflow_time',$params,$conditions);
	}
	public function deleteFundflow_time($conditions)
	{
		return $this->deleteByArray('tb_fundflow_time',$conditions);
	}
	public function countFundflow_time($conditions)
	{
		return $this->countByArray('tb_fundflow_time',$conditions);
	}
	public function searchFundflow_time($conditions)
	{
		return $this->queryLikeByArray('tb_fundflow_time',$conditions);
	}

	public function queryStockinfo($conditions)
	{
		return $this->queryByArray('tb_stockinfo',$conditions);
	}
	public function addStockinfo($params)
	{
		return $this->addArray('tb_stockinfo',$params);
	}
	public function updateStockinfo($params,$conditions)
	{
		return $this->updateArray('tb_stockinfo',$params,$conditions);
	}
	public function deleteStockinfo($conditions)
	{
		return $this->deleteByArray('tb_stockinfo',$conditions);
	}
	public function countStockinfo($conditions)
	{
		return $this->countByArray('tb_stockinfo',$conditions);
	}
	public function searchStockinfo($conditions)
	{
		return $this->queryLikeByArray('tb_stockinfo',$conditions);
	}

	public function queryStructinfo($conditions)
	{
		return $this->queryByArray('tb_structinfo',$conditions);
	}
	public function addStructinfo($params)
	{
		return $this->addArray('tb_structinfo',$params);
	}
	public function updateStructinfo($params,$conditions)
	{
		return $this->updateArray('tb_structinfo',$params,$conditions);
	}
	public function deleteStructinfo($conditions)
	{
		return $this->deleteByArray('tb_structinfo',$conditions);
	}
	public function countStructinfo($conditions)
	{
		return $this->countByArray('tb_structinfo',$conditions);
	}
	public function searchStructinfo($conditions)
	{
		return $this->queryLikeByArray('tb_structinfo',$conditions);
	}

}