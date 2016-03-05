<!doctype html>
<html>
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
<?php $form=$this->beginWidget('CActiveForm',array(
				'htmlOptions'=>array(
					'name'=>'form1'
				),
			));?>
<div class="tc_con">
    <table>
	   <tr>
	     <td>借款标题：</td>
		 <td><?php echo $order->project->p_name; ?></td>
	   </tr>
	   <tr>
	     <td>债权总额：</td>
		 <td><font id="start_money"><?php echo LYCommon::sprintf_diy($order->p_money- ($order->p_repayyesaccount - $order -> p_yesinterest)); ?></font></td>
	   </tr>
	   <tr>
	     <td>转让价格：</td>
		 <td><font id="end_money"></font></td>
	   </tr>
	   <tr>
	     <td>转让折扣：</td>
		 <td><?php echo $form->numberField($debt,'debt_expr',array('class'=>'tc_text1','value'=>'95')); ?>%</td>
	   </tr>
	   <tr>
	     <td>交易密码：</td>
		 <td><?php echo $form->passwordField($debt,'pay_pass',array('class'=>'tc_text1','placeholder'=>'交易密码')); ?></td>
	   </tr>
	   	<tr>
	     <td>验证码：</td>
		 <td><?php echo $form -> textField($debt,'authcode',array('class'=>'tc_text1','style'=>'width:127px;')); ?>
		 <?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'vertical-align:middle;cursor:pointer;'))); ?></td>
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
<script>
		$(function(){
			getMoney();
			$("#ProjectDebt_debt_expr").change(function(){
				getMoney();
			});
		})
		function getMoney(){
			var _money=$("#start_money").html();
			var _expr=$("#ProjectDebt_debt_expr").val();
			if(_expr<0 || _expr>100){
				pointererror("转让比例不得小于0大于100",6);
				$("#ProjectDebt_debt_expr").val(95);
				$("#end_money").html((_money*95/100));
			}else{
				$("#end_money").html((_money*_expr/100));
			}
		}
</script>
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