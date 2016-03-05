<?php 
	$this->css = array("chongzhi");
	$this->url =Yii::app()->controller->createUrl("safecenter/home");
?>
<section class="box">
    <form method="post" action="" id="chongzhi">
  <p class="form-head-p" style="padding-left:5%;">实名认证：<h3 id="xiugai-h3"><span id="xiugai-h3-span"></span></h3></p>
  <p class="form-head-p"><img src="<?php echo WAP_IMG_URL; ?>icon7.png">
  	真实姓名：<input class="form-control" placeholder="请输入真实姓名" name="Identity[real_name]" id="Identity_real_name" type="text" maxlength="24" />
  </p>
  <p class="form-head-p"><img src="<?php echo WAP_IMG_URL; ?>icon7.png">
  	身份证号：<input class="form-control" placeholder="请输入身份证号码" onkeyup="value = value.replace(/[^0-9xX]/g,&quot;&quot;)" name="Identity[identity_num]" id="Identity_identity_num" type="text" maxlength="18" />
  </p>
  <input type="hidden" name="vid" value="<?php echo Yii::app()->user->id; ?>" />
  <h3><input class="chongzhi5" type="submit" value="提交"></h3>
    </form>
</section>
                    <?php if(!empty($message)){ ?>
                    <script>msg('<?php echo $message; ?>','');</script>
                    <?php } ?>
