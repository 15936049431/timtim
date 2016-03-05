<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 联动模块分类信息</h3>
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
                      <?php echo $form->labelEx($model,'i_cat_id',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->dropDownList($model,'i_cat_id',$this->GetIcat()) ?>
                          <span class="help-inline"></span>
                      </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'i_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('i_name'))); ?>
                            <span class="help-inline"></span>
                    </div>
                    </div><div class="control-group">
                      <?php echo $form->labelEx($model,'i_nid',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textField($model,'i_nid',array('class'=>'span4','rows'=>'5','placeholder'=>'请填写'.$model->getAttributeLabel('i_nid'))); ?>
                          <span class="help-inline"></span>
                      </div>
                   </div> 
				   <div class="control-group">
                      <?php echo $form->labelEx($model,'i_order',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textField($model,'i_order',array('class'=>'span4','rows'=>'5','placeholder'=>'请填写'.$model->getAttributeLabel('i_order'))); ?>
                          <span class="help-inline">填写排序从小到大</span>
                      </div>
                   </div>
				   <div class="control-group">
                      <?php echo $form->labelEx($model,'i_value',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textField($model,'i_value',array('class'=>'span4','rows'=>'5','placeholder'=>'请填写'.$model->getAttributeLabel('i_value'))); ?>
                          <span class="help-inline"></span>
                      </div>
                   </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_status',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php foreach($model->itemAlias('i_status') as $k => $v){ ?><label class="radio inline"><input type="radio" name="Item[i_status]" <?php echo $k==$model->i_status?"checked='checked'":"" ?> value="<?php echo $k; ?>"> <?php echo $v; ?></label><?php } ?>
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