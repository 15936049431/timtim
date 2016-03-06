<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo Yii::app()->params['site_name']; ?>后台管理</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

<!--底层CSS-->
<link rel="stylesheet" href="<?php echo BACK_ASSETS; ?>bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo BACK_ASSETS; ?>bootstrap/bootstrap-responsive.min.css">
<link rel="stylesheet" href="<?php echo BACK_ASSETS; ?>font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo BACK_ASSETS; ?>normalize/normalize.css">
<link rel="stylesheet" href="<?php echo BACK_ASSETS; ?>prettyPhoto/css/prettyPhoto.css">

<!--作者写的CSS-->
<link rel="stylesheet" href="<?php echo BACK_CSS_URL; ?>flaty.css">
<link rel="stylesheet" href="<?php echo BACK_CSS_URL; ?>flaty-responsive.css">
<script src="<?php echo BACK_ASSETS; ?>modernizr/modernizr-2.6.2.min.js"></script>

<!--basic scripts--> 
<!--<script src="//http://libs.useso.com/js/jquery/1.10.1/jquery.min.js"></script>--> 
<script>window.jQuery || document.write('<script src="<?php echo BACK_ASSETS; ?>jquery/jquery-1.10.1.min.js"><\/script>')</script> 
<script src="<?php echo BACK_ASSETS; ?>bootstrap/bootstrap.min.js"></script> 
<script src="<?php echo BACK_ASSETS; ?>nicescroll/jquery.nicescroll.min.js"></script> 
<!--<style>
    .top-menu-y{
        
    }
    .top-menu-y ul{
        padding: 0;
    }
    .top-menu-y ul li{
        display: inline-block;
    }
</style>-->

<!--本页面CSS 开始-->
<?php
    foreach($this->css as $k => $v){
        if(!empty($v)){
?>
<link rel="stylesheet" type="text/css" href="<?php echo BACK_URL.$v; ?>.css" />
<?php }} ?>

<!--本页面CSS 结束-->

<!--本页面的js 开始--> 
<?php foreach($this->js as $k => $v){
    if(!empty($v)){
?>
<script src="<?php echo BACK_URL.$v; ?>.js"></script> 
<?php }} ?>
<!--本页面的js 结束--> 

<script src="<?php echo BACK_JS_URL; ?>flaty.js"></script>
</head>
<body>
<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]--> 

<!-- 设置主题 -->
<div id="theme-setting"> <a href="#"><i class="icon-gears icon-2x"></i></a>
    <ul>
        <li> <span>主色调</span>
            <ul class="colors" data-target="body" data-prefix="skin-">
                <li class="active"><a class="blue" href="#"></a></li>
                <li><a class="red" href="#"></a></li>
                <li><a class="green" href="#"></a></li>
                <li><a class="orange" href="#"></a></li>
                <li><a class="yellow" href="#"></a></li>
                <li><a class="pink" href="#"></a></li>
                <li><a class="magenta" href="#"></a></li>
                <li><a class="gray" href="#"></a></li>
                <li><a class="black" href="#"></a></li>
            </ul>
        </li>
        <li> <span>导航颜色</span>
            <ul class="colors" data-target="#navbar" data-prefix="navbar-">
                <li class="active"><a class="blue" href="#"></a></li>
                <li><a class="red" href="#"></a></li>
                <li><a class="green" href="#"></a></li>
                <li><a class="orange" href="#"></a></li>
                <li><a class="yellow" href="#"></a></li>
                <li><a class="pink" href="#"></a></li>
                <li><a class="magenta" href="#"></a></li>
                <li><a class="gray" href="#"></a></li>
                <li><a class="black" href="#"></a></li>
            </ul>
        </li>
        <li> <span>侧边栏颜色</span>
            <ul class="colors" data-target="#main-container" data-prefix="sidebar-">
                <li class="active"><a class="blue" href="#"></a></li>
                <li><a class="red" href="#"></a></li>
                <li><a class="green" href="#"></a></li>
                <li><a class="orange" href="#"></a></li>
                <li><a class="yellow" href="#"></a></li>
                <li><a class="pink" href="#"></a></li>
                <li><a class="magenta" href="#"></a></li>
                <li><a class="gray" href="#"></a></li>
                <li><a class="black" href="#"></a></li>
            </ul>
        </li>
        <li> <span></span> <a data-target="navbar" href="#"><i class="icon-check-empty"></i> 固定导航位置</a> <a class="pull-right visible-desktop" data-target="sidebar" href="#"><i class="icon-check-empty"></i> 固定侧边栏位置</a> </li>
    </ul>
