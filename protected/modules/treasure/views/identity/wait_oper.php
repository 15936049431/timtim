<?php
    $this->page_title = '实名认证审核';
    $this->page_desc = '审核用户实名认证真实性';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<style type="text/css">
    .controls{ padding-top: 5px;}
</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 实名认证信息</h3>
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
                <?php echo $form->labelEx($model,'real_name',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'real_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('real_name'))); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'identity_num',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'identity_num',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('identity_num'))); ?>
                    <span class="help-inline"></span>
                </div>
            </div><div class="control-group">
                <?php echo $form->labelEx($model,'identity_positive',array('class'=>'control-label')); ?>
                <div class="controls">
                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                        <a target="_blank" href="<?php echo SITE_UPLOAD.'identity/'.$model->identity_positive; ?>"><img style="width:190px;height:140px;" src="<?php echo SITE_UPLOAD.'identity/'.$model->identity_positive; ?>" alt=""></a>
                    </div>
                </div>
              </div>
                <div class="control-group">
                <?php echo $form->labelEx($model,'identity_negative',array('class'=>'control-label')); ?>
                <div class="controls">
                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                        <a target="_blank" href="<?php echo SITE_UPLOAD.'identity/'.$model->identity_negative; ?>"><img style="width:190px;height:140px;" src="<?php echo SITE_UPLOAD.'identity/'.$model->identity_negative; ?>" alt="" ></a>
                    </div>

                </div>
              </div>
              <div class="control-group">
                <?php echo $form->labelEx($model,'check_remark',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model,'check_remark',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('check_remark'),'rows'=>'5')); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'add_time',array('class'=>'control-label')); ?>
                <div class="controls">
                    <label><?php echo LYCommon::subtime($model->add_time,2); ?></label>
                    <span class="help-inline"></span>
                </div>
            </div>
             <?php if($model->status==0){ ?>
                <div class="form-actions">
                    <button type="submit" name="Identity[sh_status]" value="1" class="btn btn-primary">审核通过</button>
                    <button type="submit" name="Identity[sh_status]" value="2" class="btn btn-danger">审核拒绝</button>
                </div>
             <?php } ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>