<?php
class StockStructService {
    public static function LoadStructInfo() {
        $stocknos = StockInfoService::GetStockNos();
        foreach($stocknos as $key => &$stockno) {
            $file = self::GetFileName(ConfigManager::$config['params']['structinfo']['file'], $stockno);
            self::LoadStructDetail($stockno, $file);
        }
    }
    
    public static function LoadStructDetail($stockno, $file) {
        if (!file_exists($file) || 0 >= filesize($file)) {
            Log::WriteLog("StockStructService::LoadStructDetail {$file} is empty", 'error');
            return;
        }
        $data = file_get_contents($file);
        
        $ipodate = "2000-01-01";
        $items = self::GetStructDetailItems($stockno, $data, $ipodate);
        //print_r($items);  print_r($ipodate); die();
        if (empty($items)) {
            Log::WriteLog("StockStructService::LoadStructDetail {$file} no struct info", 'error');
            return;
        }
        StockDb::GetInstance()->addStructinfo($items);
        StockDb::GetInstance()->updateStockinfo(array('ipodate' => $ipodate), array('stockno' => $stockno));
    }
    
    public function GetStructDetailItems($stockno, &$content, &$ipodate){ 
        $dom = new DOMDocument();
        if(false === @$dom->loadHTML($content)){
            return false;
        }
        
        $retarr = array();
        if(NULL == $div=$dom->getElementById('con02-1')){return array();}
        if(NULL == $tables=$div->getElementsByTagName('table')) {return array();}

                
        $chineseunit = "万股";
        $chineseunit = iconv(mb_detect_encoding($chineseunit, "auto"), "gbk", $chineseunit);
        
        $listbydate = array();
        foreach ($tables as $table) {
            if(NULL == $trs=$table->getElementsByTagName('tr')) {continue;}            
            if(NULL == $datetds=$trs->item(1)->getElementsByTagName('td')) {continue;}            
            
            $reasontds = $trs->item(4)->getElementsByTagName('td');
            $totaltds = $trs->item(5)->getElementsByTagName('td');
            $acirculationtds = $trs->item(7)->getElementsByTagName('td');
            $alimitedtds = $trs->item(9)->getElementsByTagName('td');
            $bcirculationtds = $trs->item(10)->getElementsByTagName('td');
            $blimitedtds = $trs->item(11)->getElementsByTagName('td');
            $hcirculationtds = $trs->item(12)->getElementsByTagName('td');
            $seniortds = $trs->item(8)->getElementsByTagName('td');
            
            for ($i=1; $i<$datetds->length; ++$i)
            {
                $date = $datetds->item($i)->nodeValue;
                $listbydate[$datetds->item($i)->nodeValue] = array();
                $item = array();
                $item['stockno'] = $stockno;
                $item['date'] = $date;
                
                $total = $totaltds->item($i)->nodeValue;
                $acirculation = $acirculationtds->item($i)->nodeValue;
                $alimited = $alimitedtds->item($i)->nodeValue;
                $bcirculation = $bcirculationtds->item($i)->nodeValue;
                $blimited = $blimitedtds->item($i)->nodeValue;
                $hcirculatio = $hcirculationtds->item($i)->nodeValue;
                $senior = $seniortds->item($i)->nodeValue;
                
                $item['total'] = (float)substr($total,strpos($total,$chineseunit)) * 10000;
                $item['ashares'] = (float)substr($acirculation,strpos($acirculation,$chineseunit)) * 10000;
                $item['alimited'] = (float)substr($alimited,strpos($alimited,$chineseunit)) * 10000;
                $item['bshares'] = (float)substr($bcirculation,strpos($bcirculation,$chineseunit)) * 10000;
                $item['blimited'] = (float)substr($blimited,strpos($blimited,$chineseunit)) * 10000;
                $item['hshares'] = (float)substr($hcirculatio,strpos($hcirculatio,$chineseunit)) * 10000;
                $item['senior'] = (float)substr($senior,strpos($senior,$chineseunit)) * 10000;
                
                $reason = $reasontds->item($i)->nodeValue;
                $item['reason'] = $reason;
                if ($reason == "IPO") {
                    $ipodate = $date;
                }
                
                $listbydate[$date] = $item;
            }
        }
        
        return array_values($listbydate);
    }
    
    
    public static function GetFileName($format, $stockno) {
        return strftime($format, time()).$stockno;
    }
}