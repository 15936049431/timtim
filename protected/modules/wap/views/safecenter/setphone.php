<?php 
	$this->css = array("chongzhi");
	$this->url =Yii::app()->controller->createUrl("safecenter/home");
?>
<section class="box">
  <?php $form = $this->beginWidget('CActiveForm', array("id" => "chongzhi")); ?>
  <p class="form-head-p" style="padding-left:5%;">设置手机：<h3 id="xiugai-h3">￥<span id="xiugai-h3-span"></span></h3></p>
  <p class="form-head-p"><img src="<?php echo WAP_IMG_URL; ?>icon4.png">
  	手机号码：<?php echo $form->textField($user_model,"user_phone",array("placeholder"=>"请输入您的手机号码")); ?>
  </p>
  <p class="form-head-p"><img src="<?php echo WAP_IMG_URL; ?>icon5.png">
  	验证码：<?php echo $form->textField($user_model,"code",array("style"=>"width:30%","placeholder"=>"请输入您的验证码")); ?>
  		<input class="chongzhi5" type="button" id="sendmsg" style="width:30%;color:white;border-radius:0px;" value="发送验证码">
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

		<script>
			$("#sendmsg").click(function(){
				var phone =$("#Userprofile_user_phone").val();
				$.post("<?php echo Yii::app()->controller->createUrl('safecenter/sendsms'); ?>?type=safecenter_change_phone_2&phone="+phone,{},function(data){
		            var obj = eval("("+data+")");
                            if(obj.status == 1){
                                window.sec = 60;
                                djs('sendmsg');
                            }
		            msg(obj.msg,"");
		        });
			});
                        
                        function djs(btn){
                            $("#"+btn).attr('disable','true');
                            if(window.sec>=0){
                                $("#"+btn).val('倒计时'+window.sec+'秒');
                                window.sec --;
                                setTimeout("djs('"+btn+"');",1000);
                            }else{
                                $("#"+btn).removeAttr('disable');
                                $("#"+btn).val('获取验证码');
                                window.sec=60;
                            }

                        }
		</script>