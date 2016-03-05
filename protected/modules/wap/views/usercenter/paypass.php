<?php 
	$this->page_title="交易密码";
?>
<div class="container-fluid pd-20">
		<?php $form = $this->beginWidget('CActiveForm',array("id"=>"chongzhi",
		  "htmlOptions"=>array(
				)
			)
		  ); ?>
		  <p>首次设置“交易密码”时，“登陆密码”即为“原支付密码”</p>
		  <div class="form-group">
			<label for="card" class="sr-only">原交易密码</label>
			<?php echo $form->PasswordField($model, "pay_pass", array("class"=>"form-control","placeholder" => "原交易密码", "required" => "required")); ?>
		  </div>
		  <div class="form-group">
			<label for="card" class="sr-only">设置交易密码</label>
			<?php echo $form->PasswordField($model, "new_pass", array("class"=>"form-control","placeholder" => "设置交易密码",  "required" => "required")); ?>
		  </div>
		  <div class="form-group">
			<label for="card" class="sr-only">重复输入交易密码</label>
			<?php echo $form->PasswordField($model, "re_new_pass", array("class"=>"form-control","placeholder" => "重复输入交易密码",  "required" => "required")); ?>
		  </div>
		  <button type="submit" class="btn btn-default" style="width:100%;margin-top:20px;">确定修改</button>
		  <?php $this -> endWidget(); ?>	
</div>
<?php if (!empty($message)) { ?>
    <script>msg('<?php echo $message[0]; ?>','<?php echo empty($message[1]) ? "" : $message[1]; ?>');</script>
<?php } ?>