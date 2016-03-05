<?php 
	$this->page_title="用户中心";
?>				
<div class="user_info clear">
	<dl class="fl">
	   <dd class="clear">
	     <div class="user_avatar fl">
	     <a href="javascript:;" style="cursor:pointer;" onclick="uploaduserpic();">
	       <?php if(!empty($user_info->user_pic)){ ?>
               <img style="width:100px;height:100px;" src="<?php echo SITE_UPLOAD.'userpic/'.$user_info->user_pic; ?>"/>
           <?php }else{ ?>
               <img src="<?php echo UIMG_URL; ?>default_user_img.jpg" style="width:100px;height:100px;" class="fl" />
           <?php } ?>
         </a>
	     </div>
	     <div class="user_info_column1 fl">
	        <h2><?php echo $hello; ?></h2>
	        <h1><?php echo $user_info->user_name; ?></h1>
	        <div class="user_progress">
	           <em style="width:<?php echo $user_safenum; ?>%"></em>
	        </div>
	        <p>安全等级：<?php echo $user_safechar; ?></p>
	     </div>
	     <div class="user_info_column2 fl">
	        <h1>资产总额：<i><?php echo $assets_info->total_money; ?>元</i></h1>
	        <h3>可用余额：<?php echo $assets_info->real_money; ?>元</h3>
	     </div>
	  </dd>
	  <dt>资产排名：<?php echo $money['num']; ?></dt>
	</dl>
	<div class="user_main_btns fl">
	    <a href="<?php echo Yii::app()->controller->createUrl("usercenter/recharge"); ?>" class="btn1">充值</a>
	    <a href="<?php echo Yii::app()->controller->createUrl("usercenter/cash"); ?>" class="btn2">提现</a>
	</div>
</div>
<div class="user_column mt20 clear">
    <div class="user_column_left fl">
        <h1><span>资产统计</span><i></i></h1>
        <dl class="clear">
          <dd><h3>冻结余额</h3><p>￥<?php echo $assets_info->frost_money; ?></p> </dd>
          <dd class="ml10"><h3>待收余额</h3><p>￥<?php echo $assets_info->wait_total_money; ?></p></dd>
        </dl>
        <div class="user_day_total">最近7天累计收款：<i>￥<?php echo $collect_time['money']; ?></i></div>
        <div class="user_charts"></div>
        <script type="text/javascript">
            $(function () {
               $(".user_charts").highcharts({
                   credits: { text: ''},
                   title: {text: '',x: -20 },//center
                   subtitle: {x: -20},
                   chart: {height: 200},
                   xAxis: {categories: [<?php foreach($collect_time['list'] as $k=>$v){echo "'{$k}',"; }?>]},
                   yAxis: {title: {text: ''},
                   plotLines: [{value: 0,width: 1,color: '#808080'}] },
                   tooltip: {valueSuffix: '元'},
                   legend: {enabled: false},
                   series: [{name: '收益',data: [<?php foreach($collect_time['list'] as $k=>$v){echo "{$v},"; }?>],color: '#ff8a10'}]
               });
            })
        </script>
    </div>
    <ul class="user_column_right fr mt20">
        <li><span>最近到账金额</span><i>到账时间</i></li>
        <?php foreach($collect_list as $k=>$v){ ?>
	        <li><span><?php echo $v->p_repayaccount; ?>元</span><i><?php echo LYCommon::subtime($v->p_repaytime,3); ?></i></li>
	    <?php } ?>
    </ul>
<div class="user_main_tools clear">
<!--     <div class="qq"> -->
<!--        <span>你的专属客服：</span> -->
<!--        <a href="#">平平</a> -->
<!--     </div> -->
    <div class="auto">
       <span>理财助手：<?php echo (!empty($auto_order) && $auto_order->p_order_status==1) ? "开启" : "未开启"  ; ?></span>
       <a href="<?php echo Yii::app()->controller->createUrl("userproject/autoorder"); ?>">[设置]</a>
    </div>
<!--     <a href="#" class="zq">债权转让</a> -->
    <a href="<?php echo Yii::app()->controller->createUrl("usercenter/invite"); ?>" class="fri">邀请好友</a>
    </div>
</div>
<script>
	function uploaduserpic(){
         <?php if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0") || strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) { ?>
    	  $.layer({
            type: 2,
            fix: true,
            offset: ['40px' , ''],
            title: ['上传头像','font-size:14px;color:#666;border-bottom:1px #005178 solid;background:none; font-weight:bold;'],
            shadeClose: true,
            border:[0],
            iframe: {
                src: '<?php echo Yii::app()->controller->createUrl("usercenter/uploaduserpic");?>',
                scrolling:'no'
            },
            area : ['700px' , '535px'],
            closeBtn : [0 , true],
            shade : [0.5 , '#000' , true]
          });
         <?php }else{ ?>
         
          layer.open({
    		type: 2,
    		title: '上传头像',
    		shadeClose: true,
    		shade: 0.5,
    		area: ['700px', '550px'],
    		content: ['<?php echo Yii::app()->controller->createUrl("usercenter/uploaduserpic");?>','no'],
   		});
         <?php } ?>
     }
</script>