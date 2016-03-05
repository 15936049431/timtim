<?php
    $this->page_title = '商家中心';
    $this->page_desc = '商家中心简介';
?>
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
            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="刷新"><i class="icon-repeat"></i></a>
        </div>
    </div>
<table class="table table-advance">
    <thead>
        <tr>
            <th style="width:18px"><input type="checkbox"></th>
            <th><?php echo $model->getAttributeLabel('sms_id'); ?></th>
            <th><?php echo $model->getAttributeLabel('get_user_id'); ?></th>
            <th><?php echo $model->getAttributeLabel('get_user_contact'); ?></th>
            <th><?php echo $model->getAttributeLabel('sms_con'); ?></th>
            <th><?php echo $model->getAttributeLabel('status'); ?></th>
            <th><?php echo $model->getAttributeLabel('send_time'); ?></th>
            <th><?php echo $model->getAttributeLabel('send_ip'); ?></th>

        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
            <td><input type="checkbox" class="checkdel" value="<?php echo $v->sms_id; ?>"></td>
            <td><?php echo $v->sms_id; ?></td>
            <td><?php echo $v->get_user_id; ?></td>
            <td><?php echo $v->get_user_contact; ?></td>
            <td><?php echo $v->sms_con; ?></td>
            <td><?php echo $model->itemAlias('status',$v->status); ?></td>
            <td><?php echo LYCommon::subtime($v->send_time,2); ?></td>
            <td><?php echo $v->send_ip ?></td>

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