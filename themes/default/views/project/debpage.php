<?php
    $this -> css = array('jquery.bxslider');
    $this -> js = array('layer/extend/layer.ext','jquery.bxslider');
    $this -> page_title = '投资详情';
?>

<div class="archead bg1">
		<div class="wrapper clearfix">
			<div class="fl">
				<h1 class="title"><?php echo $project_order_info->project->p_name; ?></h1>
				<div class="date">发布时间：2015-03-06 15:11:46</div>
			</div>
                    <a class="back" href="<?php echo Yii::app()->controller->createUrl('project/debenture'); ?>">返回项目列表>></a>
   		</div>
	</div>
	
	<div class="wrapper clearfix">
		<div class="fl invest-box-a border-mod">
			<div class="ofh">
				<div class="col-1 fl">
					<div>借款总额（元）</div>
					<div class="info">￥<span class="data-1"><?php echo $project_order_info->project->p_account; ?></span></div>
				</div>
				<div class="col-2 fl">
					<div>年化收益</div>
					<div class="info"><span class="data-2"><?php echo $project_order_info->project->p_apr; ?></span>%</div>
				</div>
				<div class="col-3 fl">
					<div>期限</div>
					<div class="info"><span class="data-3"><?php echo $project_order_info->project->p_time_limit; ?></span>个月</div>
				</div>
			</div>
			<div class="lfc2 mt35">
				<span class="fl">还款方式：<?php echo LYCommon::GetItem_of_value($project_order_info->project->p_style,'project_repay_type'); ?></span>
				<span class="fl">投标限额: <?php echo ($project_order_info->project->p_lowaccount==0)?"无限制":$project_order_info->project->p_lowaccount;?>-<?php echo ($project_order_info->project->p_mostaccount==0)?"无限制":$project_now->p_mostaccount;?></span>
				<span class="fl">投标奖励：<?php if($project_order_info->project->p_award_type==0){echo "无";}elseif($project_order_info->project->p_award_type==1){echo "按照百分比奖励";}else{echo "按照固定金额奖励";} ?></span>
				<span class="fl">奖励结果：<?php if($project_order_info->project->p_award_type==0){echo "无";}elseif($project_order_info->project->p_award_type==1){echo $project_order_info->project->p_award."%";}else{echo $project_order_info->project->p_award."元";} ?></span>
			</div>
			<div class="invest-box-a-ft lbg1">
				<span class="ml25">剩余时间：<span class="fc1">0</span>天<span class="fc1">0</span>小时<span class="fc1">0</span>分</span>
				<span class="ml25">待收金额（元）<span class="fc1"><?php echo $project_order_info->p_waitrepay; ?></span></span>
			</div>
		</div>
		
		<div class="fr invest-box-b border-mod">
			<div>购买所需金额</div>
			<div class="money fc1">￥<?php echo $project_order_info->p_money-($project_order_info->p_repayyesaccount-$project_order_info->p_yesinterest); ?></div>
			<div class="clearfix fsa mt5">
				<span class="fl">账户余额：￥<?php echo $assets_info -> real_money; ?></span>
                                <a class="fr fc1" href="<?php echo Yii::app()->controller->createUrl('usercenter/recharge'); ?>">点此充值</a>
			</div>
			<form action="" method="">
			<div class="tac mt10">
                            <input type="password" id="pay_pass" class="input" placeholder="输入支付密码">
			</div>
			<div class="tac mt20">
                            <input class="btn-bbc1 submit" onclick="deb_pay();" type="button" value="立即买入">
			</div>
			</form>
		</div>
		<!--
		<div class="fr invest-box-b border-mod">
			<div>可投金额</div>
			<div class="money fc1">￥0.00</div>
			<div class="clearfix fsa mt5">
				<span class="fl">账户余额：￥0</span>
				<a class="fr fc1" href="">点此充值</a>
			</div>
			<form action="" method="">
				<div class="tac mt20">
					<input class="btn-bbc2 submit" type="submit" value="项目还款" disabled="true">
				</div>
			</form>
		</div>
		-->
	</div>
<div class="wrapper mt40">
		<div id="tab1" class="invest-box-c border-mod"> 
			<div class="tabnav sty2-nav">
				<a href="javascript:;">项目详情</a>
				<a href="javascript:;">项目图片</a>
				<a href="javascript:;">还款计划</a>
			</div>

			<div class="tabcon">
				<?php echo $project_order_info->project->p_content ;?>
			</div>

			<div class="tabcon">
                            <div class="slider3" id="extimgs">
                                <?php foreach($project_pic_list as $k => $v){ ?>
                                      <img alt="aa" layer-img="<?php echo SITE_UPLOAD.'project/'.$v->p_src ?>" src="<?php echo SITE_UPLOAD.'project/s_'.$v->p_src ?>">
                                <?php } ?>
                            </div>
			</div>

			<div class="tabcon">
				<table width="100%" class="normal-table">
					<thead>
						<tr>
                                                    <th>期数</th>
                                                    <th>应还款日期</th>
                                                    <th>本期应还本息</th>
                                                    <th>利息</th>
                                                    <th>逾期天数</th>
                                                    <th>逾期利息</th>
                                                    <th>状态</th>
						</tr>
					</thead>
					<tbody>
                                            <?php foreach($project_repay_list as $k => $v){ ?>
                                            <tr>
                                                <td><?php echo $v->p_order+1; ?></td>
                                                <td><?php echo LYCommon::subtime($v->p_repaytime,3); ?></td>
                                                <td>￥<?php echo $v->p_repayaccount; ?></td>
                                                <td>￥<?php echo $v->p_interest; ?></td>
                                                <td><?php echo $v->p_lateday; ?>天</td>
                                                <td>￥<?php echo $v->p_lateinterest; ?></td>
                                                <td><?php if($v->p_status==1){echo "已还款";}elseif($v->p_status==2){echo "网站代还款";}else{echo "未还款";} ?></td>
                                            </tr>
                                            <?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<script type="text/javascript">
        $(function () {
            //
            $('#tab1').zTab({
                    trigger:'c',
                    cur:2, 
            });
            //
            percentbar($('.percentbar'));
        });
        
        $('.slider3').bxSlider({
            slideWidth: 200,
            minSlides: 2,
            maxSlides: 4,
            moveSlides: 1,
            slideMargin: 10
          });

        layer.photosPage({
            parent: '#extimgs',
            title: '项目图片',
            id: 112 //相册id，可选
        });
        
        function deb_pay(){
            var pay_pass = $("#pay_pass").val();
            if(pay_pass == '' || pay_pass == null){
                alert('支付密码不可为空');
                return false;
            }
            if(<?php echo $assets_info -> real_money; ?><<?php echo $project_order_info->p_money-($project_order_info->p_repayyesaccount-$project_order_info->p_yesinterest); ?>){
                alert('可用余额不足');
                return false;
            }
            
            $.post("<?php echo Yii::app()->controller->createUrl('project/pay_deb') ?>",{
                'Paydeb[oid]':'<?php echo $project_order_info->p_id; ?>',
                'Paydeb[pay_pass]':pay_pass
            },function(data){
                var obj = eval("("+data+")");
                if(obj.status == 1){
                    alert('转让成功');
                    setTimeout(function(){
                        location.href='<?php echo Yii::app()->controller->createUrl('userproject/order_list'); ?>';
                    },2000);
                }else{
                   switch(obj.status){
                       case 2:
                           alert('支付密码错误');
                           break;
                   }
                }
            });
        }
</script>