</div>
<!-- 主题设置结束 --> 

<!-- 导航开始 -->
<div id="navbar" class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid"> 
            <!-- 标题 --> 
            <a href="#" class="brand"> <small> <i class="icon-desktop"></i> <?php echo Yii::app()->params['site_name']; ?>后台管理 </small> </a> 
            <!-- 结束标题 --> 
            
            <!-- 收起响应式侧边栏 --> 
            <a href="#" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse"> <i class="icon-reorder"></i> </a> 
            <!-- 结束 --> 
            
            <!-- 导航按钮开始 -->
            <ul class="nav flaty-nav pull-right">
                <!-- 任务按钮 -->
<!--               <li class="hidden-phone"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-tasks"></i> <span class="badge badge-warning">4</span> </a> 
                    <ul class="pull-right dropdown-navbar dropdown-menu">
                        <li class="nav-header"> <i class="icon-ok"></i> 4个任务已完成 </li>
                        <li> <a href="http://www.baidu.com">
                            <div class="clearfix"> <span class="pull-left">更新软件</span> <span class="pull-right">75%</span> </div>
                            <div class="progress progress-mini progress-warning">
                                <div style="width:75%" class="bar"></div>
                            </div>
                            </a> </li>
                        <li> <a href="#">
                            <div class="clearfix"> <span class="pull-left">提交到服务器</span> <span class="pull-right">45%</span> </div>
                            <div class="progress progress-mini progress-danger">
                                <div style="width:45%" class="bar"></div>
                            </div>
                            </a> </li>
                        <li> <a href="#">
                            <div class="clearfix"> <span class="pull-left">BUG修复</span> <span class="pull-right">20%</span> </div>
                            <div class="progress progress-mini">
                                <div style="width:20%" class="bar"></div>
                            </div>
                            </a> </li>
                        <li> <a href="#">
                            <div class="clearfix"> <span class="pull-left">编写文档</span> <span class="pull-right">85%</span> </div>
                            <div class="progress progress-mini progress-success progress-striped active">
                                <div style="width:85%" class="bar"></div>
                            </div>
                            </a> </li>
                        <li class="more"> <a href="#">观察任务细节</a> </li>
                    </ul>
                    
                </li>-->
                <!-- END 任务按钮 --> 
                
                <!-- BEGIN 通知按钮 -->
                <?php
                    $new_message_count = 0;
                ?>
                <li class="hidden-phone"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-bell-alt"></i> <span class="badge badge-important new_message_count new_message_count_del">0</span> </a> 
                    <ul class="dropdown-navbar dropdown-menu">
                        <li class="nav-header"> <i class="icon-warning-sign"></i> <font class="new_message_count">0</font>个通知 </li>
                        <?php if(Yii::app()->user->checkAccess('treasure.project.wait_check_oper') || Yii::app()->user->issuper == 1){ ?>
                            <li class="notify">
                                <a href="<?php echo Yii::app()->controller->createUrl('project/wait_check_list'); ?>"> <i class="icon-comment orange"></i>
                                <p>发标待审</p>
                                <?php if(($new_message_count += $the_count = $this -> get_notoper_count('wait_check_oper')) > 0 && $the_count > 0){ ?>
                                <span class="badge badge-warning"><?php echo $the_count; ?></span>
                                <?php } ?>
                                </a>
                            </li>
                        <?php } ?>
                        
                        <?php if(Yii::app()->user->checkAccess('treasure.project.full_check_oper') || Yii::app()->user->issuper == 1){ ?>
                        <li class="notify">
                            <a href="<?php echo Yii::app()->controller->createUrl('project/full_check_list') ?>"> <i class="icon-twitter blue"></i>
                            <p>满标待审</p>
                            <?php if(($new_message_count += $the_count = $this -> get_notoper_count('full_check_oper')) > 0 && $the_count > 0){ ?>
                            <span class="badge badge-info"><?php echo $the_count; ?></span>
                            <?php } ?>
                            </a>
                        </li>
                        <?php } ?>
                        
                        <?php if(Yii::app()->user->checkAccess('treasure.assetsRecharge.update') || Yii::app()->user->issuper == 1){ ?>
                        <li class="notify">
                            <a href="<?php echo Yii::app()->controller->createUrl('assetsRecharge/list',array('AssetsRecharge[r_type]'=>'1','AssetsRecharge[r_status]'=>'0')) ?>"> <i class="icon-bug pink"></i>
                            <p>充值申请</p>
                            <?php if(($new_message_count += $the_count = $this -> get_notoper_count('assetsRecharge_update')) > 0 && $the_count > 0){ ?>
                            <span class="badge badge-info"><?php echo $the_count; ?></span>
                            <?php } ?>
                            </a>
                        </li>
                        <?php } ?>
                        
                        <?php if(Yii::app()->user->checkAccess('treasure.assetsCash.update') || Yii::app()->user->issuper == 1){ ?>
                        <li class="notify">
                            <a href="<?php echo Yii::app()->controller->createUrl('assetsCash/list',array('AssetsCash[c_status]'=>'0')) ?>"> <i class="icon-bug pink"></i>
                            <p>提现申请</p>
                            <?php if(($new_message_count += $the_count = $this -> get_notoper_count('assetsCash_update')) > 0 && $the_count > 0){ ?>
                            <span class="badge badge-info"><?php echo $the_count; ?></span>
                            <?php } ?>
                            </a>
                        </li>
                        <?php } ?>
                        
                        
                        <?php if(Yii::app()->user->checkAccess('treasure.identity.wait_oper') || Yii::app()->user->issuper == 1){ ?>
                        <li class="notify">
                            <a href="<?php echo Yii::app()->controller->createUrl('identity/wait_list') ?>"> <i class="icon-shopping-cart green"></i>
                            <p>实名认证审核</p>
                            <?php if(($new_message_count += $the_count = $this -> get_notoper_count('identity_wait_oper')) > 0 && $the_count > 0){ ?>
                            <span class="badge badge-success"><?php echo $the_count; ?></span>
                            </a>
                            <?php } ?>
                        </li>
                        <?php } ?>
                        <li class="more"> <a href="#">我知道了</a> </li>
                        <script type="text/javascript">
                        <?php if($new_message_count > 0){ ?>
                            $(".new_message_count").html('<?php echo $new_message_count; ?>');
                        <?php }else{ ?>
                            $(".new_message_count_del").remove();
                        <?php } ?>
                            </script>
                        
                    </ul> 
                </li>
                <!-- END 通知按钮 --> 
                
                <!-- BEGIN 信息按钮 -->
