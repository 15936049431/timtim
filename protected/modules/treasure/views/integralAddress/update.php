<?php
    $this->page_title = '编辑商品';
    $this->page_desc = '';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<?php echo $this->renderPartial('form', array('model'=>$model,'city_list'=>$city_list)); ?>