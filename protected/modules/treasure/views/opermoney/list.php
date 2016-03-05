<?php
    $this->page_title = '添加扣除账号金额';
    $this->page_desc = '添加扣除账号金额';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
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
            <?php $search = Yii::app()->request->getParam('Search'); ?>
            <?php //var_dump($search);die; ?>
            <select name="Search[search_type]">
                <option value="user_name" <?php echo $search['search_type']=='user_name'?'selected="selected"':'' ?>>用户名</option>
                <option value="user_id" <?php echo $search['search_type']=='user_id'?'selected="selected"':'' ?>>用户ID</option>
                <option value="real_name" <?php echo $search['search_type']=='real_name'?'selected="selected"':'' ?>>真实姓名</option>
            </select>
        </div>
        <div class="" style="display: inline-block;">
            <input type="text" name="Search[search_value]" placeholder="请输入您要搜索的内容" value="<?php echo $search['search_value']; ?>">
        </div>
        <div class="btn-group">
            <a href="javascript:;" onclick="document.form_search.submit();" class="btn btn-success show-tooltip" title="" data-original-title="搜索"><i class="icon-ok"></i></a>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<div class="box-content">
    <div style="margin:10px 0;"></div>
<table class="table table-advance">
    <thead>
        <tr>
            <th><?php echo $user_model->getAttributeLabel('user_id'); ?></th>
            <th><?php echo $user_model->getAttributeLabel('user_name'); ?></th>
            <th><?php echo $user_model->getAttributeLabel('real_name'); ?></th>
            <th><?php echo $user_model->getAttributeLabel('card_num'); ?></th>
            <th><?php echo $user_model->getAttributeLabel('user_email'); ?></th>
            <th><?php echo $user_model->getAttributeLabel('user_phone'); ?></th>
            <th style="width:100px">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $k => $v){ ?>
        <tr>
            <td><?php echo $v->user_id; ?></td>
            <td><?php echo $v->user_name; ?></td>
            <td><?php echo $v->real_name; ?></td>
            <td><?php echo $v->card_num; ?></td>
            <td><?php echo $v->user_email; ?></td>
            <td><?php echo $v->user_phone; ?></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('opermoney/paymoney',array('id'=>$v->user_id)); ?>" data-original-title="充值"><i class="icon-plus"></i></a>
                    <a class="btn btn-small show-tooltip" title="" href="<?php echo Yii::app()->controller->createUrl('opermoney/outmoney',array('id'=>$v->user_id)); ?>" data-original-title="扣除"><i class="icon-exchange"></i></a>
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