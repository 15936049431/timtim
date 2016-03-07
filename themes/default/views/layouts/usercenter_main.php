<?php 
	$this->beginContent('//layouts/main');
	$this->ucss = array_merge(array("user"),$this->ucss);
	$this->ujs = array_merge(array("function","highcharts"),$this->ujs);
	$this->css = $this->css;
	$this->js = $this->js;
?>

<div class="main">
        	<div style="height:25px;">
<!--                 <a href="/">首页</a> -->
<!--                 <i class="fontello">&#xe83f;</i> -->
                <span><?php //echo empty($this->page_title) ? "用户中心" : $this->page_title ; ?></span>
            </div>
            <div class="user_main clear mb20">
            <?php 
            	$menu_arr = array(
            		array(
            			"title"=>"个人中心",
            			"class"=>"m1",
            			"url"=>"usercenter/home",
            			"list"=>array(),	
	            	),
            		array(
            			"title"=>"资金管理",
            			"class"=>"m2",
            			"url"=>"",
           				"list"=>array(
           					array("title"=>"充值","url"=>"usercenter/recharge"),
           					array("title"=>"提现","url"=>"usercenter/cash"),	
           					array("title"=>"绑定银行卡","url"=>"usercenter/bank"),
           				),
            		),
            		array(
            			"title"=>"账户管理",
            			"class"=>"m6",
           				"url"=>"",
         				"list"=>array(
           					array("title"=>"资金明细","url"=>"usercenter/bill"),
            				array("title"=>"充值记录",'url'=>"usercenter/rechargelist"),
            				array("title"=>"提现记录",'url'=>"usercenter/cashlist"),
         					array("title"=>"红包记录",'url'=>"usercenter/awardlist"),
            			),
            		),
            		array(
            			"title"=>"投资管理",
            			"class"=>"m3",
            			"url"=>"",
            			"list"=>array(
            				array("title"=>"投资明细","url"=>"userproject/orderlist"),
            				array("title"=>"正在投资","url"=>"userproject/orderon"),
            				array("title"=>"已收明细","url"=>"userproject/orderend"),
            				array("title"=>"待收明细","url"=>"userproject/orderwait"),
	            		),
            		),
           			array(
            			"title"=>"借款管理",
           				"class"=>"m5",
            			"url"=>"",
            			"list"=>array(
            				array("title"=>"我的借款","url"=>"userproject/project"),
            				array("title"=>"还款中","url"=>"userproject/repay_project"),
            				array("title"=>"还款明细","url"=>"userproject/repay_view"),
            				array("title"=>"已还完","url"=>"userproject/repay_end"),
	            		),
            		),
            		array(
            			"title"=>"我的百宝箱",
            			"class"=>"m4",
            			"url"=>"",
            			"list"=>array(
           					array("title"=>"邀请好友","url"=>"usercenter/invite"),
            				array("title"=>"理财助手","url"=>"userproject/autoorder"),
          					array("title"=>"系统消息","url"=>"usercenter/message"),
							array("title"=>"资金统计","url"=>"usercenter/myassets"),
            			),
            		),
            		array(
            			"title"=>"安全中心",
            			"class"=>"m7",
            			"url"=>"safecenter/index",
            			"list"=>array(
            				
	            		),
            		),
            	);
            	$now_menu = $this->id.'/'.$this->getAction()->id;
            ?>
	            <ul class="user_menu fl">
	            <?php foreach($menu_arr as $k=>$v){ ?>
	            	<li class="<?php echo $v['class']; ?> <?php echo ($v['url']==$now_menu) ? "sel" : "" ;foreach($v['list'] as $__k=>$__v){
	            		if($now_menu==$__v['url'] || (!empty($__v['nurl']) && in_array($now_menu,$__v['nurl']))){
	            			echo "sel" ;
	            		}
	            	} ?>">
	            		<<?php echo !empty($v['list']) ? "i" : "a" ; ?> href="<?php echo Yii::app()->controller->createUrl($v['url']); ?>"><b></b><em></em><span><?php echo $v['title']; ?></span></<?php echo !empty($v['list']) ? "i" : "a" ; ?>>
	            		<dl>
	            		<?php foreach($v['list'] as $_k=>$_v){ ?>
	            			<dd <?php echo ($now_menu==$_v['url'] || (!empty($_v['nurl']) && in_array($now_menu,$_v['nurl']))) ? "class='sel'" : ""; ?>><a href="<?php echo Yii::app()->controller->createUrl($_v['url']); ?>"><?php echo $_v['title']; ?></a></dd>
	            		<?php } ?>
	            		</dl>
	            	</li>
	            <?php } ?>
	            </ul>
	            <div class="user_con fr">
	            	<?php echo $content; ?>
	            </div>
            </div>
        </div>

<?php $this->endContent(); ?>