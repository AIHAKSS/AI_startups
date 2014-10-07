<?php
$config = array();
//区分各环境的配置文件
if (!defined('__MY_ENV')) {
	$hostname = php_uname('n');
	if (in_array($hostname, array('cppdev1','cppdev','localhost.localdomain'))) 
    {
        date_default_timezone_set("Asia/Shanghai");
        error_reporting(E_ALL);
		define('__MY_ENV', 'DEV');
		$config = require(dirname(__FILE__) . '/main_dev.php');
        //$config = require(dirname(__FILE__) . '/main_test.php');
	}else {
		ini_set("display_errors","On");
        error_reporting(E_ALL);
		define('__MY_ENV', 'ONLINE');
		$config = require(dirname(__FILE__) . '/main_dev.php');
	}
}
else
{
	ini_set("display_errors","On");
    error_reporting(E_ALL);
	define('__MY_ENV', 'ONLINE');
	$config = require(dirname(__FILE__) . '/main_dev.php');
}

class ConfigManager
{    
    public static function &GetConfig()
    {
        global $config;
        return $config;
    }
	public static $config;
    public static $baseurl;
}
ConfigManager::$config = $config;
