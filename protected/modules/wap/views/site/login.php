	<div class="container-fluid pd-20">
		<img src="<?php echo WAP_IMG_URL; ?>logo.png" class="center-block" />
	</div>
  
	<div class="container-fluid pd-20">
		<div class="col-xs-10 col-xs-offset-1">
			<?php $form = $this->beginWidget('CActiveForm', array("id" => "loginform","htmlOptions"=>array("class"=>"form-horizontal"))); ?>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><img src="<?php echo WAP_IMG_URL; ?>user_name.png" style="width:20px;"/></div>
						<?php echo $form -> textField($model,'username',array('class'=>'form-control bg-gray','required'=>'required','placeholder'=>'请输入手机号码')); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><img src="<?php echo WAP_IMG_URL; ?>lock.png" style="width:20px;"/></div>
						<?php echo $form -> passwordField($model,'password',array('class'=>'form-control bg-gray','required'=>'required','placeholder'=>'请输入密码')); ?>
					</div>
				</div>
				<button type="submit" class="btn btn-lg btn-danger login-btn">确定</button>
			<?php $this->endWidget(); ?>
			<div class="pd-10">
<!-- 				<div class="pull-left"><a href="">忘记密码</a></div> -->
				<div class="pull-right"><a href="<?php echo Yii::app()->controller->createUrl("site/register"); ?>">注册</a></div>
			</div>
		</div>
	</div>
<?php if($form->errorSummary($model)){ ?>
<script>msg('用户名或密码错误','');</script>
<?php } ?>