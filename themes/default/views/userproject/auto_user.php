<?php 
    $this -> page_title = '自动投标列表';
?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>layout.css" />
<div id="usermain"class="fr">
    <div id="zj_gaikuang1">
        <div class="slideTxtBox">
            <div class="hd" id="zj_nav">
                <ul><li onclick="window.location.href = '<?php echo Yii::app()->controller->createUrl("userproject/auto_order"); ?>'">添加自动投标</li>
                    <li class="on" onclick="window.location.href = '<?php echo Yii::app()->controller->createUrl("userproject/auto_user"); ?>'">自动投标列表</li></ul>
            </div>
            <div class="bd">
                <ul class="infoList">
                    <div class="cz_info" style="margin-top:25px;">
                        <table>
                            <tr class="cz_tit">
                                <td >名次</td>
                                <td >投标人</td>
                                <td >最大投标金额</td>
                                <td >最小投标金额</td>
                            </tr>
                            <?php 
                                foreach ($list as $k=>$v) { ?>
                                <tr>
                                    <td><?php echo empty($_GET['page'])||$_GET['page']==1?($k+1):($_GET['page']-1)*10+$k+1; ?></td>
                                    <td><?php echo isset($v->user->user_name)?LYCommon::half_replace_utf8($v->user->user_name):''; ?></td>
                                    <td><?php echo $v->p_order_maxmoney; ?></td>
                                    <td><?php echo $v->p_order_minmoney; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="list"><?php echo $page_list; ?></div>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($message)) { ?>
    <script>
    pointererror('<?php echo $message; ?>',6);
    </script>
<?php } ?>
<?php if (!empty($success)) { ?>
    <script>
        pointermsg('<?php echo $success['0']; ?>', '<?php echo $success['1']; ?>', '<?php echo $success['2']; ?>', '<?php echo $success['3']; ?>');
    </script>
<?php } ?>