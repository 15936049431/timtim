<?php
    $this->page_title = '添加红包('.$assets_info->user->user_name.')';
    $this->page_desc = '添加红包';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 充值信息</h3>
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
                <?php if(!empty($error_list)){ ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <p>请修改以下错误</p>
                    <ul>
                        <?php foreach($error_list as $k => $v){ ?>
                            <?php echo $v; ?>
                        <?php } ?>
                    </ul>
                    
                </div>
                <?php } ?>
<!--                输出错误信息  结束-->
                        <div class="control-group <?php echo array_key_exists('paymoney', $error_list)?'error':'' ?>">
                        <label class="control-label required" for="Myself_oldpassword">充值金额 <span class="required">*</span></label>
                        <div class="controls">
                            <input type="text" name="Opermoney[paymoney]" placeholder="请输入充值金额" value="<?php echo $opermoney_post['paymoney']; ?>">
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