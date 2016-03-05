<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 文章信息</h3>
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
                        <?php echo $form->labelEx($model,'article_title',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'article_title',array('class'=>'input-xlarge','placeholder'=>'请填写文章标题')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'article_cat_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'article_cat_id',$this->getcatlist(),array('class'=>'input-xlarge')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                      <?php echo $form->labelEx($model,'article_pic',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <img style="width: 200px; height: 150px;" src="<?php echo SITE_UPLOAD.'article/'.$model->article_pic; ?>" alt="">
                        </div>
                         <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                               <div class="uneditable-input">
                                  <i class="icon-file fileupload-exists"></i> 
                                  <span class="fileupload-preview"></span>
                               </div>
                               <span class="btn btn-file">
                                   <span class="fileupload-new">选择文件</span>
                                   <span class="fileupload-exists">更换</span>
                                   <?php echo $form->fileField($model,'article_pic',array('class'=>'default')); ?>
                               </span>
                               <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">删除</a>
                            </div>
                         </div>
                      </div>
                   </div>

                    <div class="control-group">
                      <?php echo $form->labelEx($model,'article_desc',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textArea($model,'article_desc',array('class'=>'span4','rows'=>'5')); ?>
                      </div>
                   </div>

                    <div class="control-group">
                      <?php echo $form->labelEx($model,'article_cont',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textArea($model,'article_cont',array('class'=>'span4','rows'=>'5')); ?>
                      </div>
                        <?php $this->widget('application.widget.kindeditor.KindEditor',array('target'=>array(
                        '#Article_article_cont'=>array('uploadJson'=> $this->createUrl('upload')))));?>
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