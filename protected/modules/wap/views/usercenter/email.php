<div class="container-fluid pd-20">
	<?php if($user_info->is_email_check==1){ ?>
		<div class="form-group">
			<label for="type">邮箱:</label>
			<?php echo $user_info->user_email; ?>
		  </div>
	<?php }else{ ?>
		<?php $form = $this->beginWidget('CActiveForm',array("id"=>"chongzhi",
		  "htmlOptions"=>array(
				)
			)
		  ); ?>
		  <div class="form-group">
			<label for="card">邮箱</label>
			<?php echo $form->TextField($user_model,"user_email",array("class"=>"form-control", 'required' => 'required','placeholder'=>"请输入您的邮箱"));?>
		  </div>
		  <div class="form-group">
			<div class="input-group">
				<?php echo $form->TextField($user_model, 'code', array('class'=>'form-control','placeholder' => '请输入验证码', 'required' => 'required')); ?>
				<div class="input-group-addon sendPhoneCode" id="sendEmailCode">点击发送</div>
			</div>
		  </div>
		  <button type="submit" class="btn btn-default" style="width:100%;margin-top:20px;">确定开通</button>
		<?php $this->endWidget(); ?>
	<?php } ?>
</div>
<?php if (!empty($message)) { ?>
    <script>msg('<?php echo $message[0]; ?>','<?php echo empty($message[1]) ? "" : $message[1]; ?>');</script>
<?php } ?>
<script type="text/javascript">
$("#sendEmailCode").click(function(){
	var user_email = $("#Userprofile_user_email").val();
    if(user_email == '' || user_email == null){
        msg("邮箱不可为空","");
    }
    $.post("<?php echo Yii::app()->controller->createUrl('usercenter/sendemail'); ?>?type=safecenter_bind_email&email="+user_email,{
        
    },function(data){
        var obj = eval('('+data+')');
        if(obj.status == 1){
            msg('验证码发送成功',"");
            window.sec = 60;
            djs('sendEmailCode');
        }else{
            msg(obj.msg,"");
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