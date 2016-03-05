<?php
$connection = Yii::app()->db;
$config_all = $connection->createCommand("select * from {{system}}")->queryAll();
$config_arr = array();
foreach($config_all as $k => $v){
    $config_arr[$v['system_alias']] = $v['system_value'];  
}
return $config_arr;
