<style type="text/css">*{margin:0; padding:0;}</style>
<?php
// 带注释的参数必须根据自己的要求去修改，其它参数的作用自己看源码
$uidurl = urlencode(STATIC_URL."avatarupload/defaultIcon/1.jpg"); // 默认图片
$tmpurl = urlencode(STATIC_URL."avatarupload");
$tmpimgurl = urlencode(STATIC_URL."avatarupload");
//$imgurl = urlencode(STATIC_URL."avatarupload/upload_profile.php"); // 保存地址，php中只能用php://input读取图像内容，其它语言不清楚
$imgurl = urlencode(Yii::app()->controller->createUrl('usercenter/swfuploadpic'));
$delurl = urlencode(STATIC_URL."avatarupload");
$sourcepicurl = urlencode(STATIC_URL."avatarupload");
$albumurl = urlencode(STATIC_URL."avatarupload");
$jsfunc = "avatar_success"; // 保存成功后调用的js函数
$verifycode = "sss"; // ticket，保存时会以get提交，可用于验证合法性
$rnd = time();  // 防缓存
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="700" height="500" id="headPicture">
    <param name="movie" value="<?php echo STATIC_URL; ?>avatarupload/HeadPictureUpload/head4miniblog.swf?width=700&amp;height=500&amp;ver=0&amp;uidurl=<?php echo $uidurl; ?>&amp;tmpurl=<?php echo $tmpurl; ?>&amp;tmpimgurl=<?php echo $tmpimgurl; ?>&amp;imgurl=<?php echo $imgurl; ?>&amp;delurl=<?php echo $delurl; ?>&amp;sourcepicurl=<?php echo $sourcepicurl; ?>&amp;albumurl=<?php echo $albumurl; ?>&amp;jsfunc=<?php echo $jsfunc; ?>&amp;verifycode=<?php echo $verifycode; ?>&amp;limited=0&amp;ct=<?php echo $rnd; ?>">
    <param name="quality" value="high">
    <param name="wmode" value="transparent">
    <param name="allowScriptAccess" value="always">
    <embed src="<?php echo STATIC_URL; ?>avatarupload/HeadPictureUpload/head4miniblog.swf?width=700&amp;height=500&amp;ver=0&amp;uidurl=<?php echo $uidurl; ?>&amp;tmpurl=<?php echo $tmpurl; ?>&amp;tmpimgurl=<?php echo $tmpimgurl; ?>&amp;imgurl=<?php echo $imgurl; ?>&amp;delurl=<?php echo $delurl; ?>&amp;sourcepicurl=<?php echo $sourcepicurl; ?>&amp;albumurl=<?php echo $albumurl; ?>&amp;jsfunc=<?php echo $jsfunc; ?>&amp;verifycode=<?php echo $verifycode; ?>&amp;limited=0&amp;ct=<?php echo $rnd; ?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent" width="700" height="500" swliveconnect="true" allowscriptaccess="always" name="headPicture">
</object>
<div id="uploadComplete" style="display:none;">上传成功</div>


<script>
    function avatar_success(msg) {
        if ("uploadComplete" == msg) {
            //layer.msg('上传成功！',2,1);
            setTimeout("parent.location.reload();",800);
            //$("#headPicture").hide();
            //$("#uploadComplete").show();
        }
    }
</script>