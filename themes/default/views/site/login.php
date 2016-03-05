<?php
    $this -> page_title = '登录';
    $this -> css = array("login");
?>
<div class="login_bg wrap">
            <div class="main">
                 <?php $form = $this -> beginWidget('CActiveForm',array(
			            'id'=>'login-form',
			            'enableAjaxValidation'=>true,
			            'enableClientValidation'=>true,
			            'clientOptions'=>array(
			                'validateOnSubmit'=>true,
			                'validateOnChange'=>true,
			            ),
                 		'htmlOptions'=>array("class"=>"login_form"),
			     )); 
			     ?>
                    <dl>
                        <dt>用户登录</dt>
                        <dd>
                            <em class="fontello">&#xe80d;</em>
                            <?php echo $form->textField($model,'username',array()); ?>
                            <span class="input_desc">帐号/手机号</span>
                        </dd>
                        <dd>
                            <em class="fontello">&#xe815;</em>
                            <?php echo $form->passwordField($model,'password',array()); ?>
                            <span class="input_desc">请输入登录密码</span>
                        </dd>
                        <dd>
                            <em class="fontello">&#xe815;</em>
                            <?php echo $form->textField($model,'authcode',array('class'=>'text','style'=>'width:90px;display:inline;',"onkeyup"=>"value = value.replace(/[^a-zA-Z]/g, '')")); ?>
                            <span class="input_desc">请输入验证码</span>
                            <?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'margin-left:10px;vertical-align:middle;cursor:pointer;'))); ?>
                            <p class="tr"><a href="<?php echo Yii::app()->controller->createUrl("site/forgetpass"); ?>">忘记登录密码？</a></p>
                        </dd>
                        <dd><input type="submit" class="btn" value="登录" /></dd>
                        <dd>
                            <p class="tl">还没有帐号？点击<a href="<?php echo Yii::app()->controller->createUrl("site/register"); ?>">立即注册</a></p>
                        </dd>
                    </dl>
                <?php $this -> endWidget(); ?>
            </div>
        </div>
<script>
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
    	$(this).siblings(".Validform_checktip").hide();
    })
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