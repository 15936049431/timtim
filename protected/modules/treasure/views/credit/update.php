<?php
    $this->page_title = '资信审核';
    $this->page_desc = '';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min','js/layer/layer.min');
?>
<?php echo $this->renderPartial('form', array('model'=>$model,'credit_pic_list'=>$credit_pic_list)); ?>