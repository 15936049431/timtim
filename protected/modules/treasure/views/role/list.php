<?php
    $this->page_title = '角色中心';
    $this->page_desc = '角色中心简介';
?>
<div class="box-content">
    <div class="btn-toolbar pull-right">
        <div class="btn-group">
            <a class="btn btn-circle show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('role/create'); ?>" data-original-title="添加角色"><i class="icon-plus"></i></a>
<!--            <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Edit selected"><i class="icon-edit"></i></a>-->
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
            <th>角色名称</th>
            <th>角色描述</th>
            <th>默认URL</th>
            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($role_list as $k => $v){ ?>
        <tr>
            <td><?php echo $v->realname; ?></td>
            <td><?php echo $v->description; ?></td>
            <td><?php echo $v->defaulturl; ?></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('role/giveauth',array('name'=>$v->name)); ?>" data-original-title="授权"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('role/update',array('name'=>$v->name)); ?>" data-original-title="编辑"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="" href="javascript:;" onclick="deldata('<?php echo $v->name; ?>')" data-original-title="删除"><i class="icon-trash"></i></a>
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
        <?php //echo $page_list; ?>
    </ul>
</div>
</div>
<script type="text/javascript">
    function deldata(name){
        if(!(confirm('确定要删除吗？'))){
            return false;
        }
        $.post("<?php echo Yii::app()->controller->createUrl('ajaxdeldata'); ?>?name="+name,{
            
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
        $.post("<?php echo Yii::app()->controller->createUrl('article/ajaxdelmore') ?>",{
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