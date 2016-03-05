<?php
    $this -> page_title = "邀请好友";
    $this -> js = array("jquery.min");
?>
<!--邀请页--> 
   <div id="usermain"class="fr">
<!--  我的资金-邀请页-邀请-->

 <div id="yoaqing">
      <div id="zj_gaikuang3"><h2>邀请链接 <span>微信分享</span></h2>
        <p>邀请好友注册奖励邀请人200积分，被邀请人注册100积分&nbsp;<font onclick="window.location.href='<?php echo Yii::app()->controller->createUrl("article/14366224359518284"); ?>'" style="cursor:pointer;color:red;">(查看积分规则)</font></p>
         <div class="box">
         <p>宛平财富预期最高年化收益18%，保本保息，先行赔</p>
         <p title="<?php echo $invite_url; ?>">付，我已经赚到啦，你也一起吧！ <?php echo LYCommon::truncate_longstr($invite_url,5); ?></p>
	         <input type="hidden" value="<?php echo $invite_url; ?>" id="invite_url" />
         </div>
         <a href="javascript:;" id="copyurl">点击复制</a>
         <img src="<?php echo IMG_URL; ?>weixin.gif">          
      </div>
<!--  我的资金-资金概况-邀请记录-->
    <div id="zj_gaikuang4">
      <dt>
       <dl><span> 邀请时间 </span> <span>&nbsp;</span>     <span>手机号码</span> <span>&nbsp;</span> <span>状态</span></dl>
       <?php foreach($invite_list as $k=>$v){ ?>
	       <dd><span><?php echo LYCommon::subtime($v['register_time'],3); ?></span> <span>&nbsp;</span> <span><?php echo LYCommon::half_replace($v['user_name']); ?></span> <span>&nbsp;</span> <span><?php echo $v['status']; ?></span></dd>
       <?php } ?>
      </dt>
   </div> 
 </div>
</div>
<!--  我的资金-邀请页-邀请END-->
</div>
			 <script type="text/javascript" src="<?php echo JS_URL; ?>ZeroClipboard.js"></script>
			<script type="text/javascript">
			$(function () {
		          var clip = null;
		          clip = new ZeroClipboard.Client();
		          clip.setHandCursor(true);
		          clip.addEventListener('mouseOver', function (client) {
		               clip.setText($('#invite_url').val());
		          });
		          clip.addEventListener('complete', function (client, text) {
		        	  pointererror('地址已成功复制到剪切板',2);
		          });
		          clip.glue('copyurl');
		     });
            </script>
