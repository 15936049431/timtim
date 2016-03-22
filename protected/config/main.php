<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$is_phone_browser = check_wap();

// check if wap 
function check_wap(){
	if(!empty($_REQUEST['fr']) && $_REQUEST['fr'] == 'mobile_acc_pc'){//强制访问pc版本
        return false;
    }
    // 先检查是否为wap代理，准确度高
    /*if(stristr($_SERVER['HTTP_VIA'],"wap")){
        return true;
    }
    // 检查浏览器是否接受 WML.
    else*/if(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){
        return true;
   }
   //检查USER_AGENT
   elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){
        return true;             
    }
    else{
        return false;    
   }
}


return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'皖平财富',
        'theme'=>'default',
        'timeZone'=>'Asia/Shanghai',
        'language'=>'zh_cn',
        'sourceLanguage'=>'en',
	// preloading 'log' component
	'preload'=>array('log'),
        'defaultController'=>$is_phone_browser?'wap/site/login':'site/index',
//		'defaultController'=>'site/index',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.extensions.ConvertNumber',
		'application.components.*',
                'application.extensions.GoogleAuthenticator.GoogleAuthenticator',
	),

	'modules'=>array(
            // uncomment the following to enable the Gii tool

           'gii'=>array(
                   'class'=>'system.gii.GiiModule',
                   'password'=>'lxy',
                   // If removed, Gii defaults to localhost only. Edit carefully to taste.
                   'ipFilters'=>array('127.0.0.1','::1'),
           ),
            'treasure'=>array(
                     'defaultController'=>'default/index',
            ),
            'wap'=>array(
                'defaultController'=>'site/login',
            ),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
                        'allowAutoLogin'=>true,
                        'stateKeyPrefix' => 'front_',
		),
		// uncomment the following to enable URLs in path-format
		'authManager' => array(  
			'class' => 'CDbAuthManager',  
			'connectionID' => 'db',  
			'itemTable' => '{{authitem}}',  
			'assignmentTable' => '{{authassignment}}',  
			'itemChildTable' => '{{authitemchild}}',  
			'defaultRoles'=>array('默认角色'),  
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName'=>false,
                        'urlSuffix' => '.html',
			'rules'=>array(
                            'article/<p:\w+>/<cat:\w+>'=>'article/list',
                            'project/debpage/<oid:\d+>'=>'project/debpage',
                            '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                            '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
                 * 
                 */
            
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=tiantianli',
			'emulatePrepare' => true,
			'tablePrefix'=>'ly_',
			'username' => 'root',
			'password' => 'Lxy402216351',
			'charset' => 'utf8',
		),
		
 		/*'errorHandler'=>array(
 			// use 'site/error' action to display errors
 			'errorAction'=>'site/error',
 		),*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),*/
				
			),
		),
            
            'ePdf' => array(
                    'class' => 'ext.yii-pdf.EYiiPdf',
                    'params' => array(
                        'mpdf' => array(
                            'librarySourcePath' => 'ext.yii-pdf.mpdf56.*',
                            'constants' => array(
                                '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                                ),
                            'class' => 'mpdf',
                            'defaultParams' => array(
                                )
                            ),
                        'HTML2PDF' => array(
                            'librarySourcePath' => 'ext.yii-pdf.html2pdf.*',
                            'classFile' => 'html2pdf.class.php',
                            'defaultParams' => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                                'orientation' => 'P', // landscape or portrait orientation
                                'format'      => 'A4', // format A4, A5, ...
                                'language'    => 'en', // language: fr, en, it ...
                                'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                                'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                                'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                                )
                            )
                        ),
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'teamleader@7pointer.com',
	),
);
