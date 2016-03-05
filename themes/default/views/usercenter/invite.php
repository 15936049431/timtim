<?php
    $this -> page_title = '邀请好友';
    $this -> js = array("ZeroClipboard");
?>
				<div class="user_money_main">
                        <dl class="user_money_tab clear">
                            <dd class="sel"><a href="#">邀请好友</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("userproject/autoorder"); ?>">理财助手</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/message"); ?>">系统消息</a></dd>
                        </dl>
                       <form class="user_search">
                       		<span style="width:20px;"></span>
                            <input type="text" id="invite_url" value="<?php echo $invite_url; ?>" style="width:350px;" />     
                            <input type="button" class="btn" id="copyurl" value="复制链接"  style="width:150px;" />               
                        </form>
                        <table class="user_recharge_record ba">
                            <tr>
                                <th>邀请时间 </th>
								<th>用户名</th>
								<th>手机号码</th>
								<th>状态</th>
                            </tr>
                            <?php foreach($invite_list as $k=>$v){ ?>
							 <tr>
                                <td><?php echo LYCommon::subtime($v['register_time'],3); ?></td>
								<td><?php echo LYCommon::half_replace($v['user_name']); ?></td>
								<td><?php echo empty($v['user_phone']) ? "" : LYCommon::half_replace($v['user_phone']); ?></td>
								<td><?php echo $v['status']; ?></td>
							</tr>
							<?php } ?>
                        </table>
                    </div>
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