<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\View;
?>
<style>
<!--
-->
</style>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta content="telephone=no" name="format-detection" />
<title>详情</title>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
</head>
<body>
	
<div id="wrap" class="wrap">
	<div class="moGrid">		
		<div class="header">
			<h1><?=$info['title']?></h1>
			<p class="lead">
                <span class="fr corFocus">                                   
                </span>
				<span class="fl corDate"><?=$info['createtime']?></span> <span class="fl corFocus"></span>
			</p>
		</div>
	</div>
	<div class="moGrid">	
		<div class="content">
			<!-- <p>				
				<img src="images/temp1.jpg">
			</p> -->
			<p>
			<?=$info['contents']?>
			</p>
		</div>
	</div>
	<div class="moGrid" id="attaBox">
	</div>
	<div class="moGrid">
		<div class="btnBox">
	
		</div>
	</div>
</div>
<input type="hidden" id="confrimed_count" value=<?//=$confirmed_count?>></input>

<script type="text/javascript">

</script>


</body>
</html>




