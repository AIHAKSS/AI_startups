<?php
class StockInfoService
{
    public static function LoadStockInfo() {
        self::LoadSSStockInfo();
        self::LoadSZStockInfo();
    }
    public static function LoadSSStockInfo() {
        $file = self::GetFileName(ConfigManager::$config['params']['stockinfo']['ss']['file']);
        $data = file_get_contents($file);
        if(empty($data)){
            Log::WriteLog("StockInfoService::LoadSSStockInfo file is empty",'error');
            return false;
        }
         
        $matches = array();
        $num = preg_match_all ("/(val:\")(.*)(\",val2:\")(.*)(\",val3:\")(.*)(\"}\))/", $data, $matches);
        if($num === false){
           Log::WriteLog("StockInfoService::LoadSSStockInfo failed, invalidate data", 'error');
           return false;
        }
        
        for ($i = 0; $i < $num; ++$i) {
           $item = array('stockno'=>$matches[2][$i],'name'=>$matches[4][$i],
               'abbreviation'=>$matches[6][$i], 'name'=>'SS');
           self::AddStockInfo($item);
        }
         
        return true;
    }
    public static function LoadSZStockInfo() {
        $file = self::GetFileName(ConfigManager::$config['params']['stockinfo']['sz']['file']);
        $data = file_get_contents($file);
        if(empty($data)){
            Log::WriteLog("StockInfoService::LoadSZStockInfo file is empty",'error');
            return false;
        }

        $data = preg_replace("/[\s]*/", '',$data);
        $data = str_replace('</tr>', "</tr>\n",$data);

        $pattern = "/(<tr[^>]*>)(.*)(<\/tr>)/";
        $data = iconv('GBK', "utf-8", $data);
        $num = preg_match_all($pattern, $data, $matches);

        for ($i = 1; $i < $num; ++$i) {
            $record = preg_replace("/<td[^>]*>/", "",$matches[2][$i]);
            $recordarr = explode("</td>",$record);

            /*  Array([0] => 公司代码,[1] => 公司简称,[2] => 公司全称,[3] => 英文名称,[4] => 注册地址,[5] => A股代码,[6] => A股简称
            ,[7] => A股上市日期,[8] => A股总股本,[9] => A股流通股本,[10] => B股代码,[11] => B股简称,[12] => B股上市日期,[13] => B股总股本
            ,[14] => B股流通股本,[15] => 地区,[16] => 省份,[17] => 城市,[18] => 所属行业,[19] => 公司网址,[20] => ) */

            if(count($recordarr) < 20){continue;}

            $item = array('stockno'=>$recordarr[5],'name'=>$recordarr[6],
                'abbreviation'=>ChineseTool::GetFirstLetter($recordarr[6]), 'name'=>'SZ');
            self::AddStockInfo($item);
        }
         
        return true;
    }
    
    public static function AddStockInfo($item) {
        if (false === StockDb::GetInstance()->addStockinfo($item)) {
            Log::WriteLog("StockInfoService::AddStockInfo add item failed, ".var_export($item, true), 'error');
        }
    }
    
    public static function GetStockNos() {
        $stocknos = array();
        $ret = StockDb::GetInstance()->queryStockinfo(array());
        foreach( $ret as $key => &$item) {
            $stocknos[] = $item['stockno'];
        }
        return $stocknos;
    }
    
    public static function GetFileName($format) {
        return strftime($format, time());
    }
    
}