<?php
    $this->page_title = '添加新红包活动';
    $this->page_desc = '添加新红包活动简介';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min', 'js/laydate/laydate');
?>
<?php echo $this->renderPartial('form', array('model'=>$model)); ?>