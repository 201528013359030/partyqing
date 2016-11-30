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
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>
<?=Html::cssFile('@web/css/foundation.css')?>
<?=Html::cssFile('@web/css/foundation.min.css')?>
<?=Html::jsFile('@web/js/vendor/jquery.js')?>
<?=Html::jsFile('@web/js/foundation/foundation.js')?>
<?=Html::jsFile('@web/js/foundation/foundation.orbit.js')?>
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
.img2{display:inline-block;width:25%;margin-top:3px;margin-right:7px;}
.img1{vertical-align:bottom;height:65px;width:90px;}
.content{display:inline-block;vertical-align:top;width:70%;}
.word{display:inline-block;height:30px;font-size:1em;color:#262626;}
.word0{display:inline-block;font-size:10pt;color:#a6a6a6;}
.right0{ float:right;margin-top:3px;}
</style>
<script type="text/javascript">

var myScroll,
	pullDownEl, pullDownOffset,
	pullUpEl, pullUpOffset,
	generatedCount = 0;

function getLocalTime(nS) {   
// 	alert(nS);
	
	var date = new Date(nS*1000);
	Y = date.getFullYear() + '-';
	M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
	D = (date.getDate()+1 < 10 ? '0'+(date.getDate()+1) : date.getDate()+1)  + ' ';
	h =  (date.getHours()+1 < 10 ? '0'+(date.getHours()+1) : date.getHours()+1) + ':';
	m = (date.getMinutes()+1 < 10 ? '0'+(date.getMinutes()+1) : date.getMinutes()+1)  + ':';
	s =  (date.getSeconds()+1 < 10 ? '0'+(date.getSeconds()+1) : date.getSeconds()+1); 
// 	alert(Y+M+D+h+m+s);
	return Y+M+D+h+m+s;  
     
 }     
function pullDownAction () {
	location.reload();  
}
function pullUpAction () {
 	setTimeout(function () {	
		var el, iteam, i,pageSize;
		el = document.getElementById('listBox');

		$.get("index.php?r=admin/notice/getdata",{
		},function(data){
// 			alert(data);
 	 		//alert(JSON.stringify(data));	
			var list=eval(data);
			if(list.length){
				
				for (i=0; i<list.length; i++) {
// 					alert(list[i].title); 
					
					iteam = document.createElement('div');
					iteam.className = 'listIteam';
				
// 					var time=getLocalTime(list[i].time); 
					relation=list[i].relation;	 
				
       
                        iteam.innerHTML = "<a href='index.php?r=admin/noticecontent/index&f=1&id= class='listInner'><p class='listInfo'><span class='title'><i class='ficon ic_new'>NEW</i></span></p><p class='listInfo'><span class='date'></span></p><span class='tip ficon ic_arrow_right'></span></a>";

					el.appendChild(iteam, el.childNodes[0]);
				}
				myScroll.refresh();	 
			}else{                                 //没有更多数据
			    pullUpEl = document.getElementById('pullUp');
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '已没有更多数据...'; */
				//document.getElementById("sendSucceed").click();
			}
		},'json');	
	
		
		myScroll.refresh();		// 当内容完事儿，记得刷新(ie: on ajax completion)
	}, 1000);	
}

function loaded() {
	pullDownEl = document.getElementById('pullDown');
	pullDownOffset = pullDownEl.offsetHeight;
	pullUpEl = document.getElementById('pullUp');	
	pullUpOffset = pullUpEl.offsetHeight;
	
	myScroll = new iScroll('wrap', {
			useTransition: true,
		topOffset: pullDownOffset,
		onRefresh: function () {
			if (pullDownEl.className.match('loading')) {
				pullDownEl.className = '';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新页面...';
			} else if (pullUpEl.className.match('loading')) {
				pullUpEl.className = '';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
			}
		},
		onScrollMove: function () {
			if (this.y > 5 && !pullDownEl.className.match('flip')) {
				pullDownEl.className = 'flip';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '释放即可加载...';
				this.minScrollY = 0;
			} else if (this.y < 5 && pullDownEl.className.match('flip')) {
				pullDownEl.className = '';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新页面...';
				this.minScrollY = -pullDownOffset;
			} else if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
				pullUpEl.className = 'flip';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '释放即可加载...';
				this.maxScrollY = this.maxScrollY;
			} else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
				pullUpEl.className = '';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉即可加载...';
				this.maxScrollY = pullUpOffset;
			}
		},
		onScrollEnd: function () {
			if (pullDownEl.className.match('flip')) {
				pullDownEl.className = 'loading';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';				
				pullDownAction();	// 执行自定义函数（Ajax调用等）
			} else if (pullUpEl.className.match('flip')) {
				pullUpEl.className = 'loading';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';				
				pullUpAction();	// 执行自定义函数（Ajax调用等）
			}
		}
	});
	
setTimeout(function () { document.getElementById('wrap').style.left = '0'; }, 800);
}

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);

function allowFormsInIscroll(){
 [].slice.call(document.querySelectorAll('input, select, button')).forEach(function(el){
 el.addEventListener(('ontouchstart' in window)?'touchstart':'mousedown', function(e){
 e.stopPropagation();
 
 })
 })
 }
 document.addEventListener('DOMContentLoaded', allowFormsInIscroll, false);

 
</script>


</head>
<body>	
<div class="orbit-container">
<ul class="example-orbit-content" data-orbit >
  <li>
  <a href="index.php?r=admin/dongtai/index&id=1" >
   <img class="img0" src="../web/images/1.jpg" alt="slide 1" />    
  </a>    
  </li>
  <li class="active">
  <a  href="index.php?r=admin/dongtai/index&id=1" >
    <img class="img0" src="../web/images/2.jpg" alt="slide 2" />
  </a>   
  </li>
  <li>
  <a href="index.php?r=admin/dongtai/index&id=1" >
    <img class="img0" src="../web/images/3.jpg" alt="slide 3" />  
  </a> 
  </li>
</ul>
</div>
<div id="wrap" class="wrap">
<div id="scroller">
	<div id="pullDown">
		<span class="pullDownIcon"></span><span class="pullDownLabel">下拉即可加载...</span>
	</div>
<div class="contentbig">
  <a href="index.php?r=admin/dongtai/index&id=1">
    <div class="img2">
         <img class="img1" src="../web/images/2.jpg"/>
    </div>
    <div class="content">
        <span class="word">学习贯彻健康的角度讲等到开啊啊啊啊</span>
        <span class="word0">北京日报 </span>
        <span class="word0 right">2016-2-2</span>
    </div>
  </a>
</div>
<div class="contentbig">
<div class="img2">
<img class="img1" src="../web/images/2.jpg" alt="slide 2" />
</div>
<div class="content">
<span class="word">学习贯彻健康的角度讲等到开啊啊啊啊</span>
<span class="word0">北京日报 </span>
<span class="word0 right">2016-2-2</span>
</div>
</div>
<div id="pullUp">
		<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
</div>
</div>
</div>
<script type="text/javascript">
//图片切换js代码
$(document).foundation({
	  orbit: {
		  animation: 'slide',
		  timer_speed: 1500,
		  pause_on_hover: true,
		  animation_speed: 1500,
		  navigation_arrows: true,
		  bullets: true,
	      slide_number_text: '/',
	  }
	});

</script>
</body>
</html>




