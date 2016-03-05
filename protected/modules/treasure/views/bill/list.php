<?php
    $this->page_title = '资金记录中心';
    $this->page_desc = '资金记录中心简介';
    $this -> js = array('js/laydate/laydate');
?>
<style type="text/css">
    .clearfix input{ margin: 0;};
</style>
<div class="clearfix">
    <div class="pull-left" style="padding-left: 1em;">
        <?php $form = $this->beginWidget('CActiveForm',array(
            'action'=>Yii::app()->controller->createUrl('bill/list'),
            'method'=>'GET',
            'htmlOptions'=>array(
                'name'=>'form_search'
            ),
        )); ?>
        <table class="search_table">
            <tr>
                <td>类型：</td>
                <td><?php echo $form->dropDownList($model,'b_itemtype',$type_list,array('class'=>'input-xlarge')); ?></td>
                <td>用户名：</td>
                <td><?php echo $form->textField($user_model,'user_name',array('placeholder'=>'请输入用户名')); ?></td>
            </tr>
			<tr>
				<td>开始时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['start_time'])?Yii::app()->request->getParam('start_time'):'' ?>" placeholder="请输入开始时间" name="start_time"></td>
                <td>结束时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['end_time'])?Yii::app()->request->getParam('end_time'):'' ?>" placeholder="请输入结束时间" name="end_time"></td>
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
        	<a class="btn btn-circle show-tooltip" title="" target="_blank" href="<?php echo Yii::app()->controller->createUrl('list',array_merge($_GET,array('outfile_excel'=>'1'))); ?>" data-original-title="导出Exel"><i class="icon-table"></i>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
             <!--<th style="width:18px"><input type="checkbox"></th>
            <th><?php echo $model->getAttributeLabel('b_id'); ?></th>
<th><?php echo $model->getAttributeLabel('b_type'); ?></th>-->
        <th><?php echo $model->getAttributeLabel('user_id'); ?></th>
<th><?php echo $model->getAttributeLabel('real_name'); ?></th>
<th><?php echo $model->getAttributeLabel('b_itemtype'); ?></th>
<th><?php echo $model->getAttributeLabel('b_money'); ?></th>
<th><?php echo $model->getAttributeLabel('u_total_money'); ?></th>
<th><?php echo $model->getAttributeLabel('u_real_money'); ?></th>
<th><?php echo $model->getAttributeLabel('u_frost_money'); ?></th>
<th><?php echo $model->getAttributeLabel('u_wait_total_money'); ?></th>
<th><?php echo $model->getAttributeLabel('remark'); ?></th>
<th><?php echo $model->getAttributeLabel('b_time'); ?></th>

            <!--<th style="width:100px">操作</th>-->
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
 <!--       <td><input type="checkbox" class="checkdel" value="<?php echo $v->b_id; ?>"></td>
            <td><?php echo $v->b_id; ?></td>
			<td><?php echo $model->itemAlias('b_type',$v->b_type); ?></td>-->
			<td><?php echo isset($v->user->user_name)?$v->user->user_name:''; ?></td>
<td><?php echo isset($v->user->real_name)?$v->user->real_name:''; ?></td>
<td><?php echo	LYCommon::GetItem($v->b_itemtype,'assets_type'); ?></td>
<td>￥<?php echo $v->b_money; ?></td>
<td>￥<?php echo $v->u_total_money; ?></td>
<td>￥<?php echo $v->u_real_money; ?></td>
<td>￥<?php echo $v->u_frost_money; ?></td>
<td>￥<?php echo $v->u_wait_total_money; ?></td>
<td><?php echo $v->remark; ?></td>
<td><?php echo LYCommon::subtime($v->b_time,2); ?></td>

            <!--<td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="" href="#" data-original-title="查看"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$v->b_id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->b_id; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>
                </div>
            </td>-->
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