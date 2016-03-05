<?php
    $this->page_title = '项目中心';
    $this->page_desc = '项目中心简介';
?>
<style type="text/css">
    .clearfix input{ margin: 0;};
</style>
<div class="clearfix">
    <div class="pull-left" style="padding-left: 1em;">
        <?php $form = $this->beginWidget('CActiveForm',array(
            'method'=>'GET',
            'htmlOptions'=>array(
                'name'=>'form_search'
            ),
        )); ?>
        <div style="display: inline-block;">
            搜索：
        </div>
		<div class="" style="display: inline-block;">
            <?php echo $form->dropDownList($model,'p_status',LYCommon::findcat('project_status',''),array('class'=>'input-xlarge')); ?>
        </div>
        <div class="" style="display: inline-block;">
            <?php echo $form->dropDownList($model,'p_type',array_merge(array('0'=>'全部'),LYCommon::findcat('project_type','')),array('class'=>'input-xlarge')); ?>
        </div>
        <div class="" style="display: inline-block;">
            <?php echo $form->textField($model,'p_name',array('placeholder'=>'请输入借款名称')); ?>
        </div>
        <div class="btn-group">
            <a href="javascript:;" onclick="document.form_search.submit();" class="btn btn-success show-tooltip" title="" data-original-title="搜索"><i class="icon-ok"></i></a>
        </div>
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
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to PDF"><i class="icon-file-text-alt"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to Exel"><i class="icon-table"></i></a>-->
        </div>
        <div class="btn-group">
        	<a class="btn btn-circle show-tooltip" title="" target="_blank" href="<?php echo Yii::app()->controller->createUrl('list',array('outfile_excel'=>'1')); ?>" data-original-title="导出Exel"><i class="icon-table"></i>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
			<th>项目编号</th>
        	<th><?php echo $model->getAttributeLabel('user_name'); ?></th>
			<th><?php echo $model->getAttributeLabel('real_name'); ?></th>
            <th><?php echo $model->getAttributeLabel('p_type'); ?></th>
			<th><?php echo $model->getAttributeLabel('p_name'); ?></th>
			<th><?php echo $model->getAttributeLabel('p_account'); ?></th>
			<th><?php echo $model->getAttributeLabel('p_apr'); ?></th>
			<th><?php echo $model->getAttributeLabel('p_style'); ?></th>
			<th><?php echo $model->getAttributeLabel('p_time_limit'); ?></th>
			<th><?php echo $model->getAttributeLabel('p_status'); ?></th>
			<th>添加时间</th>
            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
			<td><?php echo $v->p_id; ?></td>
        	<td><?php echo $v->user->user_name; ?></td>
            <td><?php echo $v->user->real_name; ?></td>
            <td><?php echo LYCommon::findcat('project_type',$v->p_type); ?></td>
            <td><a href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$v->p_id)); ?>" style="color:#888"><?php echo $v->p_name; ?></a></td>
            <td>￥<?php echo $v->p_account; ?></td>
            <td><?php echo $v->p_apr; ?>%</td>
            <td><?php echo LYCommon::GetItem_of_value($v->p_style,'project_repay_type'); ?></td>
            <td><?php if($v->p_type!=4){ echo $v->p_time_limit.(($v->p_time_limittype==1)?"天":"个月"); }else{echo "额满即还";} ?></td>
            <td><?php echo LYCommon::findcat('project_status',$v->p_status); ?></td>
			<td><?php echo LYCommon::subtime($v->p_addtime,3); ?></td>
            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="" href="#" data-original-title="查看"><i class="icon-zoom-in"></i></a>-->
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$v->p_id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                   <?php if($v->p_status==1){ ?><a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->p_id; ?>')" data-original-title="撤回"><i class="icon-trash"></i></a><?php } ?>
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
        $.post("<?php echo Yii::app()->controller->createUrl('callback'); ?>?id="+id,{
            
        },function(result){
            if(result){
                location.reload();
            }
        });
    }
</script>