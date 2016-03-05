<!doctype html>
<html>
<meta charset="utf-8">
<body style="background:#fff;">
<link href="<?php echo CSS_URL; ?>layout.css" rel="stylesheet" />
<link href="<?php echo CSS_URL; ?>user.css" rel="stylesheet" />
<script src="<?php echo JS_URL; ?>jquery.min.js"></script> 
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

<?php $form = $this -> beginWidget('CActiveForm',array(
                'id'=>'changepaypass-form',
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'name'=>'form1',
                ),
            )); ?>
   <div class="tc_con">
    <table>
	   	<tr>
	     <td>新支付密码</td>
		 <td><?php echo $form -> passwordField($model,'new_pass',array('class'=>'tc_text1','placeholder'=>'请输入新的支付密码')); ?></td>
	   </tr>
	   <tr>
	     <td>确认新支付密码</td>
		  <td><?php echo $form -> passwordField($model,'re_new_pass',array('class'=>'tc_text1','placeholder'=>'请输入新的支付密码')); ?></td>
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