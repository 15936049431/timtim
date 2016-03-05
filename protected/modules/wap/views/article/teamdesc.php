<?php
$this->page_title = $article_info->article_title;
$this->css = array('guanyu');
$array = array("photo","culture","yywd","falv","guquan","carterlist");
$nid = $article_info->acat->article_cat_alias;
$this->url= Yii::app()->request->urlReferrer;
/*if($nid=="culture"){
	$this->url=Yii::app()->controller->createUrl("menu/ilove");
}else{
	$this->url =in_array($nid,$array) ? Yii::app()->controller->createUrl('article/list',array('p'=>'aboutus','cat'=>$nid)) : Yii::app()->controller->createUrl('article/list',array('p'=>'aboutus','cat'=>$nid));www.w
}*/
?>
<section class="box">
    <ul class="xinwen">
        <?php echo $article_info->article_cont; ?>
    </ul>
</section>
<script>
    $(document).ready(function () {
        //网页加载前处理一遍
        $("img").load(function () {
            var screenwidth = $(window).width();
            var imgwidth = $(this).width();
            if (imgwidth > screenwidth && imgwidth>100) {
                var imgw=screenwidth-20;//排除边框
                var he=parseInt((imgw/imgwidth)*$(this).height());
                $(this).css({"width": screenwidth,"height":he})
            }
        });
        
        //改变窗口大小时也处理一遍。。不过。。手机貌似没这个东西
        var imglist = document.getElementsByTagName("img");
        function doDraw() {
            _width = $(window).width();
            for (var i = 0, len = imglist.length; i < len; i++) {
                DrawImage(imglist[i], _width);
            }
        }

        function DrawImage(ImgD, _width) {
            var image = new Image();
            image.src = ImgD.src;
            image.onload = function () {
                if (image.width > 100 && image.height > 100) {
                    if (image.width > _width) {
                        ImgD.width = _width;
                        ImgD.height = parseInt((image.height * _width) / image.width);
                    } else {
                        ImgD.width = image.width;
                        ImgD.height = image.height;
                    }

                }
            }

        }

        window.onresize = function () {
            //捕捉屏幕窗口变化，始终保证图片根据屏幕宽度合理显示
            doDraw();
        }

    });
</script>