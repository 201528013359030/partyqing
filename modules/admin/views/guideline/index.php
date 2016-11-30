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
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta content="email=no" name="format-detection" /> 
<meta name="format-detection" content="telphone=no" /> 
<!--bootmomo 为bootstrap.css去掉基础设置版本，所以不需要引用bootstrap.css了-->
<!--<link href="../css/bootmomo.css" rel="stylesheet" type="text/css">-->
<title>廉洁提醒</title>
<?=Html::cssFile('@web/css/cattalk.css')?>
<style>
.listset li .setInfo {
margin-left: 60px;
margin-top: 13px;	
}
h3{ font-weight:normal; 
color:#5C5C5C;
} 
</style>
</head>
<body>	
<div id="wrap" class="wrap">
<div id="scroller">	
	<div class="moBox">
		<ul class="listset" id="listScroll">					
			<?php foreach ($list as $key=>$value): ?>
			<li>
				<a href="index.php?r=admin/guidelinelist/index&id=<?=$value['No']?>" class="setIteam">					
					<div class="setpic">
						<img src="<?=$value['icon']?>">
					</div>
					<div class="setInfo">
						<h3><span><?=$value['name']?></span></h3>
					</div>					
				</a>				
			</li>
			<? endforeach?>		
		</ul>
	</div>	
</div>
</div>
</body>
</html>
