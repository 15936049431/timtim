<?php
    $this->page_title = '添加用户';
    $this->page_desc = '';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 用户信息</h3>
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
                        <?php if($form->errorSummary($user_model)){ ?>
                        <div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            <p><?php echo $form->errorSummary($user_model); ?></p>
                        </div>
                        <?php } ?>
        <!--                输出错误信息  结束-->
                    <div class="control-group">
                        <?php echo $form->labelEx($user_model,'user_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($user_model,'user_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$user_model->getAttributeLabel('user_name'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($user_model,'login_pass',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($user_model,'login_pass',array('class'=>'input-xlarge','placeholder'=>'请填写'.$user_model->getAttributeLabel('login_pass'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($user_model,'real_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($user_model,'real_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$user_model->getAttributeLabel('real_name'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    

                 
        <div class="form-actions">
                                <input type="submit" class="btn btn-primary" value="提交">
                                <button type="reset" class="btn">重置</button>
                            </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
                        </div>