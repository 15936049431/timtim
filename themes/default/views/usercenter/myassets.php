<?php 
	$this->page_title = "我的资金" ;
?>
				<div class="user_acount_main">
                        <dl class="user_money_tab clear">
                            <dd class="sel"><a href="javascript:;">资产统计</a></dd>
                        </dl>
                        <div class="user_acount_list clear">
                            <div class="fl">
                                <dl>
                                    <dt><span>资产总额</span><i><?php echo $user_assets->total_money; ?></i></dt>
                                    <dd><span>可用金额<em title="可用余额"></em></span><i>¥<?php echo $user_assets->real_money; ?></i></dd>
                                    <dd><span>冻结资金<em title="冻结资金"></em></span><i>¥<?php echo $user_assets->frost_money; ?></i></dd>
                                    <dd><span>待收金额<em title="待收金额"></em></span><i>¥<?php echo $user_assets->wait_total_money; ?></i></dd>
                                    <dd class="s"><span>已收利息</span><i>¥<?php echo $user_assets->have_interest; ?></i></dd>
                                    <dd class="s"><span>待收利息</span><i>¥<?php echo $user_assets->wait_interest; ?></i></dd>
									<dd><span>已收奖励<em title="已收奖励"></em></span><i>¥<?php echo empty($use_money['award_money']) ? 0 : $use_money['award_money']; ?></i></dd>
                                </dl>
                                <div class="earning_pay"><span>最近待收</span><?php echo empty($near_collection) ? "" : LYCommon::subtime($near_collection['p_repaytime'],3)."日"; ?>&nbsp;&nbsp;<i>
                                <?php echo empty($near_collection) ? "无" : "¥".$near_collection['p_repayaccount']; ?></i></div>
                            </div>
                            <div class="fr">
                                <dl>
                                    <dt><span>商城余额</span><i>¥<?php echo $user_assets->yuebao_money; ?></i></dt>
                                    <dd><span>商城收益<em></em></span><i>¥<?php echo $user_assets->yuebao_income; ?></i></dd>
                                    <dd class="s"><span>商城结息时间</span><i><?php echo empty($user_assets->yuebao_end_bearing_time) ? "无" : $user_assets->yuebao_end_bearing_time ; ?></i></dd>
                                    <dd class="s"><span>剩余返还金额</span><i>¥<?php echo empty($shop_user) ? "0" : $shop_user->wait_all; ?></i></dd>
                                    <dd class="s"><span>剩余返还次数</span><i><?php echo empty($shop_user) ? "0" : $shop_user->repay_wait_num; ?>次</i></dd>
                                    <dd class="s"><span>返还中的订单</span><i><?php echo empty($shop_user) ? "0" : $shop_user->repay_num; ?>笔</i></dd>
                                    <dd><span>购买总额<em title="购买总额"></em></span><i>¥<?php echo empty($shop_user) ? "0" : $shop_user->money_all; ?></i></dd>
                                </dl>
                                <div class="earning_pay"><span>最近返还</span><?php echo empty($near_monthly) ? "" : LYCommon::subtime($near_monthly['repay_time'],3)."日"; ?>&nbsp;&nbsp;<i>
                                <?php echo empty($near_monthly) ? "无" : "¥".$near_monthly['money']; ?></i></div>
                            </div>
                        </div>
                        <table class="user_acount_table">
                            <tr>
                                <th>我的账户：</th>
                                <th>我的费用：</th>
                                <th>历史记录：</th>
                                <th>投资统计：</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>充值总额:￥<?php echo $every_user->user_recharge; ?></td>
                                <td>充值费用:￥<?php echo empty($use_money['recharge_fee']) ? 0 : $use_money['recharge_fee']; ?></td>
                                <td>充值总数:<?php echo $every_user->user_recharge_num; ?>笔</td>
                                <td>投资总额:￥<?php echo $every_user->user_order; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>线上充值:￥<?php echo empty($use_money['online_money']) ? 0 : $use_money['online_money']; ?></td>
                                <td>提现费用:￥<?php echo empty($use_money['cash_fee']) ? 0 : $use_money['cash_fee']; ?></td>
                                <td>首次充值:<?php echo empty($every_user->user_first_recharge) ? "无" : LYCommon::subtime($every_user->user_first_recharge,3); ?></td>
                                <td>待收总额:￥<?php echo $user_assets->wait_total_money; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>线下充值:￥<?php echo empty($use_money['overline_money']) ? 0 : $use_money['overline_money']; ?></td>
                                <td>其他费用:￥0.00</td>
                                <td>提现总数:<?php echo $every_user->user_cash_num; ?>笔</td>
                                <td>待收利息:￥<?php echo $user_assets->wait_interest; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>提现总额:￥<?php echo $every_user->user_cash; ?></td>
                                <td></td>
                                <td>首次提现:<?php echo empty($every_user->user_first_cash) ? "无" : LYCommon::subtime($every_user->user_first_cash,3); ?></td>
                                <td>已收利息:￥<?php echo $user_assets->have_interest; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>投资总额:￥<?php echo $every_user->user_order; ?></td>
                                <td></td>
                                <td>投资总数:<?php echo $every_user->user_order_num; ?>笔</td>
                                <td>待收本金:￥<?php echo LYCommon::sprintf_diy($user_assets->wait_total_money - $user_assets->wait_interest); ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>首次投资:<?php echo empty($every_user->user_first_order) ? "无" : LYCommon::subtime($every_user->user_first_order,3); ?></td>
                                <td>最近应收金额:<?php echo empty($near_collection) ? "无" : "¥".$near_collection['p_repayaccount']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>最近还款日期:<?php echo empty($near_collection) ? "" : LYCommon::subtime($near_collection['p_repaytime'],3)."日"; ?></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </div>