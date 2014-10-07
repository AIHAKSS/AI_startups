<?php
class StockDbService
{
    public static function GetStockNos() {
        $stocknos = array();
        $ret = StockDb::GetInstance()->queryStockinfo(array());
        foreach( $ret as $key => &$item) {
            $stocknos[] = $item['stockno'];
        }
        return $stocknos;
    }
    public static function GetIpoDate($stockno) {
        $info = self::GetStockInfoByStockNo($stockno);
        return empty($info['ipodate'])?'2000-01-01':$info['ipodate'];
    }
    public static function GetStockInfoByStockNo($stockno) {
        $ret = StockDb::GetInstance()->queryStockinfo(array("stockno"=>$stockno));
        return empty($ret)?array():$ret[0];
    }
    
}