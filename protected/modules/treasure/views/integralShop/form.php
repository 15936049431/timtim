<?php
    $this -> js = array('js/dot.min');
?>
<link rel="stylesheet" href="<?php echo STATIC_URL.'uploadify/uploadify.css' ?>" />
<script src="<?php echo STATIC_URL.'uploadify/jquery.uploadify.min.js' ?>"></script>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 商品信息</h3>
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
                        <?php echo $form->labelEx($model,'i_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'i_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('i_name'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_type',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'i_type',$typeitem,array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_order',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'i_order',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('i_order'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_num',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'i_num',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('i_num'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_price',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'i_price',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('i_price'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label required" for="IntegralShop_i_num">介绍图片 <span class="required">*</span></label>
                        <div class="controls">
                            <div id="file_upload_1"></div>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label required" for="IntegralShop_i_num"></label>
                        <div class="controls">
                            <div style="display:inline-block;" id="product_pic_show">
                                <?php if($this -> action -> id == 'update'){ ?>
                                    <?php
                                        $i = 1;
                                        $product_pic_arr = unserialize($model->i_pic);
                                        foreach($product_pic_arr as $k => $v){
                                    ?>
                                <font onclick="this.remove();">
                                    <img src="<?php echo SITE_UPLOAD.'integral_product/s_'.$v; ?>" />
                                    <input type="hidden" name="IntegralShop[productpic][pic<?php echo $i++; ?>]" value="<?php echo $v; ?>" />
                                </font>
                                <?php }} ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                      <?php echo $form->labelEx($model,'i_desc',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textArea($model,'i_desc',array('class'=>'span4','rows'=>'5','placeholder'=>'请填写'.$model->getAttributeLabel('i_desc'))); ?>
                          <span class="help-inline"></span>
                      </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_selenum',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'i_selenum',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('i_selenum'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_twice',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'i_twice',array('0' =>'可多次兑换','1' =>'不可多次兑换'),array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'i_ntype',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'i_ntype',array('0' =>'虚拟','1' =>'实物'),array('class'=>'input-xlarge')); ?>
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
<script type="text/lcp2p" id="product_pic_show_tmp">
    <font onclick="this.remove();">
        <img src="<?php echo SITE_UPLOAD.'integral_product/s_'; ?>{{=it.pic_name}}" />
        <input type="hidden" name="IntegralShop[productpic][pic{{=window.pro_pic_num}}]" value="{{=it.pic_name}}" />
    </font>
</script>
<script type="text/javascript">
    <?php if($this -> action -> id == 'update'){ ?>
        window.pro_pic_num = <?php echo $i; ?>;
    <?php }else{ ?>
        window.pro_pic_num = 1;
    <?php } ?>
    $(function() {
	$("#file_upload_1").uploadify({
		height        : 30,
		swf           : '<?php echo STATIC_URL.'uploadify/uploadify.swf' ?>',
		uploader      : '<?php echo Yii::app()->controller->createUrl('/shop/upload_integral_shop_pic') ?>',
		width         : 120,
                formData     : {
                    'timestamp' : '<?php echo $timestamp=time();?>',
                    'token'     : '<?php echo md5('yeless' . $timestamp);?>'
                },
                'onUploadSuccess' : function(file, data, response) {
                    var obj = eval("("+data+")");
                    $("#product_pic_show").append(doT.template($("#product_pic_show_tmp").html())(obj));
                    window.pro_pic_num ++;
                    //alert(data);
                }
	});
});
</script>