	<div class="container-fluid pd-20">
		<img src="<?php echo WAP_IMG_URL; ?>logo.png" class="center-block" />
	</div>
	<div class="container-fluid pd-20">
		<div class="col-xs-10 col-xs-offset-1">
			<?php
		        $form = $this->beginWidget('CActiveForm', array(
		            'id' => 'myform',
		        	'htmlOptions'=>array("class"=>"form-horizontal"),
		        ));
	        ?>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><img src="<?php echo WAP_IMG_URL; ?>phone.png" style="width:20px;"/></div>
						<?php echo $form->NumberField($model, 'user_phone', array('class'=>'form-control bg-gray', 'placeholder' => '请输入手机号码','maxlength'=>'11', 'required' => 'required')); ?>   
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><img src="<?php echo WAP_IMG_URL; ?>message.png" style="width:20px;"/></div>
						<?php echo $form->NumberField($model, 'code', array('class'=>'form-control bg-gray', 'placeholder' => '请输入验证码','maxlength'=>'6', 'required' => 'required')); ?>
						<div class="input-group-addon sendPhoneCode" id="sendPhoneCode">点击发送</div>
					</div>
				</div>
				<div class="form-group pd-10">
					<div class="input-group">
						<div class="input-group-addon"><img src="<?php echo WAP_IMG_URL; ?>lock.png" style="width:20px;"/></div>
						<?php echo $form->passwordField($model, 'login_pass', array('class'=>'form-control bg-gray','placeholder' => '请输入密码', 'required' => 'required')); ?>
					</div>
				</div>
				<button type="submit" class="btn btn-lg btn-danger login-btn">确定</button>
			<?php $this->endWidget(); ?>
		</div>
	</div>
	
<script>
$("#sendPhoneCode").click(function(){
        var phone=$("#Register_user_phone").val();
        $.post("<?php echo Yii::app()->controller->createUrl('site/sendsms'); ?>?type=register_phone&phone="+phone,{},function(data){
            var obj = eval("("+data+")");
            if(obj.status == 1){
                window.sec = 60;
                djs('sendPhoneCode');
            }else{
                msg(obj.msg,'');
            }
        });
    });
    
    function djs(btn){
        $("#"+btn).attr('disable','disabled');
        if(window.sec>=0){
            $("#"+btn).text('倒计时'+window.sec+'秒');
            window.sec --;
            setTimeout("djs('"+btn+"');",1000);
        }else{
            $("#"+btn).removeAttr('disable');
            $("#"+btn).text('获取验证码');
            window.sec=60;
        }

    }
    
</script>
<?php if (!empty($first_error)) { ?>
   <script>
       msg('<?php echo $first_error ?>','');
   </script>
<?php } ?>