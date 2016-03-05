<?php
    $this -> page_title = '找回密码';
    $this -> css = array("login");
    $this -> load_jquery = false;
?>
<div class="reg_main wrap">
    <?php $form = $this -> beginWidget('CActiveForm',array(
             'id'=>'forgot_pass_form',
    		 'htmlOptions'=>array("class"=>"reg_form main",),
             'enableAjaxValidation'=>true,
             'enableClientValidation'=>true,
             'clientOptions'=>array(
             'validateOnSubmit'=>true,
             'validateOnChange'=>true,
            ),
    )); ?>
                <table class="fl">
                    <tr>
                        <td class="tl">已有账户？<a href="<?php echo Yii::app()->controller->createUrl("site/login"); ?>">立即登录</a></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textField($model,'user_phone',array('class'=>'ba phone')); ?>
                            <span class="error" style="display:none;"><?php echo $form->error($model,"user_phone"); ?></span>
                            <span class="input_desc">请输入手机号码</span>
	                        <span class="Validform_checktip">请输入正确的手机号码。</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="code_auth" class="ba code" id="code_auth" />
                            <span class="input_desc">请输入验证码</span>
                            <?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'margin-left:35px;vertical-align:middle;cursor:pointer;'))); ?>
	                        <span class="Validform_checktip">请输入正确的图形验证码。</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textField($model,'code',array('class'=>'ba code')); ?>
                            <span class="error" style="display:none;"><?php echo $form->error($model,"code"); ?></span>
                            <span class="input_desc">请输入验证码</span>
                            <button type="button" class="send" id="sendMessage">发送短信</button>
                            <span class="Validform_checktip">请输入验证码</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        	<?php echo $form->passwordField($model,'new_pass',array('class'=>'ba pwd')); ?>
                        	<span class="error" style="display:none;"><?php echo $form->error($model,"new_pass"); ?></span>
                            <span class="input_desc">请输入密码</span>
                            <span class="Validform_checktip">请输入6-20位字母、数字或中文，不含特殊字符。</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        	<?php echo $form->passwordField($model,"re_new_pass",array("class"=>"ba pwd")); ?>
                        	<span class="error" style="display:none;"><?php echo $form->error($model,"re_new_pass"); ?></span>
                            <span class="input_desc">请确认密码</span>
                            <span class="Validform_checktip">请输入6-20位字母、数字或中文，不含特殊字符。</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="修改密码" class="btn fl" />                            
                        </td>
                    </tr>
                </table>
	<?php $this -> endWidget(); ?>
</div>
<script>
function djs(){
	if(window_sec>0){ 
	   window_sec--; 
	   $("#sendMessage").attr("disabled","disabled"); 
	   $("#sendMessage").css("background","gray");
	   $("#sendMessage").html(window_sec+"秒后可提交"); 
	}else{ 
		$("#sendMessage").removeAttr("disabled"); 
		$("#sendMessage").css("background","#ff8a10"); 
		$("#sendMessage").html("发送短信"); 
	} 
	if(window_sec<60){ 
	    setTimeout("djs();",1000); 
	}
}
$(function () {
	//input点击隐藏描述
    setTimeout(function () {
        $("input[type=text],input[type=password]").each(function () {
            if ($(this).val() != "") $(this).siblings(".input_desc").hide();
        }).focus(function () {
        	$(this).siblings(".input_desc").hide();
        }).blur(function () {
            if ($(this).val() == "")
                $(this).siblings(".input_desc").show();
        });
        $(".input_desc").click(function () {
            $(this).siblings("input[type=text],input[type=password]").focus();
        });
    }, 500);
    $(".reg_form input").focus(function () {
        $(this).siblings(".Validform_checktip").show();
    }).blur(function () {
    	if($(this).siblings(".error").find(".errorMessage").html()=="" || $(this).siblings(".error").find(".errorMessage").html()==null){
    		$(this).siblings(".Validform_checktip").hide();
    	}else{
    		$(this).siblings(".Validform_checktip").html($(this).siblings(".error").find(".errorMessage").html());
    	}
    })
    setInterval(function(){
    	$(".errorMessage").each(function(){
	    	if(($(this).html()=="" || $(this).html()==null || $(this).css("display")=="none")){
		    	if(($(this).parent().siblings(".ba").val()!="" && $(this).parent().siblings(".ba").val()!=null) || $(this).parent().attr("attr")=="cnull"){
			    	$(this).parent().siblings(".Validform_checktip").hide();
		    	}
	    	}else{
	    		$(this).parent().siblings(".Validform_checktip").html($(this).html());
	    		$(this).parent().siblings(".Validform_checktip").show();
	    	}
	    });
    },500);
    $("#sendMessage").click(function(){
		if(!(/^1[0-9]{10}$/.test($("#Userprofile_user_phone").val()))){ 
			pointererror('不是完整的11位手机号或者正确的手机号前七位', 6);
		}else if($("#code_auth").val()=="null" || $("#code_auth").val()==""){
			pointererror('图形验证码不能为空', 6);
		}else{
            $.post("<?php echo Yii::app()->controller->createUrl("site/sendphone"); ?>",{"phone":$("#Userprofile_user_phone").val(),"authcode":$("#code_auth").val(),"type":"forgotpass"},function(result){
            	 var obj = eval("("+result+")");
            	 if(obj.status == 1){
            		 pointererror(obj.msg, 1);
            		 window_sec = 60;
            		 $("#yw0").click();
                     djs();
	 	         }else{
	 	             pointererror(obj.msg, 6);
	 	             $("#yw0").click();
	 	         }
            });
		}
 	});
})
</script>
<?php if(!empty($message)){ ?>
<script>
	pointererror('<?php echo $message; ?>',6);
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsg('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>