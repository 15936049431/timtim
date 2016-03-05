<?php
$this->page_title = '体验标详情';
$this->page_desc = '体验标详情';
?>
<style>
    .controls{padding-top:5px;};
</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 项目信息</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form enctype="multipart/form-data" class="form-horizontal" id="yw0" action="" method="post">        <!--                输出错误信息  开始-->
                    
                    <div class="control-group">
                        <label class="control-label required" for="Project_p_name">项目名称 <span class="required">*</span></label>                        <div class="controls">
                            <?php echo $model->p_name; ?>                          <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label required" for="Project_p_status">状态 <span class="required">*</span></label>                        <div class="controls">
                            发布成功                            <span class="help-inline"></span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label required" for="Project_p_account">项目总额 <span class="required">*</span></label>                        <div class="controls">
                            <?php echo $model->p_account; ?> <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label required" for="Project_p_time_limit">借款周期 <span class="required">*</span></label>                        <div class="controls">
                           <?php echo $model->p_time_limit . (($model->p_time_limittype == 1) ? "天" : "个月"); ?> <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label required" for="Project_p_apr">年化利率 <span class="required">*</span></label>                        <div class="controls">
                            <?php echo $model->p_apr; ?>%
                            <span class="help-inline"></span>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label required" for="Project_p_valid_time">项目有效时间 <span class="required">*</span></label>                        <div class="controls">
                            一直有效，直到投满                           <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label required" for="Project_p_style">还款方式 <span class="required">*</span></label>                        <div class="controls">
                            <?php echo LYCommon::GetItem_of_value($model->p_style, 'project_repay_type') ?>                        <span class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label required" for="Project_p_lowaccount">最少投标金额 <span class="required">*</span></label>                        <div class="controls">
                            <?php echo $model->p_lowaccount; ?>元                            <span class="help-inline">（借款标最小投资金额）</span>
                        </div>
                    </div>    
                    <div class="control-group">
                        <label class="control-label required" for="Project_p_mostaccount">最大投标金额 <span class="required">*</span></label>                        <div class="controls">
                            <?php echo $model->p_mostaccount==0?'不限':$model->p_mostaccount; ?>                           <span class="help-inline">（借款标最多投资金额）</span>
                        </div>
                    </div>       
                </form>                    </div>
        </div>

        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i>借款资料</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php echo $model->p_content ;?>
                </div>                    </div>
        </div>

        

    </div>
</div>
   
<!-- END Main Content -->

