<?php
    $this->page_title = '编辑管理员';
    $this->page_desc = '编辑管理员简介';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<?php echo $this->renderPartial('form', array('model'=>$model,'authassign_model'=>$authassign_model,'google_img'=>$google_img)); ?>