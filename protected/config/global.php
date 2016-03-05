<?php

/*
 * 公共资源
 */
define('VERSION', '20150617');      //版本号
define('SITE_URL', Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/');         //站点根路径
define('SITE_UPLOAD', SITE_URL.'upload/');              //站点上传目录
define('BACK_UPLOAD', SITE_URL.'backupload/');              //后台上传目录
/*
 * 前台资源
 */
define('STATIC_URL',$this->_theme->baseUrl."/extend/");  //前台静态资源
define('CSS_URL',$this->_theme->baseUrl."/site/css/");    //后台样式目录地址
define('IMG_URL',$this->_theme->baseUrl."/site/images/"); //后台图片目录地址
define('JS_URL',$this->_theme->baseUrl."/site/js/");      //后台JS目录地址
/*
 * 用户资源
 */
define('UCSS_URL',$this->_theme->baseUrl."/usercenter/css/");    //后台样式目录地址
define('UIMG_URL',$this->_theme->baseUrl."/usercenter/images/"); //后台图片目录地址
define('UJS_URL',$this->_theme->baseUrl."/usercenter/js/");      //后台JS目录地址
/*
 * 后台资源
 */
define('BACK_URL',$this->_theme->baseUrl."/back/");          //后台资源总目录地址
define('BACK_ASSETS',$this->_theme->baseUrl."/back/assets/");          //后台资源总目录地址
define('BACK_CSS_URL',$this->_theme->baseUrl."/back/css/");    //后台样式目录地址
define('BACK_IMG_URL',$this->_theme->baseUrl."/back/images/"); //后台图片目录地址
define('BACK_JS_URL',$this->_theme->baseUrl."/back/js/");      //后台JS目录地址

/*
 * WAP资源
 */
define('WAP_URL',$this->_theme->baseUrl."/wap/");          //后台资源总目录地址
define('WAP_ASSETS',$this->_theme->baseUrl."/wap/assets/");          //后台资源总目录地址
define('WAP_CSS_URL',$this->_theme->baseUrl."/wap/css/");    //后台样式目录地址
define('WAP_IMG_URL',$this->_theme->baseUrl."/wap/images/"); //后台图片目录地址
define('WAP_JS_URL',$this->_theme->baseUrl."/wap/js/");      //后台JS目录地址