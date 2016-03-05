<?php 
	$this-> page_title = "产品详情" ;
	$this-> css = array("invest");
	$this-> js = array("raphael");
?>
	<div class="main">
            <div class="site">
                <a href="/">首页</a>
                <i class="fontello">&#xe83f;</i>
                <a href="<?php echo Yii::app()->controller->createUrl("project/list"); ?>">我要投资</a>
                <i class="fontello">&#xe83f;</i>
                <span>产品详情</span>
            </div>
            <div class="inv_c_info clear ba">
                <div class="inv_c_info_l fl">
                    <h1><?php echo $project_now->p_name; ?></h1>
                    <div class="clear">
                        <dl>
                            <dt>借款金额</dt>
                            <dd>￥<?php echo $project_now->p_account; ?></dd>
                        </dl>
                        <dl>
                            <dt>年化率</dt>
                            <dd><?php echo $project_now -> p_apr; ?>%</dd>
                        </dl>
                        <dl>
                            <dt>投资期限</dt>
                            <dd><?php echo $project_now->p_time_limit.(($project_now->p_time_limittype==1 ? "天" : "个月" ));?></dd>
                        </dl>
                    </div>
                    <ul class="clear">
                        <li>
                            <span>保障方式：</span>
                            <i>本息保障</i>
                        </li>
                        <li>
                            <span>协议书：</span>
                            <i><a href="<?php echo Yii::app()->controller->createUrl('agreement/invest',array('id'=>$project_now->p_id)); ?>">查看</a></i>
                        </li>
                        <li>
                            <span>还款方式：</span>
                            <i><?php echo LYCommon::GetItem_of_value($project_now->p_style,'project_repay_type'); ?></i>
                        </li>
                        <li>
                            <span>剩余时间：</span>
                            <i class="end_time"><?php echo $timer; ?></i>
                        </li>
                    </ul>
                </div>
	                <?php if($project_now->p_status==1){ ?>
						<?php if($project_now->p_account>$project_now->p_account_yes){ ?>
							<?php if(isset(Yii::app()->user->id)){ ?>
					          <?php $over_class = "" ; ?>
					        <?php }else{ ?>
								<?php $over_class = "over_login" ; ?>
							<?php } ?>
						<?php }else{ ?>
							  <?php $over_class = "over_full" ; ?>
						<?php } ?>
					<?php }elseif($project_now->p_status==2 || $project_now->p_status==0){ ?>
						  <?php $over_class = "over_first" ; ?>
					<?php }elseif($project_now->p_status==3){ ?>
						  <?php $over_class = "over_repay" ; ?>
					<?php }elseif($project_now->p_status==4){ ?>
    	 				  <?php $over_class = "over_fail" ; ?>
					<?php }elseif($project_now->p_status==5){ ?>
						  <?php $over_class = "over_liu" ; ?>
					<?php }elseif($project_now->p_status==6){ ?>
						  <?php $over_class = "over_cancle" ; ?>
					<?php }else{ ?>
						  <?php $over_class = "over_ending" ; ?>
					<?php } ?>
                <div class="inv_c_info_r <?php echo $over_class; ?> fr clear_fixed">
                    <dl class="fl">
                        <dt>投资金额</dt>
                        <dd>
                            <div class="progress_c_big"><span><?php echo $project_now->p_account_yes/$project_now->p_account*100<100 ? LYCommon::sprintf_diy_9($project_now->p_account_yes/$project_now->p_account*100) : 100; ?>%</span></div>
                        </dd>
                        <dd>
                            <h4>剩余金额</h4>
                            <p>￥<?php echo LYCommon::sprintf_diy_9($project_now->p_account-$project_now->p_account_yes); ?></p>
                        </dd>
                    </dl>
                    <ul class="fr">
	                    <?php if(empty($over_class)){
	                    	$form=$this->beginWidget('CActiveForm',array(
							'htmlOptions'=>array(
								'name'=>'form1',
							),
						));?>
                        <li>可用余额：￥<?php echo !empty($user_assets)?$user_assets->real_money:0; ?></li>
                        <li><?php echo $form->textField($project_order_model,'p_money',array('placeholder'=>'投资金额','onkeyup' => "amount(this)",'onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>
                        	<span>￥</span><a href="javascript:void(0);" id="loadmore">最大余额</a></li>
                        <?php if($project_now->p_dxb!=""){ ?>
				        	<li>定向标密码: </li>
				        	<li><?php echo $form->passwordField($project_order_model,'p_dxb',array('placeholder'=>'定向标密码')); ?></li>
				         <?php }else{ ?>
				         	<li>预计年利率：<?php echo $project_now->p_apr; ?>%</li>
				         <?php } ?>
                        <li><?php echo $form->passwordField($project_order_model,'pay_pass',array('placeholder'=>'交易密码')); ?></li>
                        <li><?php echo $form->textField($project_order_model,'authcode',array('placeholder'=>'验证码','class'=>'authcode')); ?>
	                	<?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'margin-left:35px;vertical-align:middle;cursor:pointer;'))); ?></li>
                        <li><input type="button" id="submit_form" class="btn" value="立即投资" /></li>
                        <?php $this->endWidget(); }else{ ?>
                        	<li>可用余额：￥0.00</li>
                        	<li><input type="text" placeholder="输入投资金额" /><span>￥</span><a href="#">最大余额</a></li>
                        	<li>预计年利率：21.6%</li>
                        	<li><input type="password" placeholder="交易密码（非登录密码）" /></li>
                        	<li><input type="text" placeholder="验证码" class="authcode" />
	                	<?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'margin-left:35px;vertical-align:middle;cursor:pointer;'))); ?></li>
                        	<li><input type="button" class="btn" value="立即投资" /></li>
                        <?php } ?>
                    </ul>
                    <em class="<?php echo $over_class; ?>">
                    	<?php if($over_class=="over_login"){ ?>
                    		<a href="<?php echo Yii::app()->controller->createUrl("site/login"); ?>" class="over_login_login"></a>
                    	<?php } ?>
                    </em>
                </div>
            </div>
            <div class="inv_c_content mt20 mb20 ba">
                <ul class="inv_c_tab clear bb">
                    <li class="sel"><span>借贷详情</span></li>
                    <li><span>投资记录</span></li>
                    <li><span>项目图片</span></li>
                </ul>
                <div class="inv_c_content_in">
                    <?php echo $project_now->p_content; ?>
                </div>
                <div class="inv_c_content_in hidden">
                    <table class="inv_c_record ba">
                        <tr>
                            <td>序号</td>
                            <td>投标人</td>
                            <td>投标金额</td>
                            <td>当前年利率</td>
                            <td>投标时间</td>
                        </tr>
                        <?php foreach($order_list as $k=>$v){ ?>
	                        <tr>
	                            <td><?php echo $k+1; ?></td>
	                            <td><?php echo preg_match("/[\x7f-\xff]/", $v->user->user_name)?LYCommon::half_replace_utf8($v->user->user_name):LYCommon::half_replace($v->user->user_name); ?></td>
	                            <td>￥<?php echo $v->p_money; ?>元</td>
	                            <td><?php echo $v->project->p_apr; ?>%</td>
	                            <td><?php echo LYCommon::subtime($v->p_addtime,1); ?></td>
	                        </tr>
	                    <?php } ?>
                    </table>
                </div>
                <div class="inv_c_content_in hidden">
                	<div class="content" id="img_content"> 
				      <ul>
				        <?php foreach($project_pic_list as $k=>$v){ ?>
							<li><img src="<?php echo SITE_UPLOAD.'projectpic/'.$v->p_src ?>" /></li>
						<?php } ?>
				      </ul>         
			       </div>
                </div>
            </div>
        </div>
