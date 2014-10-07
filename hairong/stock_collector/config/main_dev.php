<?php
return array(
	'params' => array(
        'stockinfo' => Array(
            'ss_a' => array(
                'file' => '/home/zhr/data/stock/stockinfo/%Y_%m/ss_a',
                'url' => 'http://192.168.10.112:8008/test/ssesuggestdata.js',
            ),
            'sz_a' => array(
                'file' => '/home/zhr/data/stock/stockinfo/%Y_%m/sz_a',
                'url' => 'http://192.168.10.112:8008/test/sz.html',
            ),
        ),
        'structinfo' => array(
            'file' => '/home/zhr/data/stock/structinfo/%Y_%m/',  //stockno
            'url' => 'http://vip.stock.finance.sina.com.cn/corp/go.php/vCI_StockStructure/stockid/%s.phtml'
        ),
        'historyprice' => array(
            'file' => '/home/zhr/data/stock/historyprice/%Y_%m_%d/', //  /stockno/year_season
            'url' => 'http://money.finance.sina.com.cn/corp/go.php/vMS_MarketHistory/stockid/%s.phtml?year=%s&jidu=%s',
            //'url'=> 'http://123.126.42.251:80/corp/go.php/vMS_MarketHistory/stockid/%s.phtml?year=%s&jidu=%s',
            //'url' => 'http://192.168.10.112:8008/test/test.html',
            'collector_url' => 'http://127.0.0.1:8009/collector?file=%s&url=%s'
        ),
        
        
        'database' => array(
            'stock' => array(
                'host' => 'localhost',
                'user' => 'root',
                'password' => 'root',
                'database' => 'stock',
            ),
        ),
		'logconfigs' => Array(
			'all' => Array(
				'dir' => ROOT . DS . '..' . DS . 'log' . DS . WEBNAME,
				'filename' => 'all.log',
				'levels' => Array('error' => 100, 'warning' => 100, 'info' => 100, 'debug' => 100),
				'timeLevel' => 1,
			),
			'interface' => Array(
				'dir' => ROOT . DS . '..' . DS . 'log' . DS . WEBNAME,
				'filename' => 'interface.log',
				'levels' => Array('error' => 100, 'warning' => 100, 'info' => 0, 'debug' => 100),
				'timeLevel' => 0,
			),
			'dbinfo' => Array(
				'dir' => ROOT . DS . '..' . DS . 'log' . DS . WEBNAME,
				'filename' => 'dbinfo.log',
				'levels' => Array('error' => 100, 'warning' => 100, 'info' => 100, 'debug' => 100),
				'timeLevel' => 0,
			),
            'crontab' => Array(
				'dir' => ROOT . DS . '..' . DS . 'log' . DS . WEBNAME,
				'filename' => 'crontab.log',
				'levels' => Array('error' => 100, 'warning' => 100, 'info' => 100, 'debug' => 100),
				'timeLevel' => 0,
			),
		),
	),
);


