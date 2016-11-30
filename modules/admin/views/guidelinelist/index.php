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
<title><?=$name?></title>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>
<style>
.listInner {
display: block;
position: relative;
border-bottom: 1px #d0d0d0 solid;
}
</style>
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
			$.get("index.php?r=admin/guidelinelist/getdata",{id:$("#id").val(),searchcontent:$("#searchtitle").val()
		},function(data){
	 		//alert(JSON.stringify(data));	
			var list=eval(data);
			if(list.length){
				
				for (i=0; i<list.length; i++) {

					iteam = document.createElement('div');
					iteam.className = 'listIteam';
            	
                    iteam.innerHTML = "<a href='index.php?r=admin/guidelinedetail/index&id="+list[i].No+"' class='listInner'><p class='listInfo'><span class='title'>"+list[i].title+"</span></p><p class='listInfo'><span class='date'>"+list[i].createtime+"</span></p></a>";
					
					el.appendChild(iteam, el.childNodes[0]);
				}
				myScroll.refresh();	 
			}else{                                 //没有更多数据
				//document.getElementById("sendSucceed").click();
				$("#pullUp").hide();
				$("#nomore").remove();
				iteam = document.createElement('div');
				iteam.className = 'listIteam';  					                  
				iteam.id = 'nomore';                 
    		   //iteam.innerHTML = "<a href='#' class='listInner'><p class='listInfo' ><span class='box2'>没有更多数据！</span></p></a>";
    		   iteam.innerHTML = "<span style='display:block;text-align:center;margin-top:20px'>没有更多数据！</span>";
          		
			   el.appendChild(iteam, el.childNodes[0]);
// 				alert("已经没有更多数据");
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
<style>

</style>
<div id="wrap" class="wrap">
<div id="scroller">
	<div id="pullDown">
		<span class="pullDownIcon"></span><span class="pullDownLabel">下拉即可加载...</span>
	</div>
   <div class="moBox" id="searchBox">
		<div class="searchBox">
			<div class="searchInner">
			<input id="searchtitle" class="inpSearch" name="searchtitle" value="" type="text" placeholder="输入搜索关键字">			
			<a href="javascript:void(0);" class="ficon ic_search" id="search"></a>			
			</div>
		</div>		
	</div>
 <div class="moBox">
		<div id="listBox" class="listBox">
			<div class="listIteam" id="empty">
				<div class="empty">暂无</div>
			</div>
			<?php foreach ($list as $key=>$value): ?>
			<div class="listIteam"  id="contentlist_">
		        <a href="index.php?r=admin/guidelinedetail/index&id=<?=$value['No']?>" class="listInner">  				
					<p class="listInfo">					
                    <span class="title">      
                    <?=$value['title']?></span>
					</p>	
					<p class="listInfo">
						<span class="date"><?=$value['createtime']?></span>	
					</p>																		
				</a>
			</div>
			<? endforeach?>
		</div>
	</div>
	<div id="pullUp">
		<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
	</div>
	<input type="hidden" id="count" value=<?=$count?>>
	<input type="hidden" id="id" value=<?=$id?>>
</div>
</div>
<a id="sendSucceed" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#sendModal" style="display:none">
</a>

<div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
	<div class="modal-dialog" style='z-index:1060'>
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="uploadModalLabel">
				</h4>
			</div>
			<div class="modal-body">
				<div style="text-align: center;">
                   已经没有更多数据！
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="">确定
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
</body>
</html>
<script type="text/javascript">
document.getElementById('searchtitle').addEventListener('input', function(e){
//     var value = e.target.value;
	//alert("3355");
	$.get("index.php?r=admin/guidelinelist/search",{searchtitle:$("#searchtitle").val(),id:$("#id").val()
	},function(data){
		//alert("55");
	    //alert(JSON.stringify(data));
		var list=eval(data);
		//var relation;
		$("#listBox").empty();	
		if(list.length){           //如果获得了数据			
			for (i=0; i<list.length; i++) {
				iteam = document.createElement('div');
				iteam.className = 'listIteam';		
				//relation=list[i].relation;	
				//var time=getLocalTime(list[i].CreateTime); 
				//var time=list[i].PublicTime; 
//					alert(relation);	
	
			     iteam.innerHTML = "<a href='index.php?r=admin/guidelinedetail/index&id="+list[i].No+"' class='listInner'><p class='listInfo'><span class='title'>"+list[i].title+"</span></p><p class='listInfo'><span class='date'>"+list[i].createtime+"</span></p></a>";
					
				$("#listBox").append(iteam);					
				}
			myScroll.refresh();
		}else{              //如果没有数据，提示空
// 			alert(123);
			iteam = document.createElement('div');
			iteam.className = 'listIteam';			
			iteam.innerHTML = '<div class="empty">暂无</div>';				
//				$("#listBox").empty();
// 			$("#pullUp").hide();
			$("#listBox").append(iteam);
			myScroll.refresh();
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
$(function(){
	//$("#searchtitle").val("");	
    var count=$("#count").val();
    //alert(count);
    if(count==0){
        $("#empty").show();
    }else{
    	$("#empty").hide();
    }	
	if(count*1>10){
		$("#pullUp").show();
	}else{
		$("#pullUp").hide();
	}
});
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