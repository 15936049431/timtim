<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 任务信息</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php $form = $this->beginWidget('CActiveForm',array(
                    'htmlOptions'=>array(
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
                        <label class="control-label required" for="Authitem_name">任务名称 <span class="required">*</span></label>
                        <div class="controls">
                            <?php echo $form->textField($model,'name',array('class'=>'input-xlarge','placeholder'=>'请填写任务名称')); ?>
                        </div>
                    </div>
                    

                    <div class="control-group">
                      <label class="control-label required" for="Authitem_description">任务描述 <span class="required">*</span></label>
                      <div class="controls">
                          <?php echo $form->textArea($model,'description',array('class'=>'span4','rows'=>'5')); ?>
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