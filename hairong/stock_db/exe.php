<?php
require_once(dirname( __FILE__ )."/init.php");

$commands = array(
    'stockinfo' => array('class'=>'StockInfoService','function'=>'LoadStockInfo'),
    'structinfo' => array('class'=>'StockStructService','function'=>'LoadStructInfo'),
    'historyprice' => array('class'=>'StockPriceService','function'=>'LoadHistoryPrice'),
    'getstockno' => array('function'=>'GetStockNos'),
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

function GetStockNos() {
    $nos = StockInfoService::GetStockNos();
    $str = '';
    for ($i = 0; $i < count($nos); ++$i) {
        $str .= '\''.$nos[$i].'\',';
        if (($i + 1) % 10 == 0) {
            $str .= "\n";
        }
    }
    echo $str;
}