<!--                <li class="hidden-phone"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-envelope"></i> <span class="badge badge-success">3</span> </a> 
                    
                     BEGIN 信息按钮下拉 
                    <ul class="dropdown-navbar dropdown-menu">
                        <li class="nav-header"> <i class="icon-comments"></i> 3个消息 </li>
                        <li class="msg"> <a href="#"> <img src="img/demo/avatar/avatar3.jpg" alt="Sarah's Avatar" />
                            <div> <span class="msg-title">Sarah</span> <span class="msg-time"> <i class="icon-time"></i> <span>a moment ago</span> </span> </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </a> </li>
                        <li class="msg"> <a href="#"> <img src="img/demo/avatar/avatar4.jpg" alt="Emma's Avatar" />
                            <div> <span class="msg-title">Emma</span> <span class="msg-time"> <i class="icon-time"></i> <span>2 Days ago</span> </span> </div>
                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris ...</p>
                            </a> </li>
                        <li class="msg"> <a href="#"> <img src="img/demo/avatar/avatar5.jpg" alt="John's Avatar" />
                            <div> <span class="msg-title">John</span> <span class="msg-time"> <i class="icon-time"></i> <span>8:24 PM</span> </span> </div>
                            <p>Duis aute irure dolor in reprehenderit in ...</p>
                            </a> </li>
                        <li class="more"> <a href="#">See all messages</a> </li>
                    </ul>
                     END 通知按钮下拉  
                </li>-->
                <!-- END 信息按钮 --> 
                
                <!-- BEGIN 用户部分按钮 -->
                <li class="user-profile"> <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle"> <!-- <img class="nav-user-photo" src="img/demo/avatar/avatar1.jpg" alt="Penny's Photo" />--> <span class="hidden-phone" id="user_info"> <?php echo Yii::app()->user->name; ?> </span>(<span class="hidden-phone" id="user_info"> <?php echo Yii::app()->user->getState('rolename'); ?> </span>)<?php echo date("Y-m-d H:i:s",time()); ?> <i class="icon-caret-down"></i> </a> 
                    
                    <!-- BEGIN 用户部分下拉 -->
                    <ul class="dropdown-menu dropdown-navbar" id="user_menu">
                        <li class="nav-header"> <i class="icon-time"></i> <?php echo date('H:i',Yii::app()->user->getState('login_time')); ?>分登录 </li>
                        <li> <a target="_blank" href="<?php echo Yii::app()->controller->createUrl('/site/index') ?>"> <i class="icon-key"></i> 网站首页 </a> </li>
                        <li> <a href="<?php echo Yii::app()->controller->createUrl('myself/updatepwd') ?>"> <i class="icon-key"></i> 修改密码 </a> </li>
                        <li> <a href="<?php echo Yii::app()->controller->createUrl('myself/edit') ?>"> <i class="icon-user"></i> 编辑个人资料 </a> </li>
