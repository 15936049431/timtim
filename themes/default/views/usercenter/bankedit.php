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
        <?php $form = $this->beginWidget('CActiveForm',array(
	    'htmlOptions'=>array('name'=>'bank_form','class'=>'user_binding'),
	    )); ?>
            <table>
                <tr>
                    <td width="100">支持银行：</td>
                    <td width="170">
                        <?php echo $form->dropDownList($bank_model,'b_bank',$bank_type,array()); ?>
                    </td>
                </tr>
                <tr>
                    <td>开户省市：</td>
                    <td>
                        <?php echo $form->dropDownList($bank_model,'b_city',$area,array('style'=>'width:90px;')); ?>
		 				<?php echo $form->dropDownList($bank_model,'b_province',array("0"=>"请选择"),array('style'=>'width:95px;')); ?>
                    </td>
                </tr>
                <tr>
                    <td>银行卡号：</td>
                    <td>
                        <?php echo $form->textField($bank_model,'b_cardNum',array('class'=>'long','placeholder'=>'请填写'.$bank_model->getAttributeLabel('b_cardNum'),'onkeyup'=>"value = value.replace(/[^0-9]/g, '')", 'maxlength'=>'40')); ?>
                    </td>
                </tr>
                <tr>
                    <td>核对卡号：</td>
                    <td>
                        <?php echo $form->textField($bank_model,'reb_cardNum',array('class'=>'long','placeholder'=>'请填写'.$bank_model->getAttributeLabel('reb_cardNum'),'onkeyup'=>"value = value.replace(/[^0-9]/g, '')", 'maxlength'=>'40')); ?>
                    </td>
                </tr>
                <tr>
                    <td>发卡支行：</td>
                    <td>
                        <?php echo $form->textField($bank_model,'b_branch',array('class'=>'long','placeholder'=>'请填写'.$bank_model->getAttributeLabel('b_branch').'(可拨打银行客服电话查询)')); ?>
                    </td>
                </tr>
                <tr>
                    <td>验证码：</td>
                    <td>
                        <?php echo $form->textField($bank_model,'authcode',array('class'=>'short','placeholder'=>'请填写验证码')); ?>	
						<?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'vertical-align:middle;cursor:pointer;'))); ?>
                    </td>
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
	$(function(){
      	$("#AssetsBank_b_city").change(function(){
	 		getProvince();
		});
		getProvince();
		function getProvince(){
			var city=$("#AssetsBank_b_city").val();
			$.post("<?php echo Yii::app()->controller->createUrl('usercenter/GetCity') ?>",{'city':city},
				function(result){
					if(result!="error"){
						$("#AssetsBank_b_province").html(result);
					}
				}
			);
		}
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