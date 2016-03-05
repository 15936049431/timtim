<?php
    $this -> js = array('laydate/laydate');
    $this -> page_title = '正在投资';
?>
				<div class="user_money_main">
                        <dl class="user_money_tab clear">
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("userproject/orderlist"); ?>">投资明细</a></dd>
                            <dd class="sel"><a href="<?php echo Yii::app()->controller->createUrl("userproject/orderon"); ?>">正在投资</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("userproject/orderend"); ?>">已收明细</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("userproject/orderwait"); ?>">未收明细</a></dd>
                        </dl>
                       <form class="user_search">
                       <p style="display:inline-block;width:750px;font-size:16px;padding-left:20px;">投资本金合计：<?php echo $have_num['capital']; ?>元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       		回收本息合计：<?php echo $have_num['money']; ?>元</p>                       
                        </form>
                        <table class="user_recharge_record ba">
                            <tr>
                                <th>借款者</th>
								<th>借款标</th>
								<th>借款协议</th>
								<th>投标金额</th>
								<th>投标时间</th>
								<th>借款时间</th>
								<th>借款进度</th>
								<th>状态</th>
                            </tr>
                            <?php foreach($list as $k=>$v){ ?>
							<tr>
								<td><?php echo LYCommon::half_replace_utf8($v->project->user->user_name); ?></td>
								<td><a target="_blank" href="<?php echo Yii::app()->controller->createUrl('project/tender',array('id'=>$v->p_project_id)); ?>"><?php echo LYCommon::truncate_longstr($v->project->p_name,8); ?></a></td>
								<td><a target="_blank" href="<?php echo Yii::app()->controller->createUrl('agreement/invest',array('id'=>$v->p_project_id)); ?>">协议书</a></td>
								<td><?php echo $v->p_money; ?></td>
								<td><?php echo LYCommon::subtime($v->p_addtime,3); ?></td>
								<td><?php echo LYCommon::subtime($v->project->p_addtime,3); ?></td>
								<td><?php echo LYCommon::sprintf_diy($v->project->p_account_yes/$v->project->p_account*100); ?>%</td>
								<td><?php if($v->p_status==1){echo "全部通过";}else{echo "部分通过";} ?></td>
							</tr>
							<?php } ?>
                            <tr>
                                <td colspan="8">
                                    <ul class="pager">
                                        <?php echo $page_list; ?>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>