<!--                        <li> <a href="#"> <i class="icon-question"></i> 帮助 </a> </li>-->
                        <li class="divider visible-phone"></li>
                        <?php if(Yii::app()->user->checkAccess('treasure.project.wait_check_oper') || Yii::app()->user->issuper == 1){ ?>
                        <li class="visible-phone">
                            <a href="<?php echo Yii::app()->controller->createUrl('project/wait_check_list'); ?>">
                                <i class="icon-tasks"></i> 发标待审 
                                <?php if(($new_message_count += $the_count = $this -> get_notoper_count('wait_check_oper')) > 0 && $the_count > 0){ ?>
                                <span class="badge badge-warning"><?php echo $the_count; ?></span> 
                                <?php } ?>
                            </a> 
                        </li>
                        <?php } ?>
                        <?php if(Yii::app()->user->checkAccess('treasure.project.full_check_oper') || Yii::app()->user->issuper == 1){ ?>
                        <li class="visible-phone">
                            <a href="<?php echo Yii::app()->controller->createUrl('project/full_check_list'); ?>">
                                <i class="icon-tasks"></i> 满标待审 
                                <?php if(($new_message_count += $the_count = $this -> get_notoper_count('full_check_oper')) > 0 && $the_count > 0){ ?>
                                <span class="badge badge-warning"><?php echo $the_count; ?></span> 
                                <?php } ?>
                            </a> 
                        </li>
                        <?php } ?>
                        <?php if(Yii::app()->user->checkAccess('treasure.assetsRecharge.update') || Yii::app()->user->issuper == 1){ ?>
                        <li class="visible-phone">
                            <a href="<?php echo Yii::app()->controller->createUrl('assetsRecharge/list',array('AssetsRecharge[r_type]'=>'1','AssetsRecharge[r_status]'=>'0')) ?>">
                                <i class="icon-tasks"></i> 充值申请 
                                <?php if(($new_message_count += $the_count = $this -> get_notoper_count('assetsRecharge_update')) > 0 && $the_count > 0){ ?>
                                <span class="badge badge-warning"><?php echo $the_count; ?></span> 
                                <?php } ?>
                            </a> 
                        </li>
                        <?php } ?>
                        <?php if(Yii::app()->user->checkAccess('treasure.assetsCash.update') || Yii::app()->user->issuper == 1){ ?>
                        <li class="visible-phone">
                            <a href="<?php echo Yii::app()->controller->createUrl('assetsCash/list',array('AssetsCash[c_status]'=>'0')) ?>">
                                <i class="icon-tasks"></i> 提现申请 
                                <?php if(($new_message_count += $the_count = $this -> get_notoper_count('assetsCash_update')) > 0 && $the_count > 0){ ?>
                                <span class="badge badge-warning"><?php echo $the_count; ?></span> 
                                <?php } ?>
                            </a> 
                        </li>
                        <?php } ?>
                        <?php if(Yii::app()->user->checkAccess('treasure.identity.wait_oper') || Yii::app()->user->issuper == 1){ ?>
                        <li class="visible-phone">
                            <a href="<?php echo Yii::app()->controller->createUrl('identity/wait_list') ?>">
                                <i class="icon-tasks"></i> 实名认证审核 
                                <?php if(($new_message_count += $the_count = $this -> get_notoper_count('identity_wait_oper')) > 0 && $the_count > 0){ ?>
                                <span class="badge badge-warning"><?php echo $the_count; ?></span> 
                                <?php } ?>
                            </a> 
                        </li>
                        <?php } ?>
                        <li class="divider"></li>
                        <li> <a href="<?php echo Yii::app()->controller->createUrl('login/logout') ?>"> <i class="icon-off"></i> 退出 </a> </li>
                    </ul>
                    <!-- END 用户部分下拉 --> 
                </li>
                <!-- END 用户部分按钮 -->
            </ul>
            <!-- END 导航按钮 --> 
        </div>
        <!--/.container-fluid--> 
    </div>
    <!--/.navbar-inner--> 
