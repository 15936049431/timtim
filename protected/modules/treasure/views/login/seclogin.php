<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo urldecode(mb_convert_encoding(Yii::app()->params['siteName'],'gbk','utf-8')); ?>后台管理系统</title>
<link href="<?php echo BACK_URL; ?>login/css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BACK_URL; ?>login/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo BACK_URL; ?>login/js/cloud.js" type="text/javascript"></script>
<script language="javascript">
$(function(){
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
	$(window).resize(function(){  
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
    })  
});  
</script> 
</head>

<body style="background-color:#1c77ac; background-image:url(images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">



    <div id="mainBody">
      <div id="cloud1" class="cloud"></div>
      <div id="cloud2" class="cloud"></div>
    </div>  


<div class="logintop">    
    <span>欢迎登录<?php echo urldecode(mb_convert_encoding(Yii::app()->params['siteName'],'gbk','utf-8')); ?>管理平台</span>    
    <ul>
    <li><a href="<?php echo Yii::app()->homeUrl; ?>">平台首页</a></li>
    <li><a target="_blank" href="http://www.zhongjieyi.cn">技术支持</a></li>
    </ul>    
    </div>
    
    <div class="loginbody">
    
    <span class="systemlogo"></span> 
       
  <div class="loginbox">
    <?php $form = $this->beginWidget('CActiveForm',array(
        'htmlOptions'=>array('name'=>'form1'),
    )); ?>
    <ul>
        <li><label><input type="radio" name="SecLoginForm[validate_type]" value="1" <?php echo (empty($_POST['SecLoginForm']['validate_type'])||(!empty($_POST['SecLoginForm']['validate_type'])&&$_POST['SecLoginForm']['validate_type']==1))?'checked':'' ?> /> 发送验证码到<?php echo substr(Yii::app()->SESSION['manager_tel'],'0','3').'*****'.substr(Yii::app()->SESSION['manager_tel'],-3); ?></label><input name="" type="button" onclick="getcode(this,30);" style="padding: 5px;" class="phonebtu" value="发送验证码"></li>
        <?php if(Yii::app()->params['site_googleval'] == 1 && $manager_info->google_status == 1){ ?>
        <li><label><input type="radio" name="SecLoginForm[validate_type]" value="2" <?php echo (!empty($_POST['SecLoginForm']['validate_type'])&&$_POST['SecLoginForm']['validate_type']==2)?'checked':'' ?> style="margin-top:2px;"/> 使用谷歌验证</label></li>
        <?php } ?>
<!--        <li><input type="radio" name="LoginForm[validate_type]" value="2" <?php echo (!empty($_POST['LoginForm']['validate_type'])&&$_POST['LoginForm']['validate_type']==2)?'checked':'' ?> style="margin-top:2px;"/>使用谷歌验证</li>-->
    <div class="errormessage"></div>
    <li><input type="text" name="SecLoginForm[seccode]" class="safecode" />请输入验证码后登陆</li>
    <div class="errormessage"><?php echo $error ?></div>
    <li style="hight:auto;"><input name="" type="submit" onclick="this.disabled=true;this.style.backgroundColor='#ccc';document.form1.submit();this.value='登录中...'" class="loginbtn" value="登录" /></li>
    </ul>
    <?php $this->endWidget(); ?>
    
    </div>
    
    </div>
    
    
    
    <div class="loginbm">版权所有  2013 - 2016  <a target="_blank" href="http://www.zhongjieyi.cn">www.zhongjieyi.cn</a>  服务热线：027-8738 4859</div>
    
    <script language="javascript">
        function getcode(obj,second){
            $.getJSON("<?php echo Yii::app()->controller->createUrl('login/getseccode') ?>", function(result){
            if(result){
                alert(result)
                countDown(obj,second);
            }else{
                alert('发送失败');
            }
        })
        }
    </script>
    
<script type="text/javascript">
    function countDown(obj,second){
            //这里可以执行ajax;
        // 如果秒数还是大于0，则表示倒计时还没结束
        if(second>=0){
              // 获取默认按钮上的文字
              if(typeof buttonDefaultValue === 'undefined' ){
                buttonDefaultValue =  obj.defaultValue;
            }
            // 按钮置为不可点击状态
            obj.disabled = true; 
                    //更换背景图片
                    obj.className = "phonebtu2";
            // 按钮里的内容呈现倒计时状态
            obj.value = buttonDefaultValue+'('+second+')';
            // 时间减一
            second--;
            // 一秒后重复执行
            setTimeout(function(){countDown(obj,second);},1000);
        // 否则，按钮重置为初始状态
        }else{
                    //更换背景图片
                    obj.className = "phonebtu";
            // 按钮置未可点击状态
            obj.disabled = false;   
            // 按钮里的内容恢复初始状态
            obj.value = buttonDefaultValue;

        }   

    }
</script>
    
</body>
    

</html>
