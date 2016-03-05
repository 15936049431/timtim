<?php
    $this->page_title = '银行卡中心';
    $this->page_desc = '银行卡中心简介';
    $this -> js = array('js/laydate/laydate');
?>
<style type="text/css">
    .clearfix input{ margin: 0;};
</style>
<div class="clearfix">
    <div class="pull-left" style="padding-left: 1em;">
        <?php $form = $this->beginWidget('CActiveForm',array(
            'action'=>Yii::app()->controller->createUrl('assetsBank/list'),
            'method'=>'GET',
            'htmlOptions'=>array(
                'name'=>'form_search'
            ),
        )); ?>
        <table class="search_table">
            <tr>
                <td>状态：</td>
                <td><?php echo $form->dropDownList($model,'b_status',array("1"=>"激活","0"=>"关闭"),array('class'=>'input-xlarge')); ?></td>
                <td>银行：</td>
                <td><?php echo $form->dropDownList($model,'b_bank',array_merge(array('0'=>'全部'),$bank_list),array('class'=>'input-xlarge')); ?></td>
                <td>用户名：</td>
                <td><?php echo $form->textField($user_model,'user_name',array('placeholder'=>'请输入用户名')); ?></td>
			</tr>
			<tr>
                <td>开始时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['start_time'])?Yii::app()->request->getParam('start_time'):'' ?>" placeholder="请输入开始时间" name="start_time"></td>
                <td>结束时间：</td>
                <td><input type="text" onfocus="laydate();" value="<?php echo isset($_GET['end_time'])?Yii::app()->request->getParam('end_time'):'' ?>" placeholder="请输入结束时间" name="end_time"></td>
                <td>真实姓名：</td>
                <td><?php echo $form->textField($user_model,'real_name',array('placeholder'=>'请输入真实姓名')); ?></td>
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
        	<a class="btn btn-circle show-tooltip" title="" target="_blank" href="<?php echo Yii::app()->controller->createUrl('list',array('outfile_excel'=>'1',
        			'AssetsBank[b_status]'=>isset($_GET['AssetsBank'])?$_GET['AssetsBank']['b_status']:"",
        			'AssetsBank[b_bank]'=>isset($_GET['AssetsBank'])?$_GET['AssetsBank']['b_bank']:"",
        			'User[user_name]'=>isset($_GET['User'])?$_GET['User']['user_name']:"")); ?>" data-original-title="导出Exel"><i class="icon-table"></i>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
<!--            <th style="width:18px"><input type="checkbox"></th>-->
<th><?php echo $model->getAttributeLabel('user_name'); ?></th>
<th><?php echo $model->getAttributeLabel('real_name'); ?></th>
<th><?php echo $model->getAttributeLabel('b_bank'); ?></th>
<th><?php echo $model->getAttributeLabel('b_branch'); ?></th>
<th><?php echo $model->getAttributeLabel('b_cardNum'); ?></th>
<th><?php echo $model->getAttributeLabel('b_status'); ?></th>
<th><?php echo $model->getAttributeLabel('b_addtime'); ?></th>

            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
<!--            <td><input type="checkbox" class="checkdel" value="<?php echo $v->b_id; ?>"></td>-->
<td><?php echo $v->user->user_name; ?></td>
<td><?php echo $v->user->real_name; ?></td>
<td><?php echo empty($v->b_bank) ? "未填写" : $v->item->i_name; ?></td>
<td><?php echo $v->b_branch; ?></td>
<td><?php echo $v->b_cardNum; ?></td>
<td><?php echo $model->itemAlias('b_status',$v->b_status); ?></td>
<td><?php echo LYCommon::subtime($v->b_addtime,2); ?></td>

            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="" href="#" data-original-title="查看"><i class="icon-zoom-in"></i></a>-->
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$v->b_id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->b_id; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>
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