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
<title>廉政教育</title>
<?//=Html::cssFile('@web/css/announcemy.css')?>
<?//=Html::cssFile('@web/css/bootstrapmy.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap/js/bootstrap.js')?>

<?=Html::cssFile('@web/js/bootstrap/css/bootstrap.min.css')?>
<?=Html::jsFile('@web/js/bootstrap/js/bootstrap.min.js')?>
<?=Html::jsFile('@web/js/bootstrap/js/Carousel.js')?>
<style>
.orbit-container .orbit-slide-number {
position: absolute;
top: 180px;
text-align:center;
font-size: 12px;
color: #000;
background: transparent;
z-index: 10;
}
.contentbig{padding:10px 0px 10px 10px;border-bottom:1px #d2d2d2 solid;}
.img0{width:100%;height:200px;}
.img2{display:inline-block;width:25%;margin-top:2px;margin-right:7px;position:relative;}
.img1{vertical-align:bottom;height:65px;width:90px;z-index:1;}
.img3{vertical-align:center;height:30px;width:30px;z-index:10;opacity:0.7;filter:alpha(opacity=70)}
.img5{display:block;position:absolute;width:100%;height:100%;z-index:100;top:25%;left:32%;}

.content{display:inline-block;vertical-align:top;width:70%;}
.word{display:inline-block;height:43px;width:100%;font-size:1em;color:#262626;text-overflow: -o-ellipsis-lastline;  
overflow: hidden;  
text-overflow: ellipsis;  
display: -webkit-box;  
-webkit-line-clamp: 2;  
-webkit-box-orient: vertical;}
.word0{display:inline-block;font-size:10pt;color:#a6a6a6;}
.right0{ float:right;margin-top:5px;}
#pullUp {
border-bottom: 0px solid #ccc;
}
</style>

</head>
<body>
<style>
.searchBox .ficon {
float: right;
width: 16%;
height: 1.875em;
line-height: 1.875;
text-align: center;
color: #999;
}
.searchBox .inpSearch {
float: left;
display: inline-block;
vertical-align: top;
width: 78%;
height: 0.6em;
padding-left: .4em;
font-size: 1em;
border: none;
background: none;
-webkit-appearance: none;
box-sizing: content-box;
-webkit-box-sizing: content-box;
-webkit-tap-highlight-color: rgba(0,0,0,0);
-moz-tap-highlight-color: rgba(0,0,0,0);
tap-highlight-color: rgba(0,0,0,0);
}
.orbit-bullets-container {
text-align: center;
z-index:100;
position:absolute;
bottom:5px;
left:45%;
}
.orbit-bullets {
margin: 0px 0px 0px 0px;
overflow: hidden;
position: relative;
float: none;
top:10px;
text-align: center;
display: inline-block;
}
</style>
<div id="myCarousel" class="carousel slide">
   <!-- 轮播（Carousel）指标 -->
   <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
   </ol>   
   <!-- 轮播（Carousel）项目 -->
   <div class="carousel-inner">      
  <?//php foreach ($listtop as $key=>$value): ?>
      <div class="item active">
         <img class="img0" src="../web/images/1.jpg" alt="Third slide">
      </div>
      <div class="item">
         <img class="img0" src="../web/images/2.jpg" alt="Third slide">
      </div>
      <div class="item">
         <img class="img0" src="../web/images/3.jpg" alt="Third slide">
      </div>
  <?// endforeach?>  
   </div>
   <!-- 轮播（Carousel）导航 -->
   <a class="carousel-control left" href="#myCarousel" 
      data-slide="prev">&lsaquo;</a>
   <a class="carousel-control right" href="#myCarousel" 
      data-slide="next">&rsaquo;</a>
</div> 

</body>
</html>
<script type="text/javascript">
$(function(){
	$("#myCarousel").carousel('cycle');
 });

</script>
