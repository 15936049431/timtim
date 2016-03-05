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
                        <?php if($form->errorSummary($model)){ ?>
                        <div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            <p><?php echo $form->errorSummary($model); ?></p>
                        </div>
                        <?php } ?>
        <!--                输出错误信息  结束-->
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'user_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'user_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('user_name'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
<!--                    <div class="control-group">
                        <?php echo $form->labelEx($model,'login_pass',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'login_pass',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('login_pass'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'pay_pass',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'pay_pass',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('pay_pass'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>-->
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'real_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'real_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('real_name'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div><div class="control-group">
                        <?php echo $form->labelEx($model,'user_sex',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php foreach($model->itemAlias('user_sex') as $k => $v){ ?><label class="radio inline"><input type="radio" name="User[user_sex]" <?php echo $k==$model->user_sex?"checked='checked'":"" ?> value="<?php echo $k; ?>"> <?php echo $v; ?></label><?php } ?>
                            <span class="help-inline"></span>
                        </div>
                      </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'user_email',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'user_email',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('user_email'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'user_phone',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'user_phone',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('user_phone'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'home_tel',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'home_tel',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('home_tel'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div><div class="control-group">
                        <?php echo $form->labelEx($model,'user_pic',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="<?php echo SITE_UPLOAD.'userpic/'.$model->user_pic; ?>" alt="" width="150" height="150">
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
                                        <input type="file" name="User[user_pic]" id="User_user_pic" class="default">
                                   </span>
                                   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">删除</a>
                                </div>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                      </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'card_num',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'card_num',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('card_num'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div><div class="control-group">
                      <?php echo $form->labelEx($model,'user_address',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textArea($model,'user_address',array('class'=>'span4','rows'=>'5','placeholder'=>'请填写'.$model->getAttributeLabel('user_address'))); ?>
                          <span class="help-inline"></span>
                      </div>
                   </div>                   <div class="form-actions">
                                <input type="submit" class="btn btn-primary" value="提交">
                                <button type="reset" class="btn">重置</button>
                            </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
                        </div>