<?php
    $this->page_title = '审核话费';
    $this->page_desc = '';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<style>.controls{padding-top:5px;}</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 项目信息</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php $form = $this->beginWidget('CActiveForm',array(
                    'htmlOptions'=>array(
                        'enctype'=>'multipart/form-data',
                        'class'=>'form-horizontal',
                    ),
                )); ?>
<!--                输出错误信息  开始-->
                <?php if($form->errorSummary($model)){ ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <p><?php echo $form->errorSummary($model); ?></p>
                </div>
                <?php } ?>
<!--                输出错误信息  结束-->
            <div class="control-group">
                <?php echo $form->labelEx($model->user,'user_name',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $model->user->user_name; ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_money',array('class'=>'control-label')); ?>
                <div class="controls">
                    ¥<?php echo $model->exchange_money; ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_useintegral',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $model->exchange_useintegral; ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_remark',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $model->exchange_remark; ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_time',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo LYCommon::subtime($model->exchange_time,2); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <?php if($model->exchange_status!=0){ ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_verify',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $model->manager->manager_name; ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_verifytime',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo LYCommon::subtime($model->exchange_verifytime,2); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_verifyremark',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $model->exchange_verifyremark; ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <?php }else{ ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_status',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'exchange_status',array("0"=>"未审","1"=>"通过","2"=>"失败"),array('class'=>'input-xlarge')); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'exchange_verifyremark',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textarea($model,'exchange_verifyremark',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('exchange_verifyremark'))); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">提交审核</button>
            </div>
            <?php } ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>