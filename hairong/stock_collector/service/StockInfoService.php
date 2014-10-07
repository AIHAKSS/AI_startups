<?php
class StockInfoService
{
    public static function GetStockList() {
        $items = ConfigManager::$config['params']['stockinfo'];
        foreach($items as $key => &$item) {
            $url = $item['url'];
            $file = self::GetFileName($item['file']);
            $content = CHttp::GetRequest($url, 10);
            if ($content !== false) {
                FileHelper::FilePutContents($file, $content);
            }
        }
    }
    
    public static function GetFileName($format) {
        return strftime($format, time());
    }
}