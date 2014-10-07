<?php
class StockStructService
{
    public static function GetStructInfo() {
        foreach(ConfigManager::$stocknos as $key => &$stockno) {
            $file = self::GetFileName(ConfigManager::$config['params']['structinfo']['file'], $stockno);
            $url = sprintf(ConfigManager::$config['params']['structinfo']['url'], $stockno);
            //var_dump($file);var_dump($url);die();
            if (file_exists($file) && 0 < filesize($file)) {
                continue;
            }
            $content = CHttp::GetRequest($url, 10);
            if ($content !== false) {
                FileHelper::FilePutContents($file, $content);
            }
        }
    }
    
    public static function GetFileName($format, $stockno) {
        return strftime($format, time()).$stockno;
    }
}