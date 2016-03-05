<?php
$this->css = array('erji');
$array = array("cheku",'contact','safe','fee');
$nid = $article_cat_info->article_cat_alias;
$this->url =in_array($nid,$array) ? Yii::app()->controller->createUrl("menu/iwant") :Yii::app()->controller->createUrl("menu/ilove") ;
?>
<section class="ckhd_con">
<?php foreach ($article_list as $k => $v) { ?>
   <div class="content">
	  <div class="con_bg">
	     <div class="con_tit" onclick="window.location.href='<?php echo Yii::app()->controller->createUrl('article/view', array('id' => $v->article_id)); ?>'">
		   <span><?php echo $v->article_title; ?></span><br><?php echo LYCommon::subtime($v->add_time,2); ?>
		 </div>
	  </div>
  </div>
<?php } ?>
</section>