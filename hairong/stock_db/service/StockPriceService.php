<?php
class StockPriceService
{
    public static function LoadHistoryPrice($day="")
    {
        $stocknos = StockInfoService::GetStockNos();
        foreach($stocknos as $key => $stockno) {
            $stockno = '600000';
            self::LoadSinaHistoryPrice($stockno, $day);
            die();
        }
    }
    public static function LoadSinaHistoryPrice($stockno, $day) {
        $dir = self::GetDirName(ConfigManager::$config['params']['historyprice']['file'], $day, $stockno);
        if (!file_exists($dir) || false ===  ($handle = opendir($dir))) {
            Log::WriteLog("StockPriceService::LoadSinaHistoryPrice no dir[{$dir}]", 'error');
            return;
        }
        $list = array();
        while(false !== ($file = readdir($handle))) {
            if(4 == strpos($file, '_')) {
                self::LoadSinaHistoryPriceFile($stockno, $dir.'/'.$file, $list);
            }
        }
        closedir($handle);
        //print_r($list);
        StockPriceDb::GetInstance()->addDailyPrice($list);
    }
    public static function LoadSinaHistoryPriceFile($stockno, $file, &$list) {
        if (!file_exists($file) || 0 >= filesize($file)) {
            Log::WriteLog("StockPriceService::LoadSinaHistoryPriceFile [{$file}] is empty", 'error');
            return;
        }
        $content = file_get_contents($file);
    
        $dom = new DOMDocument();
        if(false === @$dom->loadHTML($content)){
            return array();
        }
        
        $table = $dom->getElementById('FundHoldSharesTable');
        if($table==NULL){return array();}
        //echo $table->node_value, PHP_EOL;die();
        $trlist = $table->getElementsByTagName('tr');
        
        $first = true;
        foreach ($trlist as $tr) 
        {
            $item = array();
            $tdlist = $tr->getElementsByTagName('td');
            if ($tdlist->length!=7){continue;}
            
            $item["stockno"]   =  $stockno;
            $item["date"]   =  trim($tdlist->item(0)->nodeValue);
            $item["open"]   =  $tdlist->item(1)->nodeValue;
            $item["high"]   =  $tdlist->item(2)->nodeValue;
            $item["close"]  =  $tdlist->item(3)->nodeValue;
            $item["low"]    =  $tdlist->item(4)->nodeValue;
            $item["volume"] =  $tdlist->item(5)->nodeValue;
            $item["turnover"]  =  $tdlist->item(6)->nodeValue;
        
            if($first){$first=false;continue;}
            $list[] = $item;
        }
    }
    public static function GetDirName($format, $day, $stockno) {
        $time = empty($day) ? time() : strtotime($day);
        return strftime($format, $time).$stockno;
    }
}