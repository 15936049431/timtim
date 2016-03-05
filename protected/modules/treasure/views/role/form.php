<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 角色信息</h3>
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
                        <label class="control-label required" for="Authitem_name">角色名称 <span class="required">*</span></label>
                        <div class="controls">
                            <?php echo $form->textField($model,'name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('name'))); ?>
                        </div>
                    </div>
                    

                    <div class="control-group">
                      <label class="control-label required" for="Authitem_description">角色描述 <span class="required">*</span></label>
                      <div class="controls">
                          <?php echo $form->textArea($model,'description',array('class'=>'span4','rows'=>'5')); ?>
                      </div>
                   </div>

                   <div class="control-group">
                        <label class="control-label required" for="Authitemdefault_url">默认登陆URL <span class="required">*</span></label>
                        <div class="controls">
                            <?php echo $form->textField($model,'defaulturl',array('class'=>'input-xlarge','placeholder'=>'请填写文章标题')); ?>
                        </div>
                    </div>

                   <div class="control-group">
                        <label class="control-label">赋予权限</label>
                        <div class="controls">
                            <?php foreach($task_operetion_arr as $k => $v){ ?>
                            <label class="checkbox inline" onclick="showoperetionlist('<?php echo sha1($k); ?>');">
                              <?php echo $k; ?>[<font id="<?php echo sha1($k); ?>count">0</font>/<?php echo count($v); ?>]
                           </label>
                            <div style="display:none;" id="<?php echo sha1($k); ?>">
                                <?php foreach($v as $a => $b){ ?>
                                <label class="checkbox inline">
                                    <input type="checkbox" value="" name="Authoperetion[<?php echo $b['name'] ?>]" onclick="helpcheck('<?php echo sha1($k); ?>','<?php echo sha1($b['name']) ?>');" id="<?php echo sha1($b['name']) ?>"> <?php echo $b['realname'] ?>
                               </label>
                                <?php } ?>
                            </div>
                           <?php } ?>
                        </div>
                        <div class="controls" id="showoperetionlist" style="margin-top:20px;">
                            
                        </div>
                        
                     </div>
                     
                     

                    
                    <div class="form-actions">
                        <input type="submit" onclick="$('#showoperetionlist').remove();" class="btn btn-primary" value="提交">
                        <button type="reset" class="btn">重置</button>
                    </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function showoperetionlist(befrom){
        $("#showoperetionlist").html($("#"+befrom).html());
    }
    
    function helpcheck(fname,name){
        if($("#"+name).attr("checked") == 'checked'){
            $("#"+name).removeAttr("checked");
            $("#"+name).attr("value",'0');
        }else{
            $("#"+name).attr("checked",'true');
            $("#"+name).attr("value",'1');
        }
        var count = 0;
        $("#"+fname+" label").each(function(){
            if($(this).children().attr("checked") == 'checked'){
                count++;
            }
        });
        $("#"+fname+"count").html(count);
    }
</script>