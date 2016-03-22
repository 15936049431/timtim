<?php 
	$this->page_title = "安全中心"; 
?>	
	            <div class="user_con fr">
	            	<div class="user_safety clear">
	            		<dl class="fl">
	            			<dd class="clear">
	            				<div class="user_avatar">
	            					<a href="javascript:;" style="cursor:pointer;" onclick="uploaduserpic();">
								       <?php if(!empty($user_info->user_pic)){ ?>
							               <img style="width:100px;height:100px;" src="<?php echo SITE_UPLOAD.'userpic/'.$user_info->user_pic; ?>"/>
							           <?php }else{ ?>
							               <img src="<?php echo UIMG_URL; ?>default_user_img.jpg" style="width:100px;height:100px;" class="fl" />
							           <?php } ?>
							         </a>
	            				</div>
	            			</dd>
	            			<dt><a href="#">修改头像</a></dt>
	            		</dl>
                        <ul class="user_safety_info fl">
                            <li>姓名：<?php echo ($user_info->is_realname_check==1) ? $user_info->real_name : "请进行实名认证" ; ?></li>
                            <li>账号名：<?php echo $user_info->user_name; ?></li>
                            <li>安全等级：
                                <div class="user_progress_s">
                                    <em style="width:<?php echo $user_safe; ?>%"></em>
                                </div>
                            </li>
                            <li class="clear">
                                <a href="<?php echo Yii::app()->controller->createUrl("usercenter/home"); ?>" class="btn_a">返回用户中心</a>
<!--                                 <a href="#" class="btn_b">保护隐私安全</a> -->
                            </li>
                        </ul>
	            	</div>
                    <div class="user_safety_list mt20">
                        <h1>安全中心</h1>
                        <ul>
                            <li <?php echo ($user_info->is_realname_check==1) ? "class='ok'" : "" ;?>>
                            	<span>实名认证</span>
                            	<?php if($user_info->is_realname_check==1){ ?>
                                	<em><?php echo LYCommon::half_replace($user_info->real_name); ?></em>
                                	<a href="#">-</a>
                                <?php }else{ ?>
                                	<em>未认证</em>
                                	<a href="javascript:;" onclick="openWindow('实名认证','400','250','<?php echo Yii::app()->controller->createUrl('safecenter/realname');?>');">认证</a>
                                <?php } ?>
                            </li>
                            <li <?php echo ($user_info->is_phone_check==1) ? "class='ok'" : "" ;?>>
                                <span>绑定手机</span>
                                <?php if($user_info->is_phone_check==1){ ?>
                                	<em><?php echo LYCommon::half_replace($user_info->user_phone); ?></em>
                               	 	<a href="javascript:;" onclick="openWindow('修改手机','400','300','<?php echo Yii::app()->controller->createUrl('safecenter/change_phone_1');?>');">修改</a>
                                <?php }else{ ?>
                                	<em>未认证</em>
                               	 	<a href="javascript:;" onclick="openWindow('绑定手机','400','300','<?php echo Yii::app()->controller->createUrl('safecenter/change_phone_2');?>');">绑定</a>
                                <?php } ?>
                            </li>
                            <li <?php echo ($user_info->pay_pass!=$user_info->login_pass) ? "class='ok'" : "" ;?>>
                                <span>交易密码</span>
                                <?php if($user_info->pay_pass!=$user_info->login_pass){ ?>
                                	<em>已设置</em>
                               	 	<a href="javascript:;" onclick="openWindow('修改交易密码','400','330','<?php echo Yii::app()->controller->createUrl('safecenter/change_pay_pass');?>');">修改</a>
                                <?php }else{ ?>
                                	<em>未设置</em>
                               	 	<a href="javascript:;" onclick="openWindow('修改交易密码','400','330','<?php echo Yii::app()->controller->createUrl('safecenter/change_pay_pass');?>');">设置</a>
                                <?php } ?>
                            </li>
                            <li <?php echo ($user_info->is_email_check==1) ? "class='ok'" : "" ;?>>
                                <span>邮箱验证</span>
                                <?php if($user_info->is_email_check==1){ ?>
                                	<em><?php echo LYCommon::half_replace($user_info->user_email); ?></em>
                               	 	<a href="javascript:;" onclick="openWindow('修改邮箱','400','300','<?php echo Yii::app()->controller->createUrl('safecenter/change_email_1');?>');">修改</a>
                                <?php }else{ ?>
                                	<em>未认证</em>
                               	 	<a href="javascript:;" onclick="openWindow('绑定邮箱','400','300','<?php echo Yii::app()->controller->createUrl('safecenter/change_email_2');?>');">绑定</a>
                                <?php } ?>
                            </li>
                            <li <?php echo ($user_info->login_pass!="") ? "class='ok'" : "" ;?>>
                                <span>登录密码</span>
                                <?php if($user_info->login_pass!=""){ ?>
                                	<em>已设置</em>
                               	 	<a href="javascript:;" onclick="openWindow('修改登陆密码','400','300','<?php echo Yii::app()->controller->createUrl('safecenter/change_login_pass');?>');">修改</a>
                                <?php }else{ ?>
                                	<em>未设置</em>
                               	 	<a href="javascript:;" onclick="openWindow('修改登陆密码','400','300','<?php echo Yii::app()->controller->createUrl('safecenter/change_login_pass');?>');">绑定</a>
                                <?php } ?>
                            </li>
                        </ul>
                        <p class="tips">温馨提示：我们将严格对用户的所有资料进行保密，如有疑问请联系网站客服</p>
                    </div>
	            </div>
<script>
	function uploaduserpic(){
         <?php if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0") || strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) { ?>
    	  $.layer({
            type: 2,
            fix: true,
            offset: ['40px' , ''],
            title: ['上传头像','font-size:14px;color:#666;border-bottom:1px #005178 solid;background:none; font-weight:bold;'],
            shadeClose: true,
            border:[0],
            iframe: {
                src: '<?php echo Yii::app()->controller->createUrl("usercenter/uploaduserpic");?>',
                scrolling:'no'
            },
            area : ['700px' , '535px'],
            closeBtn : [0 , true],
            shade : [0.5 , '#000' , true]
          });
         <?php }else{ ?>
         
          layer.open({
    		type: 2,
    		title: '上传头像',
    		shadeClose: true,
    		shade: 0.5,
    		area: ['700px', '550px'],
    		content: ['<?php echo Yii::app()->controller->createUrl("usercenter/uploaduserpic");?>','no'],
   		});
         <?php } ?>
     }
</script>