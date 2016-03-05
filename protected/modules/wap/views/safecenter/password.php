<?php 
	$this->css = array("chongzhi");
	$this->url =Yii::app()->controller->createUrl("safecenter/home");
?>
<section class="box">
  <?php $form = $this->beginWidget('CActiveForm', array("id" => "chongzhi")); ?>
  <p class="form-head-p" style="padding-left:5%;">修改登陆密码：<h3 id="xiugai-h3">￥<span id="xiugai-h3-span"></span></h3></p>
  <p class="form-head-p"><img src="<?php echo WAP_IMG_URL; ?>icon7.png">
  	原登录密码：<?php echo $form->passwordField($user_model,"login_pass",array("class"=>"form-control","placeholder"=>"原登录密码")); ?>
  </p>
  <p class="form-head-p"><img src="<?php echo WAP_IMG_URL; ?>icon7.png">
  	新登录密码：<?php echo $form->passwordField($user_model,"new_pass",array("class"=>"form-control","placeholder"=>"新登录密码")); ?>
  </p>
  <p class="form-head-p"><img src="<?php echo WAP_IMG_URL; ?>icon7.png">
  	确认新密码：<?php echo $form->passwordField($user_model,"re_new_pass",array("class"=>"form-control","placeholder"=>"请确认新登录密码")); ?>
  </p>

  <h3><input class="chongzhi5" type="submit" value="提交"></h3>
  <?php $this->endWidget(); ?>
</section>
<?php if(!empty($result)){ ?>
                    <?php if(!empty($result['msg'])){ ?>
                    <script>msg('<?php echo $result['msg']; ?>','');</script>
                    <?php } ?>

                    <?php if(!empty($result['jump_url'])){ ?>
                        <script type="text/javascript">
                            setTimeout(function(){
                                location.href = '<?php echo $result['jump_url']; ?>';
                            },500);
                        </script>
                    <?php } ?>
		<?php } ?>