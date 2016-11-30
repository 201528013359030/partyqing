<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\View;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>廉政教育</title>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<style>
.content{vertical-align:bottom;padding:10px 10px 10px 10px;}
.pic0{margin-bottom:8px;width:20px;margin-right:0px}
.pic{width:40px;margin-right:5px;-webkit-border-radius: 25px;border-radius: 25px;}
.name{color:#666666;display:inline-block;height:25px;margin-top:9px;vertical-align:top;	}
.time{color:#666666;float:right;margin-top:9px;}
</style>
</head>
<body style="background-color: #fff;">
<div style="text-align:center;vertical-align:top;padding-top:15px;padding-bottom:10px; ">
<?php if(empty($data)):?>
<div class="listIteam" id="empty">
<div class="empty">暂无</div>
</div>	
<?php else:?>
<img style="width:23px;margin-right:10px" src="../web/img/jiangbei.png">学习时长排行榜TOP100
</div>
<?php endif?>
 <?php foreach ($data as $key=>$value): ?>
<div class="content">	
<?php if($key==0):?>
<img class="pic0" src="../web/img/jiangpai_01.png">
<?php elseif($key==1):?>
<img class="pic0" src="../web/img/jiangpai_02.png">
<?php elseif($key==2):?>
<img class="pic0" src="../web/img/jiangpai_03.png">
<?php else:?>
<span style="display:inline-block;vertical-align:top;width:15px;margin-left:5px;margin-top:7px;font-size:14pt;"><?=$key+1?></span>
<?php endif?>
<img class="pic" src="<?=$value['photo']?>">
<span class="name"><?=$value['name']?></span>
<span class="time"><?=$value['time']?>分钟</span></div>
  <? endforeach?>
</body>
</html>

