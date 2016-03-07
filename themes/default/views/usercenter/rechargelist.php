<?php
    $this -> js = array('laydate/laydate');
    $this -> page_title = '充值记录';
?>
				<div class="user_money_main">
                        <dl class="user_money_tab clear">
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/bill"); ?>">资金明细</a></dd>
                            <dd class="sel"><a href="<?php echo Yii::app()->controller->createUrl("usercenter/rechargelist"); ?>">充值记录</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/cashlist"); ?>">提现记录</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/awardlist"); ?>">红包记录</a></dd>
                        </dl>
                        <?php $form = $this->beginWidget('CActiveForm',array(
							'method'=>'GET',
							'action'=>Yii::app()->controller->createUrl('usercenter/rechargelist'),
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
						<p style="display:inline-block;width:750px;font-size:16px;padding-left:20px;">成功充值笔数：<?php echo $money['recharge_num']; ?>笔&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       		线下充值：<?php echo $money['recharge_overline_money']; ?>元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;线上充值：<?php echo $money['recharge_online_money']; ?>元</p>
                        <table class="user_recharge_record ba">
                            <tr>
                                <th>充值时间</th>
								<th>充值金额(元)</th>
								<th>充值通道</th>
								<th>充值状态</th>
                            </tr>
                            <?php foreach($recharge_list as $k=>$v){ ?>
							 <tr>
							   <td><?php echo LYCommon::subtime($v->r_addtime,2); ?></td>
							   <td><?php echo $v->r_money; ?></td>
							   <td><?php echo LYCommon::GetItem($v->r_recharge_type,($v->r_type==1)?'assets_recharge_type':'assets_oevrrecharge_type'); ?></td>
							   <td><?php if($v->r_status==0){echo "申请";}elseif($v->r_status==1){echo "成功";}else{echo "失败";}; ?></td>
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