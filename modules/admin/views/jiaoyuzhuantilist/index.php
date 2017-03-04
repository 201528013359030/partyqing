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
<title>警示教育专题</title>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap/js/bootstrap.js')?>
<?=Html::cssFile('@web/js/bootstrap/css/bootstrap.css')?>
<?=Html::cssFile('@web/js/bootstrap/css/bootstrap.min.css')?>
<?=Html::jsFile('@web/js/bootstrap/js/bootstrap.min.js')?>
<?=Html::jsFile('@web/js/bootstrap/js/Carousel.js')?>
<?=Html::jsFile('@web/js/hammer.min.js')?>
<?=Html::jsFile('@web/js/jquery.hammer.js')?>
<?=Html::cssFile('@web/css/piccut.css')?>
<?//=Html::jsFile('http://eightmedia.github.io/hammer.js')?>
<?//=Html::jsFile('https://github.com/EightMedia/jquery.hammer.js')?>
<script type="text/javascript">

var myScroll,
	pullDownEl, pullDownOffset,
	pullUpEl, pullUpOffset,
	generatedCount = 0;

//下拉加载数据  模拟加载了几个死数据
function pullDownAction () {
	location.reload();
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
			$.get("index.php?r=admin/jiaoyuzhuantilist/getdata",{searchcontent:$("#searchtitle").val()
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
					 if(list[i].pic2=="1"){
						 var pic="<img style='height:100%' src='"+list[i].pic+"'/>";
					 }else{
						 var pic="<img style='width:100%' src='"+list[i].pic+"'/>";;
					 }
					iteam.innerHTML ="<a href='index.php?r=admin/jiaoyulist/index&zhuantiid="+list[i].id+"'><div class='img2 frame-square0'> <div class='crop0'>"+pic+"</div>"+video+"</div><div class='content0'><span class='word'>"+list[i].title+"</span><span class='word0'>"+list[i].time+"</span><span class='word0'>"+list[i].sender+"</span></div><a href='index.php?r=admin/jiaoyutop/index&topic="+list[i].id+"' class='button0'><span style='display:inline-block;margin-top:4px;font-size:10pt'>排行榜</span></a></a>";
					el.appendChild(iteam, el.childNodes[0]);
				}
				myScroll.refresh();
			}else{                                 //没有更多数据
				pullUpEl = document.getElementById('pullUp');
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '已没有更多数据...';
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
<style>
.content0 {
display: inline-block;
vertical-align: top;
width: 45%;
}
.button0{
display:inline-block;
vertical-align:top;
color:#ffacad;
height:30px;
width:20%;
margin:20px 0px 0px 0px;
background-color:#fff;
text-align:center;
border-style:solid;
border-color:#ffacad;
border-width:2px;
border-radius:10px;
}
</style>
</head>
<body>
<script>
    window.open    = function(){};
    window.print   = function(){};
    // Support hover state for mobile.
    if (false) {
      window.ontouchstart = function(){};
    }

    function __linkClick(e) {
      parent.window.postMessage(this.href, '*');
    };

    function __bindToLinks() {
      var __links = document.querySelectorAll('a');
      for (var i = 0, l = __links.length; i < l; i++) {
        if ( __links[i].getAttribute('data-t') == '_blank' ) {
          __links[i].addEventListener('click', __linkClick, false);
        }
      }
    }
</script>
<div id="wrap" class="wrap">
<div id="scroller">
	<div id="pullDown">
		<span class="pullDownIcon"></span><span class="pullDownLabel">下拉即可加载...</span>
	</div>
   <div class="moBox" id="searchBox">
		<div class="searchBox">
			<div class="searchInner">
			<input id="searchtitle" class="inpSearch" style="border: none;background: none;-webkit-appearance: none;box-shadow: none;" name="searchtitle" value="" type="text" placeholder="输入搜索关键字">
			<a href="javascript:void(0);" class="ficon ic_search" id="search"></a>
			</div>
		</div>
	</div>
<div id="myCarousel" class="carousel slide">
   <!-- 轮播（Carousel）指标 -->
   <ol class="carousel-indicators">
    <?php if($counttop=="0"||$counttop=="1"):?>
    <?php elseif($counttop=="2"):?>
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
    <?php elseif($counttop=="3"):?>
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    <?endif?>
   </ol>
   <!-- 轮播（Carousel）项目 -->
   <div class="carousel-inner">
  <?php foreach ($listtop as $key=>$value):?>
  <?php if($value['id']==""):?>
   <div class="item active frame-square"><div class="crop">
   <?php if($value['pic2']=="1"):?>
   <img style="height:100%" src="<?=$value['pic']?>" alt="slide">
   <?php else:?>
   <img style="width:100%"  src="<?=$value['pic']?>" alt="slide">
   <?endif?>

   </div></div>
  <?else:?>
  <?php if($key==0):?>
      <div class="item active frame-square">
      <?else:?>
      <div class="item frame-square">
      <?endif?>
     <a href="index.php?r=admin/jiaoyulist/index&zhuantiid=<?=$value['id']?>">
     <div class="crop">
      <?php if($value['pic2']=="1"):?>
      <img style="height:100%" src="<?=$value['pic']?>" alt="slide">
      <?php else:?>
      <img  src="<?=$value['pic']?>" alt="slide">
      <?endif?>
      <div class="banner"><?=$value['title']?></div>
      </div>
     </a>
      </div>
  <?endif?>
  <? endforeach?>
   </div>
</div>
 <div class="moBox">
		<div id="listBox" class="listBox">
			<div class="listIteam" id="empty">
				<div class="empty">暂无</div>
			</div>
<?php foreach ($list as $key=>$value): ?>
<div class="contentbig">
  <a href="index.php?r=admin/jiaoyulist/index&zhuantiid=<?=$value['id']?>" >
    <div class="img2 frame-square0">
    <div class="crop0">
    <?php if($value['pic2']=="1"):?>
    <img style="height:100%" src="<?=$value['pic']?>"/>
    <?php else:?>
    <img style="width:100%"  src="<?=$value['pic']?>">
    <?endif?>
    </div>
          <?php if($value['video']=="1"):?>
          <div class="img5"><img class="img3" src="../web/img/play.png"/></div>
          <?endif?>
    </div>
    <div class="content0">
        <span class="word"><?=$value['title']?></span>
        <span class="word0 "><?=$value['time']?></span>
        <span class="word0"><?=$value['sender']?> </span>
    </div>
    <a href="index.php?r=admin/jiaoyutop/index&topic=<?=$value['id']?>" class="button0"><span style="display:inline-block;margin-top:4px;font-size:10pt">排行榜</span></a>
  </a>
</div>
<? endforeach?>
		</div>
	</div>
	<div id="pullUp">
		<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
	</div>
	<input type="hidden" id="count" value=<?=$count?>>
	<input type="hidden" id="counttop" value=<?=$counttop?>>
</div>
</div>
</body>
</html>
<script type="text/javascript">
$(function(){
	 var count=$("#count").val();
	 var counttop=$("#counttop").val();
	    //alert(count);
	    if(count==0){
	        $("#empty").show();

	    }else{
	    	$("#empty").hide();
	    }
		if(count*1>2){
			$("#pullUp").show();
		}else{
			$("#pullUp").hide();
		}
		if(counttop==0){
		    $("#myCarousel").hide();
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
	$.get("index.php?r=admin/jiaoyuzhuantilist/search",{searchtitle:$("#searchtitle").val()
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
				 if(list[i].pic2=="1"){
					 var pic="<img style='height:100%' src='"+list[i].pic+"'/>";
				 }else{
					 var pic="<img style='width:100%' src='"+list[i].pic+"'/>";;
				 }
			    iteam.innerHTML ="<a href='index.php?r=admin/jiaoyulist/index&zhuantiid="+list[i].id+"'><div class='img2 frame-square0'> <div class='crop0'>"+pic+"</div>"+video+"</div><div class='content0'><span class='word'>"+list[i].title+"</span><span class='word0'>"+list[i].time+"</span><span class='word0'>"+list[i].sender+"</span></div><a href='index.php?r=admin/jiaoyutop/index&topic="+list[i].id+"' class='button0'><span style='display:inline-block;margin-top:4px;font-size:10pt'>排行榜</span></a></a>";
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
	myScroll.refresh();
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
