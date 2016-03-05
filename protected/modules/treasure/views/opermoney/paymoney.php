<?php
    $this->page_title = '手动充值('.$assets_info->user->user_name.')';
    $this->page_desc = '人工手动充值';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 充值信息</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php $form = $this->beginWidget('CActiveForm',array(
                    'htmlOptions'=>array(
                        'class'=>'form-horizontal',
                    ),
                )); ?>
<!--                输出错误信息  开始-->
                <?php if(!empty($error_list)){ ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <p>请修改以下错误</p>
                    <ul>
                        <?php foreach($error_list as $k => $v){ ?>
                            <?php echo $v; ?>
                        <?php } ?>
                    </ul>
                    
                </div>
                <?php } ?>
<!--                输出错误信息  结束-->
                        <div class="control-group">
                            <label class="control-label required">添加类型 <span class="required">*</span></label>
                            <div class="controls">
                                <select name="Opermoney[b_itemtype]">
                                	<option value="assets_continue_order" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_continue_order'?'selected':'' ?>>续投奖励</option>
                                	<option value="assets_guard" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_guard'?'selected':'' ?>>站岗息</option>
                                	<option value="assets_new_person" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_new_person'?'selected':'' ?>>新人奖励</option>
                                	<option value="assets_first_order" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_first_order'?'selected':'' ?>>首投奖励</option>
                                	<option value="assets_large_order" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_large_order'?'selected':'' ?>>大额奖励</option>
                                	<option value="assets_ending_order" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_ending_order'?'selected':'' ?>>满标奖励</option>
                                	<option value="assets_invite_user" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_invite_user'?'selected':'' ?>>邀请奖励</option>
                                	<option value="assets_thousand" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_thousand'?'selected':'' ?>>千一加息</option>
                                	<option value="assets_interest_diff" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_interest_diff'?'selected':'' ?>>利息补差</option>
                                	<option value="assets_our_reward" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_our_reward'?'selected':'' ?>>众筹累计奖励</option>
                                	<option value="assets_shop_day" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_shop_day'?'selected':'' ?>>商城日结利息</option>
                                    <option value="assets_back_recharge" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_back_recharge'?'selected':'' ?>>后台增加资金</option>
                                    <option value="reward_assets_work_add" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='reward_assets_work_add'?'selected':'' ?>>后台发放红包</option>
									<option value="assets_zhuxing_award" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_zhuxing_award'?'selected':'' ?>>助兴奖</option>
									<option value="assets_tucao_award" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_tucao_award'?'selected':'' ?>>吐槽奖</option>
									<option value="assets_adopt_award" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_adopt_award'?'selected':'' ?>>采纳奖</option>
									<option value="assets_add_interest" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_add_interest'?'selected':'' ?>>加息奖</option>
									<option value="assets_recharge_line" <?php echo !empty($_POST['Opermoney']['b_itemtype'])&&$_POST['Opermoney']['b_itemtype']=='assets_recharge_line'?'selected':'' ?>>充值奖励</option>
								</select>
                            </div>
                        </div>
                        <br/>
                        <div class="control-group <?php echo array_key_exists('paymoney', $error_list)?'error':'' ?>">
                            <label class="control-label required" for="Myself_oldpassword">充值金额 <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="Opermoney[paymoney]" placeholder="请输入充值金额" value="<?php echo $opermoney_post['paymoney']; ?>">
                            </div>
                        </div>
                    
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="提交">
                        <button type="reset" class="btn">重置</button>
                    </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
                </div>