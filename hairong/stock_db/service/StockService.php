<?php
class StockService
{
	public static function QueryStockinfo($conditions=array())
	{
		return StockDb::GetInstance()->queryStockinfo($conditions);
	}
	public static function AddStockinfo($params)
	{
		return StockDb::GetInstance()->addStockinfo($params);
	}
	public static function UpdateStockinfo($params,$conditions)
	{
		return StockDb::GetInstance()->updateStockinfo($params,$conditions);
	}
	public static function DeleteStockinfo($conditions=array())
	{
		return StockDb::GetInstance()->deleteStockinfo($conditions);
	}
	public static function CountStockinfo($conditions=array())
	{
		return StockDb::GetInstance()->countStockinfo($conditions);
	}
	public static function SearchStockinfo($conditions=array())
	{
		return StockDb::GetInstance()->searchStockinfo($conditions);
	}

	public static function QueryStructinfo($conditions=array())
	{
		return StockDb::GetInstance()->queryStructinfo($conditions);
	}
	public static function AddStructinfo($params)
	{
		return StockDb::GetInstance()->addStructinfo($params);
	}
	public static function UpdateStructinfo($params,$conditions)
	{
		return StockDb::GetInstance()->updateStructinfo($params,$conditions);
	}
	public static function DeleteStructinfo($conditions=array())
	{
		return StockDb::GetInstance()->deleteStructinfo($conditions);
	}
	public static function CountStructinfo($conditions=array())
	{
		return StockDb::GetInstance()->countStructinfo($conditions);
	}
	public static function SearchStructinfo($conditions=array())
	{
		return StockDb::GetInstance()->searchStructinfo($conditions);
	}

}