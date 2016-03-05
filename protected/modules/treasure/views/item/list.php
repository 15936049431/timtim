<?php
    $this->page_title = '联动模块';
    $this->page_desc = '联动模块内容管理';
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
            <?php echo $form->dropDownList($model,'i_cat_id',$cat_list,array('class'=>'input-xlarge')); ?>
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
            <a class="btn btn-circle show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('create'); ?>" data-original-title="添加内容"><i class="icon-plus"></i></a>
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Edit selected"><i class="icon-edit"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="javascript:;" onclick="delmore()" data-original-title="删除选中内容"><i class="icon-trash"></i></a>-->
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
            <th style="width:18px"><input type="checkbox"></th>
            <th><?php echo $model->getAttributeLabel('i_name'); ?></th>
<th><?php echo $model->getAttributeLabel('i_nid'); ?></th>
<th><?php echo $model->getAttributeLabel('i_cat_id'); ?></th>
<th><?php echo $model->getAttributeLabel('i_order'); ?></th>
<th><?php echo $model->getAttributeLabel('i_status'); ?></th>
<th><?php echo $model->getAttributeLabel('i_value'); ?></th>
<th><?php echo $model->getAttributeLabel('i_addtime'); ?></th>

            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
            <td><input type="checkbox" class="checkdel" value="<?php echo $v->i_id; ?>"></td>
            <td><?php echo $v->i_name; ?></td>
<td><?php echo $v->i_nid; ?></td>
<td><?php echo $v->itemcat->i_name; ?></td>
<td><?php echo $v->i_order; ?></td>
<td><?php echo ($v->i_status==0)?"关闭":"开启"; ?></td>
<td><?php echo LYCommon::truncate_longstr($v->i_value,20); ?></td>
<td><?php echo LYCommon::subtime($v->i_addtime,1); ?></td>

            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="" href="#" data-original-title="查看"><i class="icon-zoom-in"></i></a>-->
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$v->i_id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                    <!--<a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->i_id; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>-->
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
        $.post("<?php echo Yii::app()->controller->createUrl('ajaxdelete'); ?>?id="+id,{
            
        },function(result){
            if(result){
                location.reload();
            }
        });
    }
    function delmore(){
        var delarr = new Array();
        $(".checkdel").each(function(){
            if($(this).is(':checked')){
                delarr.push($(this).val())
            }
        });
        if(delarr == null || delarr == ''){
            alert('请选择要删除的文章');
            return false;
        }
        if(!(confirm("你确定要删除吗？"))){
            return false;
        }
        $.post("<?php echo Yii::app()->controller->createUrl('ajaxdelmore') ?>",{
            'delarr':delarr,
        },function(result){
            var obj = eval("("+result+")");
            if(obj.status == 1){
                location.reload();
            }else{
                alert(obj.message);
            }
            
            
        })
    }
</script>