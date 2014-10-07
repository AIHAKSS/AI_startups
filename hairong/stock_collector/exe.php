<?php
require_once(dirname( __FILE__ )."/init.php");

$commands = array(
    'stocklist' => array('class'=>'StockInfoService','function'=>'GetStockList'),
    'stockstructinfo' => array('class'=>'StockStructService','function'=>'GetStructInfo'),
    'historyprice' => array('class'=>'StockPriceService','function'=>'GetHistoryPriceInfo'),
);

if (in_array(@$argv[1], array_keys($commands))) {
    if (empty($commands[$argv[1]]['class'])) {
        $commands[$argv[1]]['function']();
    } else {
        $commands[$argv[1]]['class']::$commands[$argv[1]]['function']();
    }
} else {
    print("Usage: ".$argv[0]. " ".implode('|',array_keys($commands))."\n");
}