<script>
$(function () {
    $("#img_content").jbrowse({ width:150 })
    var use_money = <?php echo isset($user_assets) ? $user_assets->real_money : 0; ?>;
	var can_money = <?php echo LYCommon::sprintf_diy_9($project_now->p_account-$project_now->p_account_yes); ?>;
    $("#loadmore").click(function(){
		var _now_money ;
		if(use_money > can_money){
			_now_money = can_money;
		}else{
			_now_money = use_money;
		}
		$("#ProjectOrder_p_money").val(Math.floor(_now_money));	
    });
    $("#ProjectOrder_p_money").keyup(function(){
		var _now_money;
		var _in_money = $(this).val();
		if(_in_money > use_money || _in_money > can_money){
			_now_money = (can_money > use_money) ? use_money : can_money;
			pointererror("您的投标金额大于可投金额",6);
			$(this).val(Math.floor(_now_money));
		}
    });
    $("#submit_form").click(function(){
		var _money = $("#ProjectOrder_p_money").val();
		var _passwd = $("#ProjectOrder_pay_pass").val();
		var _auth = $("#ProjectOrder_authcode").val();
		if(_money == "" || _money == null){
			pointererror("投资金额不可为空",6);
		}else if(_passwd == "" || _passwd == null){
			pointererror("交易密码不可为空",6);
		}else if(_auth == "" || _auth == null){
			pointererror("验证码不可为空",6);
		}else{
			document.form1.submit();
			$(this).attr("disabled","disabled");
		}
    });
})
</script>
<?php if(!empty($message)){ ?>
<script>
	pointererror('<?php echo $message; ?>', 6);
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsg('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>