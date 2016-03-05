
<ul class="abo_list">
	<?php foreach($article_list as $k=>$v){ ?>
        <li><a href="<?php echo Yii::app()->controller->createUrl('article/view',array('id'=>$v->article_id)); ?>"><?php echo $v->article_title; ?></a><span><?php echo LYCommon::subtime($v->add_time,3); ?></span></li>
   	<?php } ?>
</ul>
<ul class="pager"><?php echo $page_list; ?></ul>