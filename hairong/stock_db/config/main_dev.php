<?php
return array(
	'params' => array(
        'stockinfo' => Array(
            'ss' => array(
                'file' => '/home/zhr/data/stock/stockinfo/%Y_%m/ss_a',
            ),
            'sz' => array(
                'file' => '/home/zhr/data/stock/stockinfo/%Y_%m/sz_a',
            ),
        ),
        'structinfo' => array(
            'file' => '/home/zhr/data/stock/structinfo/%Y_%m/',  //stockno
        ),
        'historyprice' => array(
            'file' => '/home/zhr/data/stock/historyprice/%Y_%m_%d/',  //  /home/zhr/data/stock/historyprice/%Y_%m_%d/stockno/year_season
        ),
        
        'database' => array(
            'stock' => array(
                'host' => 'localhost',
                'user' => 'root',
                'password' => 'root',
                'database' => 'stock',
            ),
            'stock_price' => array(
                'host' => 'localhost',
                'user' => 'root',
                'password' => 'root',
                'database' => 'stock_price',
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


