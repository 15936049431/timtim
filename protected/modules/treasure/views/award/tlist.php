<?php
    $this->page_title = '红包活动管理';
    $this->page_desc = '红包活动管理';
?>
<div class="box-content">
    <div class="btn-toolbar pull-right">
        <div class="btn-group">
            <a class="btn btn-circle show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('tcreate'); ?>" data-original-title="添加奖品"><i class="icon-plus"></i></a>
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Edit selected"><i class="icon-edit"></i></a>-->
            <a class="btn btn-circle show-tooltip" title="" href="javascript:;" onclick="delmore()" data-original-title="删除选中奖品"><i class="icon-trash"></i></a>
        </div>
        <div class="btn-group">
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Print"><i class="icon-print"></i></a>-->
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to PDF"><i class="icon-file-text-alt"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to Exel"><i class="icon-table"></i></a>-->
        </div>
        <div class="btn-group">
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
            <th><?php echo $model->getAttributeLabel('name'); ?></th>
			<th><?php echo $model->getAttributeLabel('money'); ?></th>
			<th><?php echo $model->getAttributeLabel('use_time'); ?></th>
			<th><?php echo $model->getAttributeLabel('投资区间'); ?></th>
			<th><?php echo $model->getAttributeLabel('期限区间'); ?></th>
			<th><?php echo $model->getAttributeLabel('type'); ?></th>
			<th><?php echo $model->getAttributeLabel('give_num'); ?></th>
			<th><?php echo $model->getAttributeLabel('give_money'); ?></th>
			<th><?php echo $model->getAttributeLabel('manager_id'); ?></th>
			<th><?php echo $model->getAttributeLabel('add_time'); ?></th>
            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
            <td><?php echo $v->name; ?></td>
<td>¥<?php echo $v->money; ?></td>
<td><?php echo $v->use_time; ?>天</td>
<td>¥<?php echo $v->low_account.'-'.$v->most_account; ?></td>
<td><?php echo $v->min_limit.'-'.$v->max_limit; ?>个月</td>
<td><?php echo $v->type; ?></td>
<td><?php echo $v->give_num; ?>人</td>
<td>¥<?php echo $v->give_money; ?></td>
<td><?php echo $v->manager->manager_name ?></td>
<td><?php echo LYCommon::subtime($v->add_time,3); ?></td>
            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="" href="#" data-original-title="查看"><i class="icon-zoom-in"></i></a>-->
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('tupdate',array('id'=>$v->id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->id; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>
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
<script type="text/javascript">
    function deldata(id){
        if(!(confirm('确定要删除吗？'))){
            return false;
        }
        $.post("<?php echo Yii::app()->controller->createUrl('tajaxdelete'); ?>?id="+id,{
            
        },function(result){
            if(result){
                location.reload();
            }
        });
    }
</script>