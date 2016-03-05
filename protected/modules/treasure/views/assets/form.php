<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 资金信息</h3>
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
                        <?php echo $form->labelEx($model,'total_money',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'total_money',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('total_money'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'real_money',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'real_money',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('real_money'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'frost_money',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'frost_money',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('frost_money'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'have_interest',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'have_interest',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('have_interest'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'wait_interest',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'wait_interest',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('wait_interest'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'wait_total_money',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'wait_total_money',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('wait_total_money'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>                    <div class="form-actions">
                                <input type="submit" class="btn btn-primary" value="提交">
                                <button type="reset" class="btn">重置</button>
                            </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
                        </div>