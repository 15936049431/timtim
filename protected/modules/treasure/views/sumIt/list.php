<?php
$this->page_title = '平台统计';
$this->page_desc = '个人资金详情';
$this -> js = array('js/laydate/laydate');
?>
<style type="text/css">
    .clearfix input{ margin: 0;};
</style>
<div class="clearfix">
    <div class="pull-left" style="padding-left: 1em;">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'method' => 'GET',
            'htmlOptions' => array(
                'name' => 'form_search'
            ),
        ));
        ?>
		<table class="search_table">
			<tr>
				<td>手机号码：</td>
                <td><?php echo $form->textField($user_model, 'user_phone', array('placeholder' => '请输入用户手机号码')); ?></td>
				<td>真实姓名：</td>
                <td><?php echo $form->textField($user_model, 'real_name', array('placeholder' => '请输入用户真实姓名')); ?></td>
				
			</tr>
            <tr>
                <td>开始时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['start_time'])?Yii::app()->request->getParam('start_time'):'' ?>" placeholder="请输入开始时间" name="start_time"></td>
                <td>结束时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['end_time'])?Yii::app()->request->getParam('end_time'):'' ?>" placeholder="请输入结束时间" name="end_time"></td>
				
                
            </tr>
            <tr>
                <td>首投开始时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['order_time'])?Yii::app()->request->getParam('order_time'):'' ?>" placeholder="请输入首投开始时间" name="order_time"></td>
                <td>首投结束时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['order_end_time'])?Yii::app()->request->getParam('order_end_time'):'' ?>" placeholder="请输入首投结束时间" name="order_end_time"></td>
                <td><a href="javascript:;" onclick="document.form_search.submit();" class="btn btn-success show-tooltip" title="" data-original-title="搜索"><i class="icon-ok"></i></a></td>
                
            </tr>
			
        </table>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="box-content">
    <div class="btn-toolbar pull-right">
        <div class="btn-group">
            <!--<a class="btn btn-circle show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('create'); ?>" data-original-title="添加文章"><i class="icon-plus"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Edit selected"><i class="icon-edit"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="javascript:;" onclick="delmore()" data-original-title="删除选中文章"><i class="icon-trash"></i></a>-->
        </div>
        <div class="btn-group">
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Print"><i class="icon-print"></i></a>-->
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to PDF"><i class="icon-file-text-alt"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to Exel"><i class="icon-table"></i></a>-->
        </div>
        <div class="btn-group">
            <a class="btn btn-circle show-tooltip" title="" target="_blank" href="<?php
            echo Yii::app()->controller->createUrl('list', array('outfile_excel' => '1',
                'User[real_name]' => isset($_GET['User']) ? $_GET['User']['real_name'] : "",
                'User[user_name]' => isset($_GET['User']) ? $_GET['User']['user_phone'] : ""));
            ?>" data-original-title="导出Exel"><i class="icon-table"></i>
                <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
    <table class="table table-advance">
        <thead>
            <tr>
    <!--           <th style="width:18px"><input type="checkbox"></th>-->
    			<th>用户名</th>
                <th>真实姓名</th>
                <th>手机号</th>
                <th>充值总额</th>
                <th>提现总额</th>
                <th>投标总额</th>
                <th>提现手续费</th>
                <th>已收利息总额</th>
                <th>待收利息总额</th>
                <th>投标笔数</th>
                <th>充值次数</th>
                <th>提现次数</th>
                <th>收款总额</th>
				<th>首次投标</th>
				<th>注册时间</th>
                <th style="width:100px">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $k => $v) { ?>
                <tr>
                    <!--<td><input type="checkbox" class="checkdel" value="<?php echo $v->user_id; ?>"></td>-->
                    <td><?php echo $v->user->user_name; ?></td>
                    <td><?php echo $v->user->real_name; ?></td>
                    <td><?php echo $v->user->user_phone; ?></td>
                    <td>¥<?php echo $v->user_recharge; ?></td>
                    <td>¥<?php echo $v->user_cash; ?></td>
                    <td>¥<?php echo $v->user_order; ?></td>
                    <td>¥<?php echo $v->user_cashfee; ?></td>
                    <td>¥<?php echo $v->assets->have_interest; ?></td>
                    <td>¥<?php echo $v->assets->wait_interest; ?></td>
                    <td><?php echo $v->user_order_num; ?></td>
                    <td><?php echo $v->user_recharge_num; ?></td>
                    <td><?php echo $v->user_cash_num; ?></td>
                    <td>¥<?php echo $v->user_haverepay; ?></td>
					<td><?php echo LYCommon::subtime($v->user_first_order,1); ?></td>
					<td><?php echo LYCommon::subtime($v->addtime,1); ?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small show-tooltip" title="查看个人资金详情" href="<?php echo Yii::app()->controller->createUrl('sumIt/detail', array('userId' => $v->user_id)); ?>" data-original-title="查看详情"><i class="icon-zoom-in"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pagination text-center">
        <ul>
            <!--        <li><a href="#">← 上一页</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li class="active"><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">6</a></li>
                    <li><a href="#">下一页 → </a></li>-->
            <?php echo $page_list; ?>
        </ul>
    </div>
</div>