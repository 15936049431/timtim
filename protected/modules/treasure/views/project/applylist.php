<?php
    $this->page_title = '项目中心';
    $this->page_desc = '项目中心简介';
?>
<div class="clearfix">
    <div class="pull-left" style="padding-left: 1em;">
        <?php $form = $this->beginWidget('CActiveForm',array(
            'method'=>'GET',
            'htmlOptions'=>array(
                'name'=>'form_search'
            ),
        )); ?>
        <div style="display: inline-block;">
            按金额搜索：
        </div>

        <div class="" style="display: inline-block;">
            <?php $search = Yii::app()->request->getParam('Search'); ?>
            <?php //var_dump($search);die; ?>
            <select name="money_type">
				<option value="all">全部</option>
                <option value="1" >10000元以下</option>
                <option value="2" >10000元到100000元</option>
                <option value="3" >100000元到1000000元</option>
            </select>
			<input type="text" name="time_type" placeholder="请输入您要限定的月份" value="<?php echo $search['search_value']; ?>" style="margin:0">
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
       		<a class="btn btn-circle show-tooltip" title="" target="_blank" href="<?php echo Yii::app()->controller->createUrl('applylist',array('outfile_excel'=>'1',
       				'money_type'=>isset($_GET['money_type']) ? $_GET['money_type'] : "",
       				'time_type'=>isset($_GET['time_type']) ? $_GET['money_type'] : ""  
       		)); ?>" data-original-title="导出Exel"><i class="icon-table"></i>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
            <th style="width:18px"><input type="checkbox"></th>
            <th><?php echo $model->getAttributeLabel('p_name'); ?></th>
<th><?php echo $model->getAttributeLabel('p_money'); ?></th>
<th><?php echo $model->getAttributeLabel('p_time_limit'); ?></th>
<th><?php echo $model->getAttributeLabel('p_phone'); ?></th>
<th><?php echo $model->getAttributeLabel('p_realname'); ?></th>
<th><?php echo $model->getAttributeLabel('p_status'); ?></th>
<th><?php echo $model->getAttributeLabel('p_addtime'); ?></th>

            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
            <td><input type="checkbox" class="checkdel" value="<?php echo $v->p_id; ?>"></td>
            <td><?php echo $v->p_name; ?></td>
            <td>￥<?php echo $v->p_money; ?></td>
            <td><?php echo $v->p_time_limit; ?>个月</td>
            <td><?php echo $v->p_phone; ?></td>
            <td><?php echo $v->p_realname; ?></td>
            <td><?php if($v->p_status==0){echo "申请";}elseif($v->p_status==1){echo "成功";}else{echo "拒绝";} ?></td>
            <td><?php echo LYCommon::subtime($v->p_addtime,2); ?></td>

            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('updateapply',array('id'=>$v->p_id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->p_id; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

    
<div class="pagination text-center">
    <ul>
        <?php echo $page_list; ?>
    </ul>
</div>
</div>
<script type="text/javascript">
    function deldata(id){
        if(!(confirm('确定要删除吗？'))){
            return false;
        }
        $.post("<?php echo Yii::app()->controller->createUrl('ajaxdelete_apply'); ?>?id="+id,{
            
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
            alert('请选择要删除的项目');
            return false;
        }
        if(!(confirm("你确定要删除吗？"))){
            return false;
        }
        $.post("<?php echo Yii::app()->controller->createUrl('ajaxdelmore_apply') ?>",{
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