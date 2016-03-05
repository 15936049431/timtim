<?php
    $this -> page_title = '借款申请';
?>
<?php if(!empty($message)){ ?>
<script type="text/javascript">
layer_alert_p('<?php echo $message[0]; ?>','<?php echo $message[1]; ?>','<?php echo $message[2]; ?>','<?php echo $message[3]; ?>');
</script>
<?php } ?>
<div class="wrapper">
	   <ul class="router mt30">
    		<li ><span>当前位置：</span></li>
    		<li><a href="index.html">首页</a><span class="divider">></span></li>
    		<li><span class="current">我要借款</span></li>
    	</ul>

    	<div class="tac mt20">
    		<img src="<?php echo IMG_URL; ?>borrow_pic01.png">
    	</div>
    	<div class="clearfix mt30 loan-box">
    		<div class="fl loan-form-box">
    			<div class="loan-title"><strong class="fwb fsg">借款意向</strong></div>
				<?php $form = $this->beginWidget('CActiveForm',array(
						'htmlOptions'=>array(
							'name'=>'apply_project'
						),
					)); ?>
    			<div class="loan-form mt40">
	    			<p class="line">
	    				<label class="label">企业名称：</label>
	    				<?php echo $form->textField($model,'p_name',array('class'=>'input','placeholder'=>'请填写企业名称')); ?>
	    			</p>
	    			<p class="line">
	    				<label class="label">借款金额：   </label>
	    				<?php echo $form->textField($model,'p_money',array('class'=>'input yuan','placeholder'=>'请填写借款金额','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>
	    			</p>
	    			<p class="line">
	    				<label class="label">借款期限：</label>
						<?php echo $form->textField($model,'p_time_limit',array('class'=>'input month','placeholder'=>'请填写借款期限','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>
	    			</p>
	    			<p class="line">
	    				<label class="label">联系手机号码：</label>
						<?php echo $form->textField($model,'p_phone',array('class'=>'input','placeholder'=>'请填写联系电话','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>
	    			</p>
	    			<p class="line">
	    				<label class="label">联系人姓名：</label>
	    				<?php echo $form->textField($model,'p_realname',array('class'=>'input','placeholder'=>'请填写联系人姓名')); ?>
	    			</p>
	    			<p class="line">
	    				<label class="label">所在地区：</label>
						<?php echo $form->dropDownList($model,'p_city',$area,array('class'=>'select')); ?>
	    				<select class="select" name="ProjectApply[p_province]" id="ProjectApply_p_province"></select>
	    			</p>
					<p class="line">
	    				<label class="label">验证码：</label>
						<?php echo $form->textField($model,'authcode',array('class'=>'input','style'=>'width:100px;','placeholder'=>'请填写验证码')); ?>	
						<?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'vertical-align:middle;cursor:pointer;'))); ?>	
	    			</p>
	    		</div>	
    		</div>
    		<div class="fr loan-tips-box">
    			<div class="loan-title"><strong class="fwb fsg">关于借款申请的提示</strong></div>
    			<div class="loan-tips mt40">
    				<p class="mb15">
    					1．仅适用于企业和组织机构提交借款意向，非个人借款申请。
    				</p>
    				<p class="mb15">
    					2．提交申请后及担保机构进行初步审核，并电话联系了解借款需求详情，根据不同行业性质的企业或组织机构需要提供相关资质证明。
    				</p>
    				<strong class="special fc1">
    					个人借款需求，请注册登录该网站，进入用户中心—我要借款中提交申请。
    				</strong>
    			</div>
    		</div>
    	</div>
		<div style="margin-left:50px;"></div>
    	<div class="tac mt30 mb50">
    		<input class="loan-submit" type="submit" value="提交申请">
    	</div>
    	<?php $this->endWidget(); ?>
    </div>
					<script>
						$(function(){
                        	$("#ProjectApply_p_city").change(function(){
								getProvince();
							});
							getProvince();
							function getProvince(){
								var city=$("#ProjectApply_p_city").val();
								$.post("<?php echo Yii::app()->controller->createUrl('GetCity') ?>",{'city':city},
									function(result){
										if(result!="error"){
											$("#ProjectApply_p_province").html(result);
										}
									}
								);
							}
                        });
					</script>