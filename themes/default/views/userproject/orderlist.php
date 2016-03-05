<?php
    $this -> js = array('laydate/laydate');
    $this -> page_title = '投资明细';
?>
				<div class="user_money_main">
                        <dl class="user_money_tab clear">
                            <dd class="sel"><a href="<?php echo Yii::app()->controller->createUrl("userproject/orderlist"); ?>">投资明细</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("userproject/orderon"); ?>">正在投资</a></dd>
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
								<th>投标总额</th>
								<th>应收总额</th>
								<th>已收总额</th>
								<th>应收利息</th>
								<th>已收利息</th>
								<th>添加时间</th>
                            </tr>
                            <?php foreach($list as $k=>$v){ ?>
							 <tr>
                                <td><?php echo LYCommon::half_replace_utf8($v->project->user->user_name); ?></td>
								<td><a target="_blank" href="<?php echo Yii::app()->controller->createUrl('project/tender',array('id'=>$v->p_project_id)); ?>"><?php echo LYCommon::truncate_longstr($v->project->p_name,8); ?></a></td>
								<td><a target="_blank" href="<?php echo Yii::app()->controller->createUrl('agreement/invest',array('id'=>$v->p_project_id)); ?>">协议书</a></td>
								<td>￥<?php echo $v->p_money; ?></td>
								<td>￥<?php echo $v->p_repayaccount; ?></td>
								<td>￥<?php echo $v->p_repayyesaccount; ?></td>
								<td>￥<?php echo $v->p_interest; ?></td>
								<td>￥<?php echo $v->p_yesinterest; ?></td>
								<td><?php echo LYCommon::subtime($v->p_addtime,3); ?></td>
							</tr>
							<?php } ?>
                            <tr>
                                <td colspan="9">
                                    <ul class="pager">
                                        <?php echo $page_list; ?>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>