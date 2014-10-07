<?php
return array(
	'params' => array(
        'database' => array(
            'stock' => array(
                //'host' => '10.241.50.80',
                'host' => 'localhost',
                'user' => 'root',
                'password' => 'root',
                'database' => 'stock',
            ),
        ),
		'logconfigs' => Array(
			'all' => Array(
				'dir' => ROOT . DIRECTORY_SEPARATOR . 'log',
				'filename' => 'all.log',
				'levels' => Array('error' => 100, 'warning' => 100, 'info' => 100, 'debug' => 100),
				'timeLevel' => 1,
			),
			'interface' => Array(
				'dir' => ROOT . DIRECTORY_SEPARATOR . 'log',
				'filename' => 'interface.log',
				'levels' => Array('error' => 100, 'warning' => 100, 'info' => 100, 'debug' => 100),
				'timeLevel' => 0,
			),
			'dbinfo' => Array(
				'dir' => ROOT . DIRECTORY_SEPARATOR . 'log',
				'filename' => 'dbinfo.log',
				'levels' => Array('error' => 100, 'warning' => 100, 'info' => 100, 'debug' => 100),
				'timeLevel' => 0,
			),
            'crontab' => Array(
				'dir' => ROOT . DIRECTORY_SEPARATOR . 'log',
				'filename' => 'crontab.log',
				'levels' => Array('error' => 100, 'warning' => 100, 'info' => 100, 'debug' => 100),
				'timeLevel' => 0,
			),
		),
	),
);


