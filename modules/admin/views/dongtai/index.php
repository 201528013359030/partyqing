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
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta content="telephone=no" name="format-detection" />
<title>纪检动态</title>
<?=Html::cssFile('@web/css/announce.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/jquery-1.11.2.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>
<?=Html::jsFile('@web/js/htmlset.js')?>
<style>
.btnBox .btnCheck {
background-color: #30BF78;
width: 36%;
margin-right: 8px;
}
.btnBox .active {
background-color: #f2f2f2;
color: #444;
}
</style>
</head>
<body>
	
<div id="wrap" class="wrap">
	<div class="moGrid">		
		<div class="header">							                          
			<h1><?=$content['title']?></h1>
			<p class="lead">                
                <span class="fr corFocus">
                    <i class="ficon ic_eye"></i>
                        <?=$content['readd']?>
                </span>
				<span class="fl corDate"><?=$content['time']?></span> <span class="fl corFocus"><?=$content['sender']?></span>
			</p>
		</div>
	</div>
	<div class="moGrid">	
		<div class="content">
			<!-- <p>				
				<img src="images/temp1.jpg">
			</p> -->
			<p>			
			<?=$content['content']?>
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
<script>
var xx=document.getElementsByName('divvideocontent');
if(xx.length>0){
for(i=0;i<=xx.length;i++){	
var width = document.getElementsByName('divvideocontent')[i].offsetWidth;	

document.getElementsByName('divvideocontent')[i].style.height=parseInt(width)/4*3+'px';
} 
}
</script>   
</body>
</html>




