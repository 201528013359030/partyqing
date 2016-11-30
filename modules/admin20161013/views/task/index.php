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
<title>我的责任</title>
<style>
body{
margin:0 auto;
background-color:#F2F2F2;
}
.left{
display:inline-block;
margin:0 auto;
float:left;
width:49.8%;
background-color:#fff;	
text-align:center;	
}
.right{
display:inline-block;
float:right;
width:49.8%;
background-color:#fff;	
text-align:center;	
}
a img{
margin:10px 0 10px 0;
width:50%;
}
</style>
</head>
<body>
<div>	
<img style="width:100%" src="../web/img/banner.jpg">
</div>
<div>
<a class="left "href="index.php?r=admin/mytask/index&s=1&uid=<?=$uid?>"><img src="../web/img/my_task.png"></a>
<a class="right "href="index.php?r=admin/taskcheck/index&s=1&uid=<?=$uid?>"><img src="../web/img/my_review.png"></a>
</div>
</body>
</html>
