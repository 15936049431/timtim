<?php
    $this -> js = array('laydate/laydate');
    $this -> page_title = '红包记录';
?>
				<div class="user_money_main">
                        <dl class="user_money_tab clear">
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/bill"); ?>">资金明细</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/rechargelist"); ?>">充值记录</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/cashlist"); ?>">提现记录</a></dd>
                            <dd class="sel"><a href="<?php echo Yii::app()->controller->createUrl("usercenter/awardlist"); ?>">红包记录</a></dd>
                        </dl>
                        <?php $form = $this->beginWidget('CActiveForm',array(
							'method'=>'GET',
							'action'=>Yii::app()->controller->createUrl('usercenter/awardlist'),
							'htmlOptions'=>array(
								'name'=>'form_search',
								'class'=>'user_search',
							),
						)); ?>
<!--                        <span>查询类型：</span>
                            <select name="" id=""></select>-->
                            <span>时间：</span>
                            <input type="text" id="start_time" name="get_time" value="<?php echo isset($_REQUEST['get_time'])?$_REQUEST['get_time']:""; ?>" onfocus="laydate();" />
                            <i>至</i>
                            <input type="text" onfocus="laydate();" id="end_time"  name="end_time" value="<?php echo isset($_REQUEST['end_time'])?$_REQUEST['end_time']:""; ?>"/>
                            <i>状态:</i><select name="status"><option value="0" <?php echo isset($_GET['status']) && $_GET['status']==0 ? "selected" : ""; ?>>未使用</option>
                            <option value="1" <?php echo isset($_GET['status']) && $_GET['status']==1 ? "selected" : ""; ?>>已使用</option>
                            <option value="2" <?php echo isset($_GET['status']) && $_GET['status']==2 ? "selected" : ""; ?>>已过期</option></select>
                            <input type="submit" class="btn" value="查询" />
                        <?php $this->endWidget(); ?>
                        <table class="user_recharge_record ba">
                            <tr>
                                <th>红包金额</th>
                                <th>有效时间</th>
								<th>获取时间</th>
								<th>过期时间</th>
								<th>投资区间</th>
								<th>期限区间</th>
								<th>状态</th>
								<th>红包来源</th>
                            </tr>
                            <?php foreach($list as $k=>$v){ ?>
                            <tr>
                                <td>¥<?php echo $v->money ; ?></td>
                                <td><?php echo $v->atype->use_time; ?>天</td>
                                <td><?php echo LYCommon::subtime($v->get_time,3); ?></td>
                                <td><?php echo LYCommon::subtime($v->end_time,3); ?></td>
                                <td>¥<?php echo $v->low_account.'-'.$v->most_account; ?></td>
                                <td><?php echo $v->min_limit.'-'.$v->max_limit; ?>个月</td>
                                <td><?php echo LYCommon::findcat('award_type',$v->status); ?></td>
                                <td><?php echo $v->award->award_name; ?></td>
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