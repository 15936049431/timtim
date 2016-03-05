<?php
    $this->page_title = '项目信息录入';
    $this->page_desc = '项目信息录入';
    $this -> js = array('js/dot.min','js/laydate/laydate');
?>
<style>

</style>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 信息录入</h3>
                        <div class="box-tool">
                            <a data-action="close" href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
					
					<div class="tab-pane active" id="tab-1-1">
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
                                <?php echo $form->labelEx($model, 'p_outord', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'p_outord', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('p_outord'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_brand', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'p_brand',$brand_arr); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_plate', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'p_plate', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('p_plate'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_kilometer', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'p_kilometer', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('p_kilometer'))); ?>
                                <span class="help-inline">km</span>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_carddate', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'p_carddate', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('p_carddate'),'onfocus'=>'laydate();')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_carcolor', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'p_carcolor',$color_arr); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_province', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'p_province',$province_arr); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_city', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'p_city',$city_arr); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_origin', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'p_origin', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('p_origin'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'p_evaluation', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'p_evaluation', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('p_evaluation'))); ?>
                                <span class="help-inline">元</span>
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
         </div>
<script type="text/yeless" id="city_tmp">
    {{ for(var i=0;i<it.length;i++){ }}
        <option value="{{=it[i].id}}">{{=it[i].name}}</option>
    {{ } }}
</script>

<script type="text/javascript">
    $("#Project_p_province").change(function(){
        $.post("<?php echo Yii::app()->controller->createUrl('project/getCity_ajax') ?>?pid="+$(this).val(),{
            
        },function(data){
            var obj = eval("("+data+")");
            $("#Project_p_city").html(doT.template($("#city_tmp").html())(obj));
        });
    });
</script>