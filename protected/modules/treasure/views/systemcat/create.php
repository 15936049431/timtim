<?php
    $this->page_title = '系统字段类别添加';
    $this->page_desc = '系统字段类别添加';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<?php echo $this->renderPartial('form', array('model'=>$model)); ?>