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
<?=Html::cssFile('@web/css/lanrenzhijia.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap/js/bootstrap.js')?>
<?=Html::cssFile('@web/js/bootstrap/css/bootstrap.css')?>
<?=Html::cssFile('@web/js/bootstrap/css/bootstrap.min.css')?>
<?=Html::jsFile('@web/js/bootstrap/js/bootstrap.min.js')?>
<?=Html::jsFile('@web/js/bootstrap/js/Carousel.js')?>
<?=Html::jsFile('@web/js/hammer.min.js')?>
<?=Html::jsFile('@web/js/jquery.hammer.js')?>
<?//=Html::jsFile('http://eightmedia.github.io/hammer.js')?>
<?//=Html::jsFile('https://github.com/EightMedia/jquery.hammer.js')?>
<style>
.contentbig {
	padding: 10px 0px 10px 10px;
	border-bottom: 1px #d2d2d2 solid;
}

.img0 {
	width: 100%;
	height: 200px;
}

.img2 {
	display: inline-block;
	width: 25%;
	margin-top: 2px;
	margin-right: 7px;
	position: relative;
}

.img1 {
	vertical-align: bottom;
	height: 65px;
	width: 90px;
	z-index: 1;
}

.img3 {
	vertical-align: center;
	height: 30px;
	width: 30px;
	z-index: 10;
	opacity: 0.7;
	filter: alpha(opacity = 70)
}

.img5 {
	display: block;
	position: absolute;
	width: 100%;
	height: 100%;
	z-index: 100;
	top: 25%;
	left: 32%;
}

.content {
	display: inline-block;
	vertical-align: top;
	width: 70%;
}

.word {
	display: inline-block;
	height: 42px;
	width: 100%;
	font-size: 11pt;
	color: #262626;
	text-overflow: -o-ellipsis-lastline;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
}

.word0 {
	display: inline-block;
	font-size: 10pt;
	color: #a6a6a6;
}

.right0 {
	float: right;
	margin-top: 5px;
}

#pullUp {
	border-bottom: 0px solid #ccc;
}

#pullUp2 {
	border-bottom: 0px solid #ccc;
}

.listIteam .empty:before {
	top: 0px;;
}
</style>
<script type="text/javascript">

var myScroll,myScroll2,
	pullDownEl, pullDownOffset,
	pullDownEl2,pullUpEl2,
	pullUpEl, pullUpOffset,
	generatedCount = 0;
var index = 0; //tabs index

