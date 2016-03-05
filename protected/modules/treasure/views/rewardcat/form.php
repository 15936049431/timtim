<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 红包活动信息</h3>
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
                        <?php echo $form->labelEx($model,'rcat_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'rcat_name',array('class'=>'input-xlarge','placeholder'=>'请填写文章标题')); ?>
                        </div>
                    </div>


                    <div class="control-group">
                        <?php echo $form->labelEx($model,'rcat_alias',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'rcat_alias',array('class'=>'input-xlarge','placeholder'=>'请填写文章标题')); ?>
                        </div>
                    </div>


                    <div class="control-group">
                        <?php echo $form->labelEx($model,'rcat_share',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'rcat_share',array('class'=>'input-xlarge','placeholder'=>'请填写文章标题')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model,'begin_time',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'begin_time',array('class'=>'input-xlarge','placeholder'=>'请填写文章标题')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model,'end_time',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'end_time',array('class'=>'input-xlarge','placeholder'=>'请填写文章标题')); ?>
                        </div>
                    </div>

                    
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'rcat_status',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php foreach($model->itemAlias('rcat_status') as $k => $v){ ?><label class="radio inline"><input type="radio" name="Rewardcat[rcat_status]" <?php echo $k==$model->rcat_status?"checked='checked'":"" ?> value="<?php echo $k; ?>"> <?php echo $v; ?></label><?php } ?>
                            <span class="help-inline"></span>
                        </div>
                    </div> 



                    <div class="control-group">
                      <?php echo $form->labelEx($model,'rcat_desc',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textArea($model,'rcat_desc',array('class'=>'span4','rows'=>'5')); ?>
                      </div>
                   </div>
                   
                    <div class="control-group">
                      <?php echo $form->labelEx($model,'rcat_con',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textArea($model,'rcat_con',array('class'=>'span4','rows'=>'5')); ?>
                      </div>
                        <?php $this->widget('application.widget.kindeditor.KindEditor',array('target'=>array(
                        '#Rewardcat_rcat_con'=>array('uploadJson'=> $this->createUrl('upload')))));?>
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

<script type="text/javascript">
    laydate({
        elem: '#Rewardcat_begin_time', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
        event: 'focus' //响应事件。如果没有传入event，则按照默认的click
    });
    laydate({
        elem: '#Rewardcat_end_time', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
        event: 'focus' //响应事件。如果没有传入event，则按照默认的click
    });
</script> 