</div>

<!--<div class="navbar" style="z-index: 10; padding-bottom: 1px;">
    <div class="navbar-inner top-menu-y" style="border-top: 1px #e5e5e5 solid;border-bottom: 1px #e5e5e5 solid; background: #248dc1;">
        <ul class=" nav nav-tabs" style="border:0;">
		<li class=""><a href="#tab-1-1" data-toggle="tab">测试栏目1</a></li>
		<li class=""><a href="#tab-1-2" data-toggle="tab">测试栏目2</a></li>
		<li class=""><a href="#tab-1-3" data-toggle="tab">测试栏目3</a></li>
		<li class=""><a href="#tab-1-4" data-toggle="tab">测试栏目4</a></li>
		<li class=""><a href="#tab-1-5" data-toggle="tab">测试栏目5</a></li>
	</ul>
    </div>
</div>-->

<!-- BEGIN Container -->
<div class="container-fluid" id="main-container"> 
    <!-- BEGIN Sidebar -->
    <div id="sidebar" class="nav-collapse"> 
        <?php
            $menu_arr = array(
                array(
                    'title'=>'控制中心',
                    'is_select'=>false,
                    'ico'=>'icon-dashboard',
                    'url'=>'default/index'
                ),
                'system_setting'=>array(
                    'title'=>'系统设置',
                    'is_select'=>true,
                    'ico'=>'icon-desktop',
                    'list'=>array(),
                ),
                array(
                    'title'=>'内容管理',
                    'is_select'=>true,
                    'ico'=>'icon-text-width',
                    'list'=>array(
                        array(
                            'title'=>'文章管理',
                            'url'=>'article/list',
                            'nurl'=>array('article/create'),
                        ),
                        array(
                            'title'=>'文章分类管理',
                            'url'=>'articlecat/list',
                        	'nurl'=>array('articlecat/create','articlecat/pageupdate'),
                        ),
                        array(
                            'title'=>'链接管理',
                            'url'=>'link/list',
                        	'nurl'=>array('link/update','link/create'),
                        ),
                        array(
                            'title'=>'联动模块分类',
                            'url'=>'itemcat/list',
                        	'nurl'=>array('itemcat/update','itemcat/create'),
                        ),
                        array(
                            'title'=>'联动模块管理',
                            'url'=>'item/list',
                        	'nurl'=>array('item/create','item/update'),
                        ),
                    ),
                ),
                array(
                    'title'=>'用户管理',
                    'is_select'=>true,
                    'ico'=>'icon-th',
                    'list'=>array(
                        array(
                            'title'=>'会员管理',
                            'url'=>'user/list',
                        	'nurl'=>array('user/create','user/update'),
                        ),
                    	array(
                    		'title'=>'实名认证待审核',
                   			'url'=>'identity/wait_list'
                  		),
                   		array(
                  			'title'=>'实名认证已审核',
                   			'url'=>'identity/list'
                   		),
                        array(
                            'title'=>'管理员管理',
                            'url'=>'manager/list' ,
                        	'nurl'=>array('manager/create','manager/update'),
                        ),
						array(
                            'title'=>'添加借款用户',
                            'url'=>'user/addborrowuser' ,
                        ),
                    ),
                ),
                array(
                    'title'=>'权限管理',
                    'is_select'=>true,
                    'ico'=>'icon-th',
                    'list'=>array(
                        array(
                            'title'=>'角色管理',
                            'url'=>'role/list',
                        	'nurl'=>array('role/create','role/update'),
                        ),
                        array(
                            'title'=>'任务管理',
                            'url'=>'task/list',
                        	'nurl'=>array('operetion/create','task/update','task/giveauth','task/create'),
                        ),
                        array(
                            'title'=>'操作管理',
                            'url'=>'operetion/list',
                        	'nurl'=>array('operetion/update'),
                        ),
                    ),
                ),
                array(
                    'title'=>'项目管理',
                    'is_select'=>true,
                    'ico'=>'icon-list',
                    'list'=>array(
                        array(
                            'title'=>'借款申请',
                            'url'=>'project/applylist',
                        	'nurl'=>array('project/updateapply'),
                        ),
                        array(
                            'title'=>'发布借款',
                            'url'=>'project/searchuser',
                            'nurl'=>array('project/adduserproject'),
                        ),
                        array(
                            'title'=>'借款列表',
                            'url'=>'project/list',
                        	'nurl'=>array('project/update','project/project_info'),
                        ),
						array(
                            'title'=>'投资列表',
                            'url'=>'project/orderlist',
                        ),
                        /*array(
                            'title'=>'发布体验标',
                            'url'=>'project/addexpproject',
                            'nurl'=>array('project/addexpproject'),
                        ),
                        array(
                            'title'=>'体验标列表',
                            'url'=>'project/explist',
                        	'nurl'=>array('project/explist','project/expinvestlist','project/expview'),
                        ),*/
//                        array(
//                            'title'=>'借款额度',
//                            'url'=>'project/list'
//                        ),
                    ),
                ),
                array(
                    'title'=>'还款管理',
                    'is_select'=>true,
                    'ico'=>'icon-list',
                    'list'=>array(
                        array(
                            'title'=>'待还项目',
                            'url'=>'project/waitrepay',
                        	'nurl'=>array('project/repayview'),
                        ),
                        array(
                            'title'=>'已还项目',
                            'url'=>'project/haverepay'
                        ),
                        array(
                            'title'=>'逾期项目',
                            'url'=>'project/laterepay'
                        ),
                    ),
                ),
                array(
                    'title'=>'审核管理',
                    'is_select'=>true,
                    'ico'=>'icon-list',
                    'list'=>array(
                         array(
                            'title'=>'发标待审',
                            'url'=>'project/wait_check_list',
                        	'nurl'=>array('project/wait_check_oper'),
                        ),
                        array(
                            'title'=>'满标待审',
                            'url'=>'project/full_check_list',
                        	'nurl'=>array('project/full_check_oper'),
                        ),
                        array(
                            'title'=>'满标审核未通过',
                            'url'=>'project/fail_full_check_list',
                        ),
//                         array(
//                             'title'=>'资信审核',
//                             'url'=>'credit/list',
//                             'nurl'=>array(
//                                 'credit/update'
//                             ),
//                         ),
                    ),
                ),
                array(
                    'title'=>'资金管理',
                    'is_select'=>true,
                    'ico'=>'icon-edit',
                    'list'=>array(
                        array(
                            'title'=>'提现列表',
                            'url'=>'assetsCash/list',
                        	'nurl'=>array('assetsCash/update'),
                        ),
                        array(
                            'title'=>'充值列表',
                            'url'=>'assetsRecharge/list',
                        	'nurl'=>array('assetsRecharge/update'),
                        ),
                        array(
                            'title'=>'银行卡管理',
                            'url'=>'assetsBank/list',
                        	'nurl'=>array('assetsBank/update'),
                        ),
                        array(
                            'title'=>'资金记录',
                            'url'=>'bill/list'
                        ),
                        array(
                            'title'=>'资金列表',
                            'url'=>'assets/list'
                        ),
                        array(
                            'title'=>'添加扣除账号金额',
                            'url'=>'opermoney/list'
                        ),
                    ),
                ),
                array(
                    'title'=>'商城管理',
                    'is_select'=>true,
                    'ico'=>'icon-picture',
                    'list'=>array(
                        array(
                            'title'=>'用户积分',
                            'url'=>'integralShop/userintegral'
                        ),
                        array(
                             'title'=>'商品列表',
                             'url'=>'integralShop/list',
                         	'nurl'=>array('integralShop/create','integralShop/update'),
                         ),
                         array(
                             'title'=>'订单列表',
                             'url'=>'integralOrder/list',
                         	'nurl'=>array('integralOrder/update'),
                         ),
                         array(
                             'title'=>'收货地址管理',
                             'url'=>'integralAddress/list',
                         	'nurl'=>array('integralAddress/update'),
                         ),
                    ),
                ),
                array(
                    'title'=>'活动管理',
                    'is_select'=>true,
                    'ico'=>'icon-dashboard',
                    'list'=>array(
                        array(
                            'title'=>'红包活动管理',
                            'url'=>'award/list',
                            'nurl'=>array('award/create','award/update',),
                        ),
                    	array(
                    		'title'=>'红包管理',
                    		'url'=>'award/tlist',
                    		'nurl'=>array('award/tcreate','award/tupdate',),
                    	),
                    	array(
                    		'title'=>'红包记录',
                    		'url'=>'awardbill/list',
                    		'nurl'=>array('awardBill/update',),
                    	),
                    ),
                ),
//                 array(
//                     'title'=>'客服中心',
//                     'is_select'=>true,
//                     'ico'=>'icon-file',
//                     'list'=>array(
// //                        array(
// //                            'title'=>'人工找回密码',
// //                            'url'=>''
// //                        ),
//                         array(
//                             'title'=>'实名认证待审核',
//                             'url'=>'identity/wait_list'
//                         ),
//                         array(
//                             'title'=>'实名认证已审核',
//                             'url'=>'identity/list'
//                         ),
//                     ),
//                 ),
                array(
                    'title'=>'平台统计',
                    'is_select'=>true,
                    'ico'=>'icon-desktop',
                    'list'=>array(
                        array(
                            'title'=>'资金统计',
                            'url'=>'sumIt/sumbill',
                        ),
                        array(
                            'title'=>'每日进出统计',
                            'url'=>'sumIt/everyday',
                        ),
                        array(
                            'title'=>'个人资金详情',
                            'url'=>'sumIt/list',
                        	'nurl'=>array('sumIt/detail'),
                        ),
                    ),
                ),
				array(
                    'title'=>'短信管理',
                    'is_select'=>true,
                    'ico'=>'icon-desktop',
                    'list'=>array(
                        array(
                            'title'=>'短信管理',
                            'url'=>'sms/list',
                            'nurl'=>array(
                                'pushVender/create',
                                'pushVender/update',
                            ),
                        ),
                        array(
                            'title'=>'发送短信',
                            'url'=>'sms/send_sms',
                            'nurl'=>array(
                            ),
                    	),
                        array(
                            'title'=>'验证码管理',
                            'url'=>'sms/list_code',
                            'nurl'=>array(
                                'pushReward/create',
                                'pushReward/update',
                            ),
                        ),
                        array(
                            'title'=>'发送验证码',
                            'url'=>'sms/send_code',
                            'nurl'=>array(
                            ),
                    	),
                        array(
                            'title'=>'短信模板管理',
                            'url'=>'sms/list_smstmp',
                            'nurl'=>array(
                            ),
                    	),
                    ),
                ),
            );
            
            
            foreach($this->system_menu as $k => $v){
            	if($v->systemcat_alias!="user_info"){ 
	                $menu_arr['system_setting']['list'][] = array(
	                    'title'=>$v->systemcat_name,
	                    'url'=>'system/seting',
	                    'params'=>array(
	                        'systemcatid'=>$v->systemcat_id,
	                    ),
	                );
            	}
            }
            $menu_arr['system_setting']['list'][] = array(
                'title'=>'系统字段管理',
                'url'=>'system/list'
            );
            $menu_arr['system_setting']['list'][] = array(
                'title'=>'系统字段类别管理',
                'url'=>'systemcat/list'
            );
            
            
        ?>
        <!-- BEGIN Navlist -->
        <ul class="nav nav-list">
            <!-- BEGIN Search Form -->
            <li><img src="<?php echo BACK_ASSETS."logo.jpg"?>" width="200" height="70"></li>
            <!-- END Search Form -->
            
            <?php
                $the_con_cat = $this->id.'/'.$this->getAction()->id;
                
                if(!Yii::app()->user->issuper){
                    $treasure_menu_arr = $this -> get_treasure_menu();
                    if($treasure_menu_arr===false){
                        foreach($menu_arr as $k => $v){
                            $is_access = false;
                            if($v['is_select']){
                                foreach($v['list'] as $a => $b){
                                    if(Yii::app()->user->checkAccess('treasure.'.str_replace('/','.',$b['url']))){
                                        $is_access = true;
                                    }else{
                                        unset($menu_arr[$k]['list'][$a]);
                                    }
                                }
                            }else{
                                if(Yii::app()->user->checkAccess('treasure.'.str_replace('/','.',$v['url']))){
                                    $is_access = true;
                                }
                            }
                            if(!$is_access){
                                unset($menu_arr[$k]);
                            }
                        }

                        $this -> set_treasure_menu($menu_arr);
                    }else{
                        $menu_arr = $treasure_menu_arr;
                    }
                }
                
                
                
            ?>
            <?php foreach($menu_arr as $k => $v){ 
                $son_menu_arr = array();
                if($v['is_select']){
                    foreach($v['list'] as $a => $b){
                        $son_menu_arr[] = $b['url'];
                        if(!empty($b['nurl'])){
                            foreach($b['nurl'] as $aa=>$bb){
                                $son_menu_arr[]=$bb;
                            }
                        }
                    }
                }else{
                    $son_menu_arr[] = $v['url'];
                }
                
            ?>
            <li class="<?php echo in_array($the_con_cat, $son_menu_arr)?'active':'' ?>">
                    <a href="<?php echo !$v['is_select']?Yii::app()->controller->createUrl($v['url']):'javascript:;' ?>" class="dropdown-toggle"> <i class="<?php echo !empty($v['ico'])?$v['ico']:'' ?>"></i> <span><?php echo $v['title'] ?></span>
                        <?php if($v['is_select']){ ?>
                            <b class="arrow icon-angle-right"></b> 
                        <?php } ?>
                    </a>
                    <?php if($v['is_select']){ ?>
                    <ul class="submenu">
                        <?php foreach($v['list'] as $a => $b){ ?>
                        <?php @$is_equal = !empty($b['params'])?array_diff($b['params'], $_GET):false; ?>
                        <li class="<?php
                            if($b['url']==$the_con_cat ||(!empty($b['nurl'])&&in_array($the_con_cat, $b['nurl']))){
                                if(!empty($b['params'])){
                                    if(empty($is_equal)){
                                        echo 'active';
                                    }
                                }else{
                                    echo 'active';
                                }
                                
                            }
                        ?>"><a  href="<?php echo Yii::app()->controller->createUrl($b['url'],!empty($b['params'])?$b['params']:array()); ?>"><?php echo $b['title'] ?></a></li>
                        
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
            <?php } ?>
			
			


<!--            <li> <a href="#" class="dropdown-toggle"> <i class="icon-file"></i> <span>Other Pages</span> <b class="arrow icon-angle-right"></b> </a> 
                
                 BEGIN Submenu 
                <ul class="submenu">
                    <li><a href="more_login.html">Login &amp; Register</a></li>
                    <li><a href="more_error-404.html">Error 404</a></li>
                    <li><a href="more_error-500.html">Error 500</a></li>
                    <li><a href="more_blank.html">Blank Page</a></li>
                    <li><a href="more_set-skin.html">Skin</a></li>
                    <li><a href="more_set-sidebar-navbar-color.html">Sidebar &amp; Navbar</a></li>
                    <li><a href="more_sidebar-collapsed.html">Collapsed Sidebar</a></li>
                </ul>
                 END Submenu  
            </li>-->
        </ul>
        <!-- END Navlist --> 
        
        <!-- BEGIN Sidebar Collapse Button -->
        <div id="sidebar-collapse" class="visible-desktop"> <i class="icon-double-angle-left"></i> </div>
        <!-- END Sidebar Collapse Button --> 
    </div>
    <!-- END Sidebar --> 
    
    <!-- BEGIN Content -->
    <div id="main-content"> 
        <!-- BEGIN Page Title -->
        <div class="page-title">
            <div>
                <h1><i class="icon-file-alt"></i> <?php echo $this->page_title; ?></h1>
                <h4><?php echo $this->page_desc; ?></h4>
            </div>
        </div>
        <!-- END Page Title --> 
        
        <!-- BEGIN Breadcrumb -->
        <div id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo Yii::app()->controller->createUrl('default/index'); ?>">主页</a>
                    <span class="divider"><i class="icon-angle-right"></i></span>
                </li>
                <li class="active"><?php echo $this->page_title; ?></li>
            </ul>
        </div>
        <!-- END Breadcrumb --> 
        
        <!-- BEGIN Main Content -->
        <?php if($success_message = Yii::app()->user->getFlash('success')){ ?>
        <div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <?php echo $success_message; ?>
        </div>
        <?php } ?>
        
        <?php if($error_message = Yii::app()->user->getFlash('error')){ ?>
        <div class="alert alert-error">
            <button class="close" data-dismiss="alert">×</button>
            <?php echo $error_message; ?>
        </div>
        <?php } ?>
        
        <?php echo $content; ?>
        
        <!-- END Main Content -->
        
<!--        <footer>
            <p>2013 © FLATY Admin Template.</p>
        </footer>-->
        <a id="btn-scrollup" class="btn btn-circle btn-large" href="#"><i class="icon-chevron-up"></i></a> </div>
    <!-- END Content --> 
</div>
<!-- END Container --> 


</body>
</html>