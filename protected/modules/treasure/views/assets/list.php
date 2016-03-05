<?php
    $this->page_title = '资金中心';
    $this->page_desc = '资金中心简介';
?>
<style type="text/css">
    .clearfix input{ margin: 0;};
</style>
<div class="clearfix">
    <div class="pull-left" style="padding-left: 1em;">
        <?php $form = $this->beginWidget('CActiveForm',array(
            'method'=>'GET',
            'action'=>Yii::app()->controller->createUrl('assets/list'),
            'htmlOptions'=>array(
                'name'=>'form_search'
            ),
        )); ?>
        <div style="display: inline-block;">
            搜索：
        </div>
        <div class="" style="display: inline-block;">
            <?php echo $form->textField($user_model,'user_name',array('placeholder'=>'请输入用户名')); ?>
        </div>
        <div class="" style="display: inline-block;">
            <?php echo $form->textField($user_model,'real_name',array('placeholder'=>'请输入用户真实姓名')); ?>
        </div>
        <div class="" style="display: inline-block;">
            <select name="Search[input_sel_type]">
                <option value="0">请选择条件</option>
                <option <?php echo isset($_GET['Search']) ? ($_GET['Search']['input_sel_type']=='total_max'?'selected':'') : ""; ?> value="total_max">总额大于</option>
                <option <?php echo isset($_GET['Search']) ? ($_GET['Search']['input_sel_type']=='total_min'?'selected':'') : ""; ?> value="total_min">总额小于</option>
                <option <?php echo isset($_GET['Search']) ? ($_GET['Search']['input_sel_type']=='real_max'?'selected':'') : ""; ?> value="real_max">可用大于</option>
                <option <?php echo isset($_GET['Search']) ? ($_GET['Search']['input_sel_type']=='real_min'?'selected':'') : ""; ?> value="real_min">可用小于</option>
                <option <?php echo isset($_GET['Search']) ? ($_GET['Search']['input_sel_type']=='frost_max'?'selected':'') : ""; ?> value="frost_max">冻结大于</option>
                <option <?php echo isset($_GET['Search']) ? ($_GET['Search']['input_sel_type']=='frost_min'?'selected':'') : ""; ?> value="frost_min">冻结小于</option>
            </select>
        </div>
        <div class="" style="display: inline-block;">
            <input type="text" name="Search[input_money]" value="<?php echo isset($_GET['Search']) ? ($_GET['Search']['input_money']) : "" ; ?>" placeholder="请输入金额" />
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
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Print"><i class="icon-print"></i></a>-->
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to PDF"><i class="icon-file-text-alt"></i></a>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Export to Exel"><i class="icon-table"></i></a>-->
        </div>
        <div class="btn-group">
        	<a class="btn btn-circle show-tooltip" title="" target="_blank" href="<?php echo Yii::app()->controller->createUrl('list',array('outfile_excel'=>'1',
        			'User[real_name]'=>isset($_GET['User'])?$_GET['User']['real_name']:"",
        			'User[user_name]'=>isset($_GET['User'])?$_GET['User']['user_name']:"")); ?>" data-original-title="导出Exel"><i class="icon-table"></i>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
<!--           <th style="width:18px"><input type="checkbox"></th>-->
            <th><?php echo $model->getAttributeLabel('user_id'); ?></th>
<th><?php echo $model->getAttributeLabel('user_name'); ?></th>
<th><?php echo $model->getAttributeLabel('real_name'); ?></th>
<th><?php echo $model->getAttributeLabel('total_money'); ?></th>
<th><?php echo $model->getAttributeLabel('real_money'); ?></th>
<th><?php echo $model->getAttributeLabel('frost_money'); ?></th>
<th><?php echo $model->getAttributeLabel('yuebao_money'); ?></th>
<th><?php echo $model->getAttributeLabel('ourmoney'); ?></th>
<th><?php echo $model->getAttributeLabel('have_interest'); ?></th>
<th><?php echo $model->getAttributeLabel('wait_interest'); ?></th>
<th><?php echo $model->getAttributeLabel('wait_total_money'); ?></th>
            <!--<th style="width:100px">操作</th>-->
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
            <!--<td><input type="checkbox" class="checkdel" value="<?php echo $v->user_id; ?>"></td>-->
            <td><?php echo $v->user_id; ?></td>
            <td><?php echo $v->user->user_name; ?></td>
            <td><?php echo $v->user->real_name; ?></td>
            <td><?php echo $v->total_money; ?></td>
            <td><?php echo $v->real_money; ?></td>
            <td><?php echo $v->frost_money; ?></td>
            <td><?php echo $v->yuebao_money; ?></td>
            <td><?php echo $v->ourmoney; ?></td>
			<td><?php echo $v->have_interest; ?></td>
            <td><?php echo $v->wait_interest; ?></td>
			<td><?php echo $v->wait_total_money; ?></td>
            <!--<td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="" href="#" data-original-title="查看"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$v->user_id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->user_id; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>
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