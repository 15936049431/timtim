<?php 
	$this -> css = array("erji");
	$this->url =Yii::app()->controller->createUrl("menu/ihave");
?>
<section class="aqzx_con">
  <ul class="c_ul1">
       <a href="<?php echo ($user_info->is_realname_check==1) ? Yii::app()->controller->createUrl("") : Yii::app()->controller->createUrl("safecenter/realname") ; ?>"><li>
	      <div class="ul_left">
		     <img src="<?php echo WAP_IMG_URL; ?><?php echo ($user_info->is_realname_check==1) ? "aqzx_03" : "aqzx_03_1" ; ?>.png"> 实名认证
		  </div>
		  <div class="ul_right">
		    <?php echo ($user_info->is_realname_check==1) ?$user_info->real_name:"" ?> <img src="<?php echo WAP_IMG_URL; ?>aqzx_06.png">
		  </div>
	   </li><hr></a>
	    <a href="<?php echo ($user_info->is_phone_check==1) ? Yii::app()->controller->createUrl("safecenter/changephone") : Yii::app()->controller->createUrl("safecenter/setphone"); ?>"><li>
	      <div class="ul_left">
		     <img src="<?php echo WAP_IMG_URL; ?><?php echo ($user_info->is_phone_check==1) ? "aqzx_10" : "aqzx_10_1" ; ?>.png"> 绑定手机
		  </div>
		  <div class="ul_right">
		     <?php echo !empty($user_info->user_phone) ? $user_info->user_phone : ''; ?> <img src="<?php echo WAP_IMG_URL; ?>aqzx_06.png">
		  </div>
	   </li></a>
  </ul>
    <ul class="c_ul1">
       <a href="<?php echo Yii::app()->controller->createUrl("safecenter/password"); ?>"><li>
	      <div class="ul_left">
		     <img src="<?php echo WAP_IMG_URL; ?><?php echo ($user_info->login_pass!="") ? "aqzx_12" : "aqzx_12_1" ; ?>.png"> 修改登录密码
		  </div>
		  <div class="ul_right">
		     <img src="<?php echo WAP_IMG_URL; ?>aqzx_06.png">
		  </div>
	   </li><hr></a>
	    <a href="<?php echo Yii::app()->controller->createUrl("safecenter/changepaypass"); ?>"><li>
	      <div class="ul_left">
		     <img src="<?php echo WAP_IMG_URL; ?><?php echo ($user_info->pay_pass!="" && $user_info->login_pass!=$user_info->pay_pass) ? "aqzx_14" : "aqzx_14_1" ; ?>.png"> 修改交易密码
		  </div>
		  <div class="ul_right">
		     <img src="<?php echo WAP_IMG_URL; ?>aqzx_06.png">
		  </div>
	   </li></a>
  </ul>
      <ul class="c_ul3">
       <a href="<?php echo Yii::app()->controller->createUrl("usercenter/banklist"); ?>?l=1"><li>
	      <div class="ul_left">
		     <img src="<?php echo WAP_IMG_URL; ?><?php echo !empty($user_bank) ? "aqzx_16" : "aqzx_16_1" ; ?>.png"> 我的银行卡
		  </div>
		  <div class="ul_right">
		     <img src="<?php echo WAP_IMG_URL; ?>aqzx_06.png">
		  </div>
	   </li>
  </ul>
</section>