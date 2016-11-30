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
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?=$content?></title>
<?=Html::cssFile('@web/css/announcemy.css')?>

</head>
<body >
<div id="wrap" class="wrap" style="background-color:#ededed">
	<div style="text-align:center;padding:40px 0px 20px 0px;">
			<img style="width:30%" src="../web/img/building.png">
				<div style="text-align:center;padding:25px 0px 20px 0px;font-weight:bold;color:#b2b2b2">此功能正在开发中...</div>				
    </div>
</div>
</body>
</html>

