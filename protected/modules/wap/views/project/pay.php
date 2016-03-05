<div class="container-fluid project-info">
		<h3><?php echo $project_info->p_apr; ?>%</h3>
		<h4>预期年化收益率</h4>
	</div>
  
	<div class="container-fluid pd-0 center-p">
		<div class="row mg-0" style="padding-top:5px;">
		  <div class="col-xs-4 bd-1">
			<p>期限:<?php echo $project_info->p_time_limit; ?><?php echo $project_info->p_time_limittype==1 ? "天" : "个月" ;?></p>
		  </div>
		  <div class="col-xs-4 bd-1">
			<p><?php echo LYCommon::GetItem_of_value($project_info->p_style,'project_repay_type'); ?></p>
		  </div>
		  <div class="col-xs-4 bd-1">
			<p>最低<?php echo $project_info->p_lowaccount; ?>元起投</p>
		  </div>
		</div>
	</div>
	
	<div class="container-fluid pd-20 bg-gray"></div>
	
	<div class="container-fluid pd-0">
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">标的总额</div>
			<div class="pull-right"><?php echo $project_info->p_account; ?></div>
		</div>
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">剩余投资金额</div>
			<div class="pull-right"><?php echo LYCommon::sprintf_diy($project_info->p_account-$project_info->p_account_yes); ?></div>
		</div>
		<?php $form = $this->beginWidget('CActiveForm',array("id"=>"chongzhi",
		  "htmlOptions"=>array(
				)
			)
		  ); ?>
		<div class="form-group">
			<label for="card" >投资金额</label>
			<?php echo $form->NumberField($project_order_model, "p_money", array("class"=>"form-control","placeholder" => "投资金额", "required" => "required",'onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>
		  </div>
		  <?php if($user_info->pay_pass != $user_info->login_pass){ ?>
		<div class="form-group">
			<label for="card" >交易密码</label>
			<?php echo $form->PasswordField($project_order_model, "pay_pass", array("class"=>"form-control","placeholder" => "交易密码",  "required" => "required")); ?>
		 </div>
		
	</div>
	<button type="submit" class="btn btn-sm btn-danger project_btn">立即投资</button>
		  <?php } else{ ?>
					<div class="form-group">
					<label for="card" >交易密码</label>
					<div style="text-align:center;"><a href="<?php echo Yii::app()->controller->createUrl("usercenter/paypass"); ?>">请先设置交易密码</a></div>
				 </div>
			  </div>
		  <?php } ?>
	<?php $this->endWidget(); ?>
	
<?php if (!empty($message)) { ?>
    <script>msg('<?php echo $message[0]; ?>','<?php echo empty($message[1]) ? "" : $message[1]; ?>');</script>
<?php } ?>