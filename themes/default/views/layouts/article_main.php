<?php $this->beginContent('//layouts/main'); $this->css=array("about"); ?>
<div class="abo_main main clear mb20">
    <div class="site">
       <a href="/">首页</a>
       <i class="fontello">&#xe83f;</i>
       <span><?php echo $this->article_cat_name; ?></span>
    </div>
    <ul class="abo_menu fl">
    	<?php foreach($this->article_p_list as $k=>$v){ ?>
         <li <?php echo ($v->article_cat_alias==$this->article_alias) ? "class='sel'" : "" ;?>><a href="<?php echo Yii::app()->controller->createUrl("article/list",array("p"=>$this->article_p,"cat"=>$v->article_cat_alias)); ?>"><?php echo $v->article_cat_name; ?></a></li>
        <?php } ?>
    </ul>
    <div class="abo_con fr">
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>

