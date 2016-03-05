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
	    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'borrowaply-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array(
                'name' => 'borrowaply','class'=>'user_binding'
            ),
        ));
        ?>
            <table>
                <tr>
                    <td width="100">借款金额</td>
                    <td width="170"><input type="text" class="long" name="ProjectApply[p_money]" id="ProjectApply_p_money" /></td>
                </tr>
                <tr>
                    <td>联系号码</td>
                    <td><input type="text" class="long" name="ProjectApply[p_phone]" id="ProjectApply_p_phone" /></td>
                </tr>
                <tr>
                    <td>联系人</td>
                    <td><input type="text" class="long" name="ProjectApply[p_realname]" id="ProjectApply_p_realname" /></td>
                </tr>
                <tr>
                    <td>借款期限</td>
                    <td><?php echo $form->dropDownList($projectapply_model, 'p_time_limit', $project_month_type_arr, array()); ?></td>
                </tr>
                <tr>
                    <td>所在地区</td>
                    <td><?php echo $form->dropDownList($projectapply_model, 'p_city', $area, array('style'=>'width:90px;')); ?>
                        <select style="width:95px;" name="ProjectApply[p_province]" id="ProjectApply_p_province"></select></td>
                </tr>
                <tr>
                    <td>验证码</td>
                    <td><?php echo $form->textField($projectapply_model, 'authcode', array('class' => 'tc_text1', 'style' => 'width:100px;', 'placeholder' => '请填写验证码')); ?>	
                        <?php $this->widget('CCaptcha', array('showRefreshButton' => false, 'clickableImage' => true, 'imageOptions' => array('alt' => '点击换图', 'title' => '看不清楚?请点击刷新验证码', 'style' => 'vertical-align:middle;cursor:pointer;'))); ?>	</td>
                </tr>
                <tr>
                    <td colspan="2" class="tc">
                        <input type="submit" class="btn" value="提交" />
                        <input type="reset" class="btn_g" onclick="parent.layer.closeAll();" value="取消" />
                    </td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
    </body>
<script>
        $(function () {
            $("#ProjectApply_p_city").change(function () {
                getProvince();
            });
            getProvince();
            function getProvince() {
                var city = $("#ProjectApply_p_city").val();
                $.post("<?php echo Yii::app()->controller->createUrl('GetCity') ?>", {'city': city},
                function (result) {
                    if (result != "error") {
                        $("#ProjectApply_p_province").html(result);
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