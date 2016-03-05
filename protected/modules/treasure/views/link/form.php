<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 链接信息</h3>
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
                        <?php echo $form->labelEx($model,'link_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'link_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('link_name'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div><div class="control-group">
                        <?php echo $form->labelEx($model,'link_pic',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="<?php echo SITE_UPLOAD.'link/'.$model->link_pic; ?>" alt="" width="150" height="150">
                            </div>
                            <div class="fileupload fileupload-new" data-provides="fileupload" style="margin-top:10px;">
                                <div class="input-append">
                                   <div class="uneditable-input">
                                        <i class="icon-file fileupload-exists"></i> 
                                        <span class="fileupload-preview"></span>
                                   </div>
                                   <span class="btn btn-file">
                                        <span class="fileupload-new">选择文件</span>
                                        <span class="fileupload-exists">更换</span>
                                        <input type="file" name="Link[link_pic]" id="Link_link_pic" class="default">
                                   </span>
                                   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">删除</a>
                                </div>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                      </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'link_url',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'link_url',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('link_url'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div><div class="control-group">
                        <?php echo $form->labelEx($model,'link_type',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'link_type',$link_type,array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'link_order',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'link_order',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('link_order'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'link_desc',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($model,'link_desc',array('rows'=>'5','class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('link_desc'))); ?>
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