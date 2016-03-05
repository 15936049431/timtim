<?php
//die("1111");
//error_reporting(0);//设置所有不报错
// change the following paths if necessary
define('DS',DIRECTORY_SEPARATOR); 
define('WWWPATH', str_replace(array('\\', '\\\\'), '/', dirname(__FILE__)));
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//$the_host = $_SERVER['HTTP_HOST'];//取得进入所输入的域名
//$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面部分
//if($the_host !== 'www.wpcf.net')//这是我要以前的域名地址
//{
// header('HTTP/1.1 301 Moved Permanently');//发出301头部 
// header('Location: http://www.wpcf.net'.$request_uri);//跳转到我的新域名地址
//}
require_once($yii);
Yii::createWebApplication($config)->run();
