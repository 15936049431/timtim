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
        <?php if(empty($user_identity)){ ?>
        <?php $form = $this -> beginWidget('CActiveForm',array(
                'id'=>'realname1-form',
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'name'=>'form1',
                	'class'=>'user_binding',
                	'enctype'=>'multipart/form-data',
                ),
            )); ?>
            <table>
                <tr>
                    <td>真实姓名：</td>
                    <td><?php echo $form -> textField($model,'real_name',array('class'=>'long')); ?></td>
                </tr>   
                <tr>
                    <td>身份证号码：</td>
                    <td><?php echo $form -> textField($model,'identity_num',array('class'=>'long')); ?></td>
                </tr>   
                <tr>
                    <td>身份证正面：</td>
                    <td><input name="Identity[identity_positive]" type="file"  accept=".jpg,.jpeg,.gif,.png" ></td>
                </tr>   
                <tr>
                   <td>身份证反面：</td>
                   <td><input name="Identity[identity_negative]" type="file" accept=".jpg,.jpeg,.gif,.png"></td>
                </tr>                
                <tr>
                    <td colspan="2" class="tc">
                        <input type="submit" class="btn" value="提交" />
                        <input type="reset" class="btn_g" value="取消" onclick="parent.layer.closeAll();"  />
                    </td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
       	<?php }else{ ?>
       	<form class="user_binding">
       	<table>
		   <tr>
		     <td>真实姓名：</td>
			 <td><?php echo LYCommon::half_replace($user_identity->real_name); ?></td>
		   </tr>
		   <tr>
		     <td>身份证号码：</td>
			 <td><?php echo LYCommon::half_replace($user_identity->identity_num); ?></td>
		   </tr>
		   <tr>
		     <td>身份证正面：</td>
			 <td><a target="_blank" href="<?php echo SITE_UPLOAD.'identity/'.$user_identity->identity_positive; ?>" >点击查看</a></td>
		   </tr>
		   <tr>
		     <td>身份证反面：</td>
			 <td><a target="_blank" href="<?php echo SITE_UPLOAD.'identity/'.$user_identity->identity_negative; ?>" >点击查看</a></td>
		   </tr>
		</table></form>
       	<?php } ?>
    </body>
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