//下拉加载数据  模拟加载了几个死数据
function pullDownAction () {
	if(index == 0){
		myScroll.refresh();
	}else if(index == 1){
		myScroll2.refresh();
	}
}
function getLocalTime(nS) {   
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

function pullUpAction () {
		setTimeout(function () {	
		var el, iteam, i,pageSize;
		el = document.getElementById('listBox');
		//alert($("#searchtitle").val());
		$.get("index.php?r=admin/jiaoyulist/getdata",{searchcontent:$("#searchtitle").val()
		},function(data){
	 		//alert(JSON.stringify(data));	
			var list=eval(data);
			if(list.length){				
				for (i=0; i<list.length; i++) {
					iteam = document.createElement('div');
					iteam.className = 'contentbig';        
					 if(list[i].video=="1"){ 
						 var video="<div class='img5'><img class='img3' src='../web/img/play.png'/></div>";
					 }else{
						 var video="";
					 }   	
					iteam.innerHTML ="<a href='index.php?r=admin/jiaoyu/index&id="+list[i].id+"'><div class='img2'><img class='img1' src='"+list[i].pic+"'/>"+video+"</div><div class='content'><span class='word'>"+list[i].title+"</span><span class='word0'>"+list[i].sender+"</span><span class='word0 right0'>"+list[i].time+"</span></div></a>";						
					el.appendChild(iteam, el.childNodes[0]);
				}
				myScroll.refresh();	 
				myScroll2.refresh();
			}else{                                 //没有更多数据
				pullUpEl = document.getElementById('pullUp');
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '已没有更多数据...'; 
				pullUpEl2 = document.getElementById('pullUp2');
				pullUpEl2.querySelector('.pullUpLabel2').innerHTML = '已没有更多数据...';
			}    
		},'json');	
		myScroll.refresh();		// 当内容完事儿，记得刷新(ie: on ajax completion)
		myScroll2.refresh();		// 当内容完事儿，记得刷新(ie: on ajax completion)
	}, 1000);	

		
	
}

function loaded() {
	pullDownEl = document.getElementById('pullDown');
	pullDownOffset = pullDownEl.offsetHeight;
	pullUpEl = document.getElementById('pullUp');	
	pullUpOffset = pullUpEl.offsetHeight;

	pullDownEl2 = document.getElementById('pullDown2');
	pullDownOffset2 = pullDownEl2.offsetHeight;
	pullUpEl2 = document.getElementById('pullUp2');	
	pullUpOffset = pullUpEl2.offsetHeight;
	
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

	myScroll2 = new iScroll('wrap2', {
		useTransition: true,
	topOffset: pullDownOffset2,
	onRefresh: function () {
		if (pullDownEl2.className.match('loading')) {
			pullDownEl2.className = '';
			pullDownEl2.querySelector('.pullDownLabel2').innerHTML = '下拉刷新页面...';
		} else if (pullUpEl2.className.match('loading')) {
			pullUpEl2.className = '';
			pullUpEl2.querySelector('.pullUpLabel2').innerHTML = '上拉加载更多...';
		}
	},
	onScrollMove: function () {
		if (this.y > 5 && !pullDownEl2.className.match('flip')) {
			pullDownEl2.className = 'flip';
			pullDownEl2.querySelector('.pullDownLabel2').innerHTML = '释放即可加载...';
			this.minScrollY = 0;
		} else if (this.y < 5 && pullDownEl2.className.match('flip')) {
			pullDownEl2.className = '';
			pullDownEl2.querySelector('.pullDownLabel2').innerHTML = '下拉刷新页面...';
			this.minScrollY = -pullDownOffset2;
		} else if (this.y < (this.maxScrollY - 5) && !pullUpEl2.className.match('flip')) {
			pullUpEl2.className = 'flip';
			pullUpEl2.querySelector('.pullUpLabel2').innerHTML = '释放即可加载...';
			this.maxScrollY = this.maxScrollY;
		} else if (this.y > (this.maxScrollY + 5) && pullUpEl2.className.match('flip')) {
			pullUpEl2.className = '';
			pullUpEl2.querySelector('.pullUpLabel2').innerHTML = '上拉即可加载...';
			this.maxScrollY = pullUpOffset;
		}
	},
	onScrollEnd: function () {
		if (pullDownEl2.className.match('flip')) {
			pullDownEl2.className = 'loading';
			pullDownEl2.querySelector('.pullDownLabel2').innerHTML = '加载中...';	
			pullDownAction();	// 执行自定义函数（Ajax调用等）
		} else if (pullUpEl2.className.match('flip')) {
			pullUpEl2.className = 'loading';
			pullUpEl2.querySelector('.pullUpLabel2').innerHTML = '加载中...';				
			pullUpAction();	// 执行自定义函数（Ajax调用等）
		}
	}
});
	
setTimeout(function () { document.getElementById('wrap').style.left = '0'; }, 800);
setTimeout(function () { document.getElementById('wrap2').style.left = '0'; }, 800);
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
	height: 1.2em;
	padding-left: .4em;
	font-size: 1em;
	border: none;
	background: none;
	-webkit-appearance: none;
	box-sizing: content-box;
	-webkit-box-sizing: content-box;
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	-moz-tap-highlight-color: rgba(0, 0, 0, 0);
	tap-highlight-color: rgba(0, 0, 0, 0);
}

.carousel {
	position: relative;
	margin-bottom: 0px;
	line-height: 1;
}

.carousel-indicators {
	position: absolute;
	vertical-align: bottom;
	top: 90%;
	right: 45%;
	z-index: 5;
	list-style: none;
}
</style>

	<div class="wraps">
		<div class="tabs">
			<a href="#" hidefocus="true" class="active">全部课程</a>
			<a href="#" hidefocus="true">我的课程</a>
		</div>
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<div class="content-slide">

						<div id="wrap" class="wrap">
							<div id="scroller">
								<div id="pullDown">
									<span class="pullDownIcon"></span><span class="pullDownLabel">下拉即可加载...</span>
								</div>
								<div class="moBox" id="searchBox">
									<div class="searchBox">
										<div class="searchInner">
											<input id="searchtitle" class="inpSearch"
												style="border: none; background: none; -webkit-appearance: none; box-shadow: none;"
												name="searchtitle" value="" type="text"
												placeholder="输入搜索关键字" /> 
												<a href="javascript:void(0);" class="ficon ic_search" id="search"></a>
										</div>
									</div>
								</div>
								<div id="myCarousel" class="carousel slide">
									<!-- 轮播（Carousel）指标 -->
									<ol class="carousel-indicators">
                      <?php if($counttop=="0"||$counttop=="1"):?>
                      <?php elseif($counttop=="2"):?>
                        <li data-target="#myCarousel" data-slide-to="0"
											class="active"></li>
										<li data-target="#myCarousel" data-slide-to="1"></li>
                      <?php elseif($counttop=="3"):?> 
                         <li data-target="#myCarousel" data-slide-to="0"
											class="active"></li>
										<li data-target="#myCarousel" data-slide-to="1"></li>
										<li data-target="#myCarousel" data-slide-to="2"></li>
                      <?endif?>   
                      </ol>
									<!-- 轮播（Carousel）项目 -->
									<div class="carousel-inner">      
                        			<?php foreach ($listtop as $key=>$value):?>
                       				 <?php if($value['id']==""):?>
                       					 <div class="item active">
											<img class="img0" src="<?=$value['pic']?>" alt="slide">
										 </div>
                       				 <?else:?>
                        			<?php if($key==0):?>
                         				 <div class="item active">
                        			   <?else:?>
                           					<div class="item">
                       
                                	<?endif; ?>                        
                                				<a href="index.php?r=admin/jiaoyu/index&id=<?=$value['id']?>"><img
													class="img0" src="<?=$value['pic']?>" alt="slide"></a>
											</div>
                       			  <?endif?>    
                      			<? endforeach?>  
									</div>
									<div class="moBox">
										<div id="listBox" class="listBox">
											<div class="listIteam" id="empty">
												<div class="empty">暂无</div>
											</div>			
                             			<?php foreach ($list as $key=>$value): ?>
                           					<div class="contentbig">
												<a href="index.php?r=admin/jiaoyu/index&id=<?=$value['id']?>">
													<div class="img2">
														<img class="img1" src="<?=$value['pic']?>" />
                               						<?php if($value['video']=="1"):?>
                               							<div class="img5">
															<img class="img3" src="../web/img/play.png" />
														</div>
                               			<?endif?>
                          							</div>
													<div class="content">
														<span class="word"><?=$value['title']?></span> <span
															class="word0"><?=$value['sender']?> </span> <span
															class="word0 right0"><?=$value['time']?></span>
													</div>
												</a>
											</div>
                         		<? endforeach?>
		                				</div>
									</div>
									<div id="pullUp">
										<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
									</div>
									<input type="hidden" id="count" value=<?=$count?>>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="content-slide">
						<div id="wrap2" class="wrap2">
							<div id="scroller">
								<div id="pullDown2">
									<span class="pullDownIcon2"></span><span class="pullDownLabel2">下拉即可加载...</span>
								</div>
								<div class="moBox" id="searchBox">
									<div class="searchBox">
										<div class="searchInner">
											<input id="searchtitle" class="inpSearch"
												style="border: none; background: none; -webkit-appearance: none; box-shadow: none;"
												name="searchtitle" value="" type="text"
												placeholder="输入搜索关键字" /> 
												<a href="javascript:void(0);" class="ficon ic_search" id="search"></a>
										</div>
									</div>
								</div>
								<div id="myCarousel" class="carousel slide">
									<!-- 轮播（Carousel）指标 -->
									<ol class="carousel-indicators">
                      <?php if($mycounttop=="0"||$mycounttop=="1"):?>
                      <?php elseif($mycounttop=="2"):?>
                        <li data-target="#myCarousel" data-slide-to="0"
											class="active"></li>
										<li data-target="#myCarousel" data-slide-to="1"></li>
                      <?php elseif($mycounttop=="3"):?> 
                         <li data-target="#myCarousel" data-slide-to="0"
											class="active"></li>
										<li data-target="#myCarousel" data-slide-to="1"></li>
										<li data-target="#myCarousel" data-slide-to="2"></li>
                      <?endif?>   
                      </ol>
									<!-- 轮播（Carousel）项目 -->
									<div class="carousel-inner">      
                        			<?php foreach ($mylisttop as $key=>$value):?>
                       				 <?php if($value['id']==""):?>
                       					 <div class="item active">
											<img class="img0" src="<?=$value['pic']?>" alt="slide">
										 </div>
                       				 <?else:?>
                        			<?php if($key==0):?>
                         				 <div class="item active">
                        			   <?else:?>
                           					<div class="item">
                       
                                	<?endif; ?>                        
                                				<a href="index.php?r=admin/jiaoyu/index&id=<?=$value['id']?>"><img
													class="img0" src="<?=$value['pic']?>" alt="slide"></a>
											</div>
                       			  <?endif?>    
                      			<? endforeach?>  
									</div>
									<div class="moBox">
										<div id="listBox" class="listBox">
											<div class="listIteam" id="empty2">
												<div class="empty2">暂无</div>
											</div>			
                             			<?php foreach ($mylist as $key=>$value): ?>
                           					<div class="contentbig">
												<a href="index.php?r=admin/jiaoyu/index&id=<?=$value['id']?>">
													<div class="img2">
														<img class="img1" src="<?=$value['pic']?>" />
                               						<?php if($value['video']=="1"):?>
                               							<div class="img5">
															<img class="img3" src="../web/img/play.png" />
														</div>
                               			<?endif?>
                          							</div>
													<div class="content">
														<span class="word"><?=$value['title']?></span> <span
															class="word0"><?=$value['sender']?> </span> <span
															class="word0 right0"><?=$value['time']?></span>
													</div>
												</a>
											</div>
                         		<? endforeach?>
		                				</div>
									</div>
									<div id="pullUp2">
										<span class="pullUpIcon2"></span><span class="pullUpLabel2">上拉加载更多...</span>
									</div>
									<input type="hidden" id="count" value=<?=$mycount?>>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<script src="http://www.lanrenzhijia.com/ajaxjs/jquery-1.10.1.min.js"></script>
	<script
		src="http://www.lanrenzhijia.com/ajaxjs/idangerous.swiper.min.js"></script>
	<script>
var tabsSwiper = new Swiper('.swiper-container',{
	speed:500,
	onSlideChangeStart: function(){
		$(".tabs .active").removeClass('active');
		$(".tabs a").eq(tabsSwiper.activeIndex).addClass('active');
	}
});

$(".tabs a").on('touchstart mousedown',function(e){
	e.preventDefault()
	$(".tabs .active").removeClass('active');
	$(this).addClass('active');
	index = $(this).index();
	tabsSwiper.swipeTo(index);
});

$(".tabs a").click(function(e){
	e.preventDefault();
});
</script>


</body>
</html>
<script type="text/javascript">
$(function(){
	 var count=$("#count").val();
	    //alert(count);
	    if(count==0){
	        $("#empty").show();
	        $("#empty2").show();
	        $("#myCarousel").hide();
	    }else{
	    	$("#empty").hide();
	    	$("#empty2").hide();
	    }
		if(count*1>2){
			$("#pullUp").show();
			$("#pullUp2").show();
		}else{
			$("#pullUp").hide();
			$("#pullUp2").hide();
		}
	$("#myCarousel").carousel('cycle');	 
 });
$('#myCarousel').hammer().on('swipeleft', function(){
  $(this).carousel('next');
 });
$('#myCarousel').hammer().on('swiperight', function(){
  $(this).carousel('prev');
 });

document.getElementById('searchtitle').addEventListener('input', function(e){
//     var value = e.target.value;
	//alert("3355");
	$.get("index.php?r=admin/jiaoyulist/search",{searchtitle:$("#searchtitle").val()
	},function(data){
	    //alert(JSON.stringify(data));
		var list=eval(data);
		//var relation;
		$("#listBox").empty();	
		if(list.length){           //如果获得了数据			
			for (i=0; i<list.length; i++) {
				iteam = document.createElement('div');
				iteam.className = 'contentbig';	
				 if(list[i].video=="1"){ 
					 var video="<div class='img5'><img class='img3' src='../web/img/play.png'/></div>";
				 }else{
					 var video="";
				 } 	
			    iteam.innerHTML ="<a href='index.php?r=admin/jiaoyu/index&id="+list[i].id+"'><div class='img2'><img class='img1' src='"+list[i].pic+"'/>"+video+"</div><div class='content'><span class='word'>"+list[i].title+"</span><span class='word0'>"+list[i].sender+"</span><span class='word0 right0'>"+list[i].time+"</span></div></a>";							
				$("#listBox").append(iteam);					
				}
		}else{              //如果没有数据，提示空
// 			alert(123);
			iteam = document.createElement('div');
			iteam.className = 'listIteam';			
			iteam.innerHTML = '<div class="empty">暂无</div>';				
//				$("#listBox").empty();
// 			$("#pullUp").hide();
			$("#listBox").append(iteam);
//				alert("fail");
		}
	},'json');
});

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
$("#searchtitle").keyup(function(){
 	//alert(123);
});
	$("div[id^='contentlist']").each(function(){
	    $(this).click(function(){    
	      	var imgid = $(this).attr("id");
	        var  imgidlist=imgid.split("_");
	        $(this).find("i[id^=icon_new]").hide();

	    })
	 });
</script>
