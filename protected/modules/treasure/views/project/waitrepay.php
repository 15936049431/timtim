<?php
    $this->page_title = '项目中心';
    $this->page_desc = '项目中心简介';
    $this -> js = array('js/laydate/laydate');
?>
<style type="text/css">
    .clearfix input{ margin: 0;};
</style>
<div class="clearfix">
    <div class="pull-left" style="padding-left: 1em;">
        <?php $form = $this->beginWidget('CActiveForm',array(
            'method'=>'GET',
            'htmlOptions'=>array(
                'name'=>'form_search',
            	'action'=>Yii::app()->controller->createUrl("project/waitrepay"),
            ),
        )); ?>
        <table class="search_table">
            <tr>
            	<td>用户名：</td>
                <td><input type="text" value="<?php echo isset($_GET['user_name'])?Yii::app()->request->getParam('user_name'):'' ?>" placeholder="请输入用户名" name="user_name"></td>
                <td>应还款开始时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['start_time'])?Yii::app()->request->getParam('start_time'):'' ?>" placeholder="请输入开始时间" name="start_time"></td>
                <td>应还款结束时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['end_time'])?Yii::app()->request->getParam('end_time'):'' ?>" placeholder="请输入结束时间" name="end_time"></td>
            </tr>
			<tr>
				<td>借款标题：</td>
                <td><input type="text" value="<?php echo isset($_GET['"p_name"'])?Yii::app()->request->getParam('p_name'):'' ?>" placeholder="请输入借款标题" name="p_name"></td>
				<td>借款类型：</td>
                <td><select name="style">
                        <option value="0">---选择还款方式---</option>
                        <option value="1">等额本息</option>
                        <option value="2">到期还本按月付息</option>
                        <option value="3">到期还本息</option>
                        <option value="4">天标按天回款</option>
                        <option value="5">按季度付息到期还本</option>                
                    </select>
                </td>
                <td>到期类型：</td>
                <td>
                    <select name="expire">
                        <option value="0">---选择到期类型---</option>
                        <option value="1" <?php echo !empty($_GET['expire'])&&$_GET['expire']==1?"selected":"" ?>>本金到期</option>
                    </select>
                
                </td>
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
<!-- <a class="btn btn-circle show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('project/create'); ?>" data-original-title="添加文章"><i class="icon-plus"></i></a>
           <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to PDF"><i class="icon-file-text-alt"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to Exel"><i class="icon-table"></i></a>-->
        </div>
        <div class="btn-group">
            <a class="btn btn-circle show-tooltip" title="" target="_blank" href="<?php echo Yii::app()->controller->createUrl('waitrepay',  array_merge($_GET,array('outfile_excel'=>'1'))); ?>" data-original-title="导出Exel"><i class="icon-table"></i>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
			<th>项目编号</th>
            <th><?php echo "借款人"; ?></th>
<th><?php echo "借款标题"; ?></th>
<th><?php echo $model->getAttributeLabel('p_order'); ?></th>
<th><?php echo $model->getAttributeLabel('p_repaytime'); ?></th>
<th><?php echo $model->getAttributeLabel('p_fullverifytime'); ?></th>
<th><?php echo $model->getAttributeLabel('p_style'); ?></th>
<th><?php echo $model->getAttributeLabel('p_repayaccount'); ?></th>
<th><?php echo $model->getAttributeLabel('p_money'); ?></th>
<th><?php echo $model->getAttributeLabel('p_interest'); ?></th>
            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
			<td><?php echo $v->p_project_id; ?></td>
            <td><?php echo $v->project->user->user_name; ?></td>
            <td><a href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$v->p_project_id)); ?>" style="color:#888"><?php echo $v->project->p_name; ?></a></td>
            <td><?php echo $v->p_order+1; ?>/<?php echo $v->project->p_time_limit; ?></td>
            <td><?php echo LYCommon::subtime($v->p_repaytime,2); ?></td>
            <td><?php echo LYCommon::subtime($v->project->p_fullverifytime,2); ?></td>
            <td><?php echo LYCommon::GetItem_of_value($v->project->p_style,'project_repay_type'); ?></td>
            <td>￥<?php echo $v->p_repayaccount; ?></td>
            <td>￥<?php echo $v->p_money; ?></td>
            <td>￥<?php echo $v->p_interest; ?></td>
            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="" href="#" data-original-title="查看"><i class="icon-zoom-in"></i></a>-->
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('repayview',array('id'=>$v->p_id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                    <!--<a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->p_id; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>-->
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