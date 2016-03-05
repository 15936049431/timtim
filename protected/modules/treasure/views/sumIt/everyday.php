<?php
    $this->page_title = '每日统计';
    $this->page_desc = '每日进出明细';
?>
<div class="box-content">
    <div class="btn-toolbar pull-right">
        <div class="btn-group">
            <!--<a class="btn btn-circle show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('role/create'); ?>" data-original-title="添加角色"><i class="icon-plus"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Edit selected"><i class="icon-edit"></i></a>-->
        </div>
        <div class="btn-group">
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Print"><i class="icon-print"></i></a>-->
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to PDF"><i class="icon-file-text-alt"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to Exel"><i class="icon-table"></i></a>-->
        </div>
        <div class="btn-group">
        	<a class="btn btn-circle show-tooltip" title="" target="_blank" href="<?php echo Yii::app()->controller->createUrl('everyday',array('outfile_excel'=>'1')); ?>" data-original-title="导出Exel"><i class="icon-table"></i>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
            <th>日期</th>
            <th>充值</th>
            <th>充值人数</th>
			<th>充值次数</th>
            <th>提现</th>
			<th>提现人数</th>
            <th>提现次数</th>
			<th>投标</th>
            <th>投标人数</th>
			<th>投标次数</th>
            <th>注册人数</th>
			<th>还款总额</th>
			<th>还款笔数</th>
			<th>利息管理费</th>
			<th>提现手续费</th>
            <th>最后一笔操作时间</th>
        </tr>
    </thead>
    <tbody>
       <?php foreach($list as $k => $v){ ?>
        <tr>
            <td><?php echo $v->date; ?></td>
            <td>￥<?php echo $v->recharge; ?></td>
            <td><?php echo $v->recharge_user; ?>人</td>
			<td><?php echo $v->recharge_num; ?>次</td>
			<td>￥<?php echo $v->cash; ?></td>
			<td><?php echo $v->cash_user; ?>人</td>
			<td><?php echo $v->cash_num; ?>次</td>
			<td>￥<?php echo $v->order; ?></td>
			<td><?php echo $v->order_user; ?>人</td>
			<td><?php echo $v->order_num; ?>次</td>
			<td><?php echo $v->register_user; ?>人</td>
			<td>￥<?php echo $v->repay_account; ?></td>
			<td><?php echo $v->repay_num; ?>次</td>
			<td>￥<?php echo $v->manager_fee; ?></td>
			<td>￥<?php echo $v->cash_fee; ?></td>
            <td><?php echo LYCommon::subtime($v->lasttime,2); ?></td>
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