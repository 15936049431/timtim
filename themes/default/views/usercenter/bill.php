<?php
    $this -> js = array('laydate/laydate');
    $this -> page_title = '交易记录';
?>
				<div class="user_money_main">
                        <dl class="user_money_tab clear">
                            <dd class="sel"><a href="<?php echo Yii::app()->controller->createUrl("usercenter/bill"); ?>">资金明细</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/rechargelist"); ?>">充值记录</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/cashlist"); ?>">提现记录</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/ourlist"); ?>">众筹记录</a></dd>
                        </dl>
                        <?php $form = $this->beginWidget('CActiveForm',array(
							'method'=>'GET',
							'action'=>Yii::app()->controller->createUrl('usercenter/bill'),
							'htmlOptions'=>array(
								'name'=>'form_search',
								'class'=>'user_search',
							),
						)); ?>
<!--                        <span>查询类型：</span>
                            <select name="" id=""></select>-->
                            <span>时间：</span>
                            <input type="text" id="start_time" name="start_time" value="<?php echo isset($_REQUEST['start_time'])?$_REQUEST['start_time']:""; ?>" onfocus="laydate();" />
                            <i>至</i>
                            <input type="text" onfocus="laydate();" id="end_time"  name="end_time" value="<?php echo isset($_REQUEST['end_time'])?$_REQUEST['end_time']:""; ?>"/>
                            <input type="submit" class="btn" value="查询" />
                        <?php $this->endWidget(); ?>
                        <table class="user_recharge_record ba">
                            <tr>
                                <th>资金类型</th>
								<th>操作金额</th>
								<th>总额</th>
								<th>可用余额</th>
								<th>冻结金额</th>
								<th>待收金额</th>
								<th>添加时间</th>
                            </tr>
                            <?php foreach($list as $k=>$v){ ?>
                            <tr>
                                <td><?php echo LYCommon::GetItem($v->b_itemtype,'assets_type'); ?></td>
								<td>￥<?php echo $v->b_money; ?></td>
								<td><?php echo $v->u_total_money; ?></td>
								<td><?php echo $v->u_real_money; ?></td>
								<td><?php echo $v->u_frost_money; ?></td>
								<td><?php echo $v->u_wait_total_money; ?></td>
								<td><?php echo LYCommon::subtime($v->b_time,2); ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="7">
                                    <ul class="pager">
                                        <?php echo $page_list; ?>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>