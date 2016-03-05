<?php
    $this->page_title = '授权中心';
    $this->page_desc = '授权中心简介';
?>
<div class="box-content">
<table class="table table-advance">
    <thead>
        <tr>
            <th><?php echo $manager_model->getAttributeLabel('manager_name'); ?></th>
            <th><?php echo $manager_model->getAttributeLabel('manager_realname'); ?></th>
            <th><?php echo $manager_model->getAttributeLabel('manager_tel'); ?></th>
            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($manager_list as $k => $v){ ?>
        <tr>
            <td><?php echo $v->manager_name; ?></td>
            <td><?php echo $v->manager_realname; ?></td>
            <td><?php echo $v->manager_tel; ?></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('giveauth/giveauth',array('manager_id'=>$v->manager_id)); ?>" data-original-title="授权"><i class="icon-zoom-in"></i></a>
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