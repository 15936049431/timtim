<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=8" />
        <title><?php echo Yii::app()->params['site_name']; ?></title>
        <link href="<?php echo UCSS_URL; ?>user.css" rel="stylesheet" />
		<script src="<?php echo JS_URL; ?>jquery-1.7.1.min.js"></script> 
		<?php 
		  	  if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0")) {
				$script="<script src='".JS_URL."layer-old/layer.min.js'></script><script src='".JS_URL."7pointer.js'></script>";
			  }elseif(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) {
				$script="<script src='".JS_URL."layer-old/layer.min.js'></script><script src='".JS_URL."7pointer.js'></script>";
			  }else{
			  	$script="<script src='".JS_URL."layer/layer.js'></script><script src='".JS_URL."7pointer_back.js'></script>";
			  }
			  echo $script;
		?> 
    </head>
    <body>
        <style type="text/css"> body { background: #fff; } </style>
        <?php $form = $this -> beginWidget('CActiveForm',array(
                'id'=>'changephone1-form',
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'name'=>'form1',
                	'class'=>'user_binding',
                ),
            )); ?>
            <table>
                <tr>
			     <td>原手机：</td>
				 <td><?php echo $user_info -> user_phone; ?><input type="hidden" id="user_phone" value="<?php echo $user_info->user_phone; ?>"/></td>
			   </tr>
			   	<tr>
			     <td>验证码：</td>
				 <td><?php echo $form -> textField($user_model,'code',array('style'=>'width:100px;')); ?>
				 <input type="button" class="btn" style="font-size:12px;height:30px;line-height:30px;" value="发送验证码" id="sendcode"></td>
			   </tr>              
                <tr>
                    <td colspan="2" class="tc">
                        <input type="submit" class="btn" value="提交" />
                        <input type="reset" class="btn_g" value="取消" onclick="parent.layer.closeAll();"  />
                    </td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
    </body>
<script>
function djs(){
	if(window_sec>0){ 
	   window_sec--; 
	   $("#sendcode").attr("disabled","disabled"); 
	   $("#sendcode").css("background","gray");
	   $("#sendcode").val(window_sec+"秒后可提交"); 
	}else{ 
		$("#sendcode").removeAttr("disabled"); 
		$("#sendcode").css("background","#ff8a10"); 
		$("#sendcode").val("发送短信"); 
	} 
	if(window_sec<60){ 
	    setTimeout("djs();",1000); 
	}
}
	$("#sendcode").click(function(){
		sendmsg('user_phone','<?php echo Yii::app()->controller->createUrl("safecenter/Sendsms",array("type"=>"safecenter_change_phone_1")); ?>');
		window_sec = 60;
        djs();
	});
</script>
<?php if(!empty($message)){ ?>
<script>
	pointererror('<?php echo $message; ?>',6);
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsgpar('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>
</html>