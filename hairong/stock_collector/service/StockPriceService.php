<?php
class StockPriceService
{
    public static function GetHistoryPriceInfo() {
        $allnum = 0;
        foreach(ConfigManager::$stocknos as $key => &$stockno) {
            $reqnum = 0;
            self::GetHistoryPriceFromSina($stockno, $reqnum);
            echo "{$stockno}  {$reqnum}\n";
            if ($reqnum > 0) {
                sleep(1);
            }
            $allnum += $reqnum;
        }
        print_r($reqnum);
    }
    public static function GetHistoryPriceFromSina($stockno, &$reqnum) {
        $ipo_date = StockDbService::GetIpoDate($stockno);
        
        $pos1 = strpos($ipo_date, '-');
        $ipo_year = substr($ipo_date, 0, $pos1);
        $ipo_season = self::GetSeason(substr($ipo_date, $pos1 + 1, strrpos($ipo_date,'-') - $pos1 - 1));

        $tm = localtime(time(), true);
        $current_year = $tm['tm_year'] + 1900;
        $current_season = self::GetSeason($tm['tm_mon'] + 1);
        //var_dump($tm['tm_mon'] + 1); var_dump($current_season);die();
        for ($year = $ipo_year; $year <= $current_year; ++$year) {
            $begin = ($year == $ipo_year) ? $ipo_season : 1;
            $end = ($year == $current_year) ? $current_season : 4;
            for ($season = $begin; $season <= $end; ++$season) {
                self::LoadSinaHistoryPrice($stockno, $year, $season, $reqnum);
            }
        }
    }
    public static function LoadSinaHistoryPrice($stockno, $year, $season, &$reqnum) {
        $file = self::GetFileName(ConfigManager::$config['params']['historyprice']['file'], $stockno, $year, $season);
        $url = sprintf(ConfigManager::$config['params']['historyprice']['url'], $stockno, $year, $season);
        //var_dump($file); var_dump($url); die();
        if (file_exists($file) && 0 < filesize($file)) {
            return;
        }
        //$url = "http://192.168.10.112:8008/test/ssesuggestdata.js";
        
        /** Get History data through web colloctor(web server writen in c++)*/
        /*
        $collector_url = sprintf(ConfigManager::$config['params']['historyprice']['collector_url'], urlencode($file), urlencode($url));
        CHttp::GetRequest($collector_url, 3);
        $reqnum++;
        //die();
        usleep(100*1000);
        return;
        */
        
        /** Get History data through curl and save the data to file*/
        $content = CHttp::GetRequest($url, 10);
        if ($content !== false) {
            FileHelper::FilePutContents($file, $content);
        }
    }
    public static function GetSeason($month) {
        return ceil($month / 4);
    }
    public static function GetFileName($format, $stockno, $year, $season) {
        return strftime($format, time()).$stockno.'/'.$year.'_'.$season;
    }
}