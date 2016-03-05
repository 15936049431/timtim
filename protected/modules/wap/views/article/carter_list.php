<?php
    $this -> css = array('chefu');
    $this->url =Yii::app()->controller->createUrl("menu/ilove");
   function getPic($content) {
    preg_match_all("%<img src=['|\"]([^('|\")]*).*>%", $content, $m);
    if (!empty($m[1])) {
        $src = $m[1][0];
        return $src;
    } else {
        return '';
    }
}
?>
<section clss="box">
    <div class="slideTxtBox">
        <div class="bd">
            <ul class="infoList">
                <?php foreach($article_list as $k => $v){ ?>
                <a href="<?php echo Yii::app()->controller->createUrl('article/view',array('id'=>$v->article_id)); ?>">
                    <li>
                        <?php 
                        $src=getPic($v->article_cont);
                        if(empty($v->article_pic) && !empty($src)){ ?>
                        <img src="<?php echo $src; ?>">
                        <?php }else{ ?>
                         <img src="<?php echo SITE_UPLOAD.'article/s_'.$v->article_pic; ?>">
                        <?php } ?>
                         
                         
                        
                        <span><?php echo $v->article_title; ?></span>
                        <p><?php echo LYCommon::truncate_longstr($v->article_desc, 40); ?></p>
                    </li>
                </a>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>