<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
$button = 0;
if($message == "10001"){
    $message = "认证信息错误或已过期";
    $button = 1;
}
?>
<script>
</script>
<div style="text-align:center;padding-top:100px;">
    <?=$message?>
    <?if($button):?>
            <!--a href="index.php?r=admin/index/relog" data-method="post" style="padding-left:8px;">点此重新登录</a-->
    <?endif?>
</div>
