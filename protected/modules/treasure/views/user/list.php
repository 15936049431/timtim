<?php
    $this->page_title = '用户中心';
    $this->page_desc = '用户中心简介';
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
        <table class="search_table">
            <tr>
				<td>用户名：</td>
                <td><?php echo $form->textField($model,'user_name',array('placeholder'=>'请输入用户名')); ?></td>
                <td>邮箱：</td>
                <td><?php echo $form->textField($model,'user_email',array('placeholder'=>'请输入邮箱')); ?></td>
                <td>真实姓名：</td>
                <td><?php echo $form->textField($model,'real_name',array('placeholder'=>'请输入真实姓名')); ?></td>
				<?php echo $form->textField($model,'p_user_id',array('style'=>'display:none;')); ?>
            </tr>
			<tr>
				<td>排序：</td>
                <td><select name="order"><option value="register">注册时间</option><option value="invite">邀请好友</option></select></td>
				<td><a href="javascript:;" onclick="document.form_search.submit();" class="btn btn-success show-tooltip" title="" data-original-title="搜索"><i class="icon-ok"></i></a></td>
			</tr>
        </table>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="box-content">
    <div class="btn-toolbar pull-right">
        <div class="btn-group">
<!--            <a class="btn btn-circle show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('create'); ?>" data-original-title="添加文章"><i class="icon-plus"></i></a>
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
        			'User[user_email]'=>isset($_GET['User'])?$_GET['User']['user_email']:"",
        			'User[real_name]'=>isset($_GET['User'])?$_GET['User']['real_name']:"",
        			'User[user_name]'=>isset($_GET['User'])?$_GET['User']['user_name']:"",
					'User[p_user_id]'=>isset($_GET['User'])?$_GET['User']['p_user_id']:"")); 
        	?>" data-original-title="导出Exel"><i class="icon-table"></i>
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
<!--            <th style="width:18px"><input type="checkbox"></th>-->
            <th><?php echo $model->getAttributeLabel('user_name'); ?></th>
<th><?php echo $model->getAttributeLabel('real_name'); ?></th>
<th><?php echo $model->getAttributeLabel('user_sex'); ?></th>
<th><?php echo $model->getAttributeLabel('user_email'); ?></th>
<th><?php echo $model->getAttributeLabel('user_phone'); ?></th>
<th>邀请人数</th>
<th>被邀请</th>
<th>注册时间</th>
            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
<!--        <td><input type="checkbox" class="checkdel" value="<?php echo $v->user_id; ?>"></td>-->
            <td><?php echo $v->user_name; ?></td>
<td><?php echo !empty($v->real_name)?$v->real_name:"无"; ?><?php if($v->is_realname_check==1){echo "(已实名)";}else{echo "<font color='red'>(未实名)</font>";} ?></td>
<td><?php echo $model->itemAlias('user_sex',$v->user_sex); ?></td>
<td><?php echo $v->user_email; ?></td>
<td><?php echo $v->user_phone; ?></td>
<td><a href="<?php echo Yii::app()->controller->createUrl('user/list',array('User[p_user_id]'=>$v->user_id)); ?>"><?php echo $v->invite_num.'人'; ?></a></td>
<td><?php echo empty($v->p_user_id) ? '无' :$v->invite->user_name; ?></td>
<td><?php echo LYCommon::subtime($v->register_time,3); ?></td>
            <td>
                <div class="btn-group">
<!--                    <a class="btn btn-small show-tooltip" title="" href="#" data-original-title="查看"><i class="icon-zoom-in"></i></a>-->
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$v->user_id)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
      <!--              <a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->user_id; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>-->
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