<?php
    $this -> js = array('laydate/laydate');
    $this -> page_title = '系统消息';
?>
				<div class="user_money_main">
                        <dl class="user_money_tab clear">
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/invite"); ?>">邀请好友</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("userproject/autoorder"); ?>">理财助手</a></dd>
                            <dd class="sel"><a href="<?php echo Yii::app()->controller->createUrl("usercenter/message"); ?>">系统消息</a></dd>
                        </dl>
                        <table class="user_recharge_record ba">
                            <tr>
                                <th>状态</th>
								<th>内容</th>
								<th>来自</th>
								<th>时间</th>
                            </tr>
                            <?php foreach($my_message_list as $k=>$v){ ?>
							<tr>
                                <td id="isread_<?php echo $v->m_id; ?>"><?php echo LYCommon::findcat('message_status',$v['is_view']); ?></td>
                                <td style="cursor: pointer;" title="<?php echo $v['m_con']; ?>" onclick="show('<?php echo $v->m_id; ?>','<?php echo str_replace("'","",$v['m_con']); ?>')"><?php echo LYCommon::truncate_longstr($v['m_con'],28); ?></td>
                                <td>系统消息</td>
                                <td><?php echo LYCommon::subtime($v->add_time,3); ?></td>
							</tr>
							<?php } ?>
                            <tr>
                                <td colspan="4">
                                    <ul class="pager">
                                        <?php echo $page_list; ?>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
<script type="text/javascript">
    function show(id,text){
        $.post("<?php echo Yii::app()->controller->createUrl('iread'); ?>?id="+id,{
            
        },function(data){
            if(data == '1'){
                $("#isread_"+id).text('已读');
            }
        });
		
        <?php if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0") || strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) { ?>
		layer.alert(text,1);
		<?php }else{ ?>
		layer.alert(text,{
                    title:'系统通知'
                });
		<?php } ?>
    }
</script>