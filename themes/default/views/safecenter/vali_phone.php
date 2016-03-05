<!doctype html>
<html>
<meta charset="utf-8">
<body style="background:#fff;">
<link href="<?php echo CSS_URL; ?>layout.css" rel="stylesheet" />
<link href="<?php echo CSS_URL; ?>user.css" rel="stylesheet" />
<script src="<?php echo JS_URL; ?>jquery.min.js"></script> 
<script src="<?php echo JS_URL; ?>layer/layer.js"></script> 
<script src="<?php echo JS_URL; ?>7pointer.js"></script>     
<?php $form = $this->beginWidget('CActiveForm',array(

    )); ?>
<div class="tc_con">
    <table>
	   <tr>
	     <td>原手机：</td>
		 <td><?php echo $user_info -> user_phone; ?><input type="hidden" id="user_phone" value="<?php echo $user_info->user_phone; ?>"/></td>
	   </tr>
	   	<tr>
	     <td>验证码：</td>
		 <td><?php echo $form -> textField($user_model,'code',array('class'=>'tc_text1','style'=>'width:127px;')); ?>
		 <input type="button" style="height:30px;margin-left:10px;background:#df3400;color:white;border:0;width:100px;cursor:pointer;" value="发送验证码" onclick="sendmsg('user_phone','<?php echo Yii::app()->controller->createUrl("safecenter/Sendsms",array("type"=>"vali_phone")); ?>');"></td>
	   </tr>   
	   <tr>
	    <td></td>
		<td>
		   <ul>
			 <li><input type="button" value="取消" id="tc_out3" style="cursor:pointer;" onclick="parent.layer.closeAll();" /></li>
			 <li><button id="tc_in2" value="保存" type="submit">保存</button></li>
		  </ul>
		 </td>
	   </tr>
	</table>
   </div>
<?php $this->endWidget(); ?>
<?php if(!empty($message)){ ?>
<script>
	pointererror('<?php echo $message; ?>', 6);
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsgpar('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>
</body>
</html>