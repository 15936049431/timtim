<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 文章分类信息</h3>
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
                        <?php echo $form->labelEx($model,'p_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form -> dropDownList($model,'p_id',$this->getparent_arr()); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'article_cat_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'article_cat_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('article_cat_name'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'article_cat_alias',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'article_cat_alias',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('article_cat_alias'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                      <?php echo $form->labelEx($model,'article_cat_desc',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textArea($model,'article_cat_desc',array('class'=>'span4','rows'=>'5','placeholder'=>'请填写'.$model->getAttributeLabel('article_cat_desc'))); ?>
                          <span class="help-inline"></span>
                      </div>
                   </div>
                   <div class="control-group">
                        <?php echo $form->labelEx($model,'cat_type',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form -> radioButtonList($model,'cat_type',$model->itemAlias('cat_type'),array('template'=>'{input}{label}&nbsp;&nbsp;&nbsp;','separator'=>'','labelOptions'=>array('style'=>'display:inline-block;'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'list_tmp_path',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'list_tmp_path',array('value'=>'corpnews_list','class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('list_tmp_path'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'page_tmp_path',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'page_tmp_path',array('value'=>'teamdesc','class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('page_tmp_path'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'special_tmp_path',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'special_tmp_path',array('value'=>'index','class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('special_tmp_path'))); ?>
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