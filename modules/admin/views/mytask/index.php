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
<title>任务清单</title>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
<?=Html::cssFile('@web/css/mytask_undo.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>
<style>
body{
margin:0 auto;
background-color:#F2F2F2;
}
.left{
display:inline-block;
float:left;
height:50px;
width:49.9%;
background-color:#fff;	
text-align:center;
border-style:solid;
border-color:#ffacad;
border-width:1px;
border-radius:5px;		
}
.right{
display:inline-block;
float:right;
width:49.9%;
height:50px;	
background-color:#fff;	
text-align:center;	
border-style:solid;
border-color:#ffacad;
border-width:1px;
border-radius:5px;
}
.wordl{
display:inline-block;	
margin-top:13px;
color:#ffacad;
font-weight:bold;
}
.wordr{
display:inline-block;	
margin-top:13px;
color:#ffacad;
font-weight:bold;	
}
.bc{background-color:#ffacad;	}
.wc{color:#fff;}
.righttip{
display:inline-block;
width:60px;
float:right;
margin-right:10px;
color:#fff;
border-radius:5px;	
text-align:center;
font-size:10pt;	
vetical-align:center;
}
.righttip.color0{
background-color:#f57c00;
}
.righttip.color1{
background-color:#e9e19c;
}
.righttip.color2{
background-color:#8AE58D;
}
.righttip.color3{
background-color:#ce2124;
}
.righttip.color5{
background-color:#626AFD;
}
.listInner .tip0 {
position: absolute;
width: 30px;
height: 40px;
top: 30%;
left: 10px;
color: #dedede;
/* font-size: 40px; */
overflow: hidden;
margin-top: -20px;
font-size: 20px;
line-height: 40px;
}
.listInfo .title {
display: inline-block;
vertical-align: top;
font-size: 1.125em;
line-height: 1.125;
max-height: 2.3em;
overflow: hidden;
color: #444;
width: 95%;
}
</style>
<script type="text/javascript">
var myScroll,
	pullDownEl, pullDownOffset,
	pullUpEl, pullUpOffset,
	generatedCount = 0;
var myDate = new Date();
var now= myDate.getFullYear()+'-'+(myDate.getMonth()+1 < 10 ? '0'+(myDate.getMonth()+1) : myDate.getMonth()+1)+'-'+ (myDate.getDate() < 10 ? '0'+(myDate.getDate()) :myDate.getDate());  

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
		var s=$("#s").val();
			$.get("index.php?r=admin/mytask/getdata",{s:$("#s").val()
		},function(data){
			//alert(333);
	 		//alert(JSON.stringify(data));	
			var list=eval(data);
			if(list.length){				
				for (i=0; i<list.length; i++) {
					iteam = document.createElement('div');
					iteam.className = 'listIteam';
				if(list[i].editflag=="0"||list[i].editflag=="2"){
                    if(list[i].taskstate=="0"){
                       comment="<span class='righttip color0'>未提交</span>"; 
                       url="<a href='index.php?r=admin/taskdetail/index&id="+list[i].taskId+"' class='listInner'>";
                    }else if(list[i].taskstate=="1"){
                       comment="<span class='righttip color1'>审核中</span>"; 
                       url="<a href='index.php?r=admin/taskdetailed/index&id="+list[i].taskId+"' class='listInner'>";
                    }else if(list[i].taskstate=="2"&&list[i].approverId==""){
                       comment="<span class='righttip color2'>已完成</span>"; 
                       url="<a href='index.php?r=admin/taskdetailed/index&id="+list[i].taskId+"' class='listInner'>";
                    }else if(list[i].taskstate=="2"){
                        comment="<span class='righttip color2'>已通过</span>"; 
                        url="<a href='index.php?r=admin/taskdetailed/index&id="+list[i].taskId+"' class='listInner'>";
                   }else if(list[i].taskstate=="3"){
                       comment="<span class='righttip color3'>未通过</span>"; 
                       url="<a href='index.php?r=admin/taskalter/index&id="+list[i].taskId+"' class='listInner'>";
                    }else{
                       comment ="";  
                       url="";                                                                                                         
                    }	
                 }else if(list[i].editflag=="1"){  
             	    comment="<span class='righttip color5'>待修改</span>"; 
                    url="<a href='index.php?r=admin/taskalter/index&id="+list[i].taskId+"' class='listInner'>";
                 }                  
                    //console.log(now);  
                    //console.log(list[i].endtime); 
                    if(list[i].endtime<now & s=="1"){
                        time0="<span style='color:red'>"+list[i].starttime+"至"+list[i].endtime+"</span>"; 
                     }else{
                    	time0=list[i].starttime+"至"+list[i].endtime;  
                     }
                    if(list[i].assign=="1"){
                        zp="<span class='icon_yizhipai'></span>	"; 
                     }else{
                    	zp="";  
                     }
                  iteam.innerHTML =zp+url+"<p class='listInfo'><span class='title'><img src='../web/img/sanjiao.png' style='height:12px;margin-bottom:3px;'>"+list[i].content+"</span></p><p class='listInfo'><span class='date'>考核日期："+time0+"</span>"+comment+"</p></a>";
					
					el.appendChild(iteam, el.childNodes[0]);
				}
				myScroll.refresh();	 
			}else{                                 //没有更多数据
				//document.getElementById("sendSucceed").click();
// 				alert("已经没有更多数据");
				$("#pullUp").hide();
				$("#nomore").remove();
				iteam = document.createElement('div');
				iteam.className = 'listIteam';  					                  
				iteam.id = 'nomore';                 
    		   //iteam.innerHTML = "<a href='#' class='listInner'><p class='listInfo' ><span class='box2'>没有更多数据！</span></p></a>";
    		   iteam.innerHTML = "<span style='display:block;text-align:center;margin-top:20px'>没有更多数据！</span>";
          		
			   el.appendChild(iteam, el.childNodes[0]);
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
<a class="left" id="left1" href="javascript:void(0);"><span id="left2" class="wordl">未完成</span></a>
<a class="right" id="right1" href="javascript:void(0);"><span id="right2" class="wordr">已完成</span></a>
<div id="wrap" class="wrap">
<div id="scroller">
	<div id="pullDown" style="background-color:#eeeeee" >
		<span class="pullDownIcon"></span><span class="pullDownLabel">下拉即可加载...</span>
	</div>
	<div class="moBox">
		<div id="listBox" class="listBox">
			<div class="listIteam" id="empty">
				<div class="empty">暂无</div>
			</div>
			
			<?php foreach ($list as $key=>$value): ?>
			<div class="listIteam"  id="contentlist_">
			 <?php if($value['assign']=="1"):?> 
			<span class="icon_yizhipai"></span>	
			<?endif?>
			<?php if($value['editflag']=="0"||$value['editflag']=="2"):?> 
		          <?php if($value['taskstate']=="0"):?> 
				  <a href="index.php?r=admin/taskdetail/index&id=<?=$value['taskId']?>" class="listInner">  								 
				  <?php elseif($value['taskstate']=="3"):?> 
				  <a href="index.php?r=admin/taskalter/index&id=<?=$value['taskId']?>" class="listInner">  								 				  
				  <?else:?>
				  <a href="index.php?r=admin/taskdetailed/index&id=<?=$value['taskId']?>" class="listInner">  							
			     <?endif?>	
			<?elseif($value['editflag']=="1"):?>
			 <a href="index.php?r=admin/taskalter/index&id=<?=$value['taskId']?>" class="listInner">  									     				 
			<?endif?>
					</p>			     			     
					<p class="listInfo">					
                    <span class="title">                        
                    <img src="../web/img/sanjiao.png" style="height:12px;margin-bottom:3px;"><?=$value['content']?></span>
					</p>					
					<p class="listInfo">
						<span class="date" style="display:inline-block;width:73%">
						考核日期：<?php if($value['endtime']<date('Y-m-d',time())&&$s==1):?>
						<span style="color:red"><?=$value['starttime']?>至<?=$value['endtime']?></span>
						<?php else:?>
						<?=$value['starttime']?>至<?=$value['endtime']?>
						<?endif?>
						</span>	
				  <?php if($value['editflag']=="0"||$value['editflag']=="2"):?> 
					    <?php if($value['taskstate']=="0"):?> 
					    <span class="righttip color0">未提交</span>
					    <?elseif($value['taskstate']=="1"):?>
					    <span class="righttip color1">审核中</span>
					     <?elseif($value['taskstate']=="2"&&$value['approverId']==""):?>
					    <span class="righttip color2">已完成</span>
					     <?elseif($value['taskstate']=="2"):?>
					    <span class="righttip color2">已通过</span>
					     <?elseif($value['taskstate']=="3"):?>
					    <span class="righttip color3">未通过</span>
					    <?endif?>
				 <?elseif($value['editflag']=="1"):?>
					  <span class="righttip color5">待修改</span>					 
				 <?endif?>
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
	<input type="hidden" id="s" value=<?=$s?>>
</div>
</div>
</body>
</html>
<script type="text/javascript">
$(function(){
	   var s=$("#s").val();
	   // alert(count);
	    if(s==1){
	        //$("#law").hide();
	        $("#left1").attr('class','left bc');
	        $("#left2").attr('class','wordl wc');
	    }else{
	    	$("#right1").attr('class','right bc');
		    $("#right2").attr('class','wordr wc');
	    }
    var count=$("#count").val();
   // alert(count);
    if(count>0){
        $("#empty").hide();
    }else{
    	$("#empty").show();
    }
	var count=$("#count").val();
	if(count*1>10){
		$("#pullUp").show();
	}else{
		$("#pullUp").hide();
	}
	$("#left1").click(function() {
		window.location.replace("index.php?r=admin/mytask/index&s=1&uid=<?=$uid?>");
	});
	$("#right1").click(function() {
		window.location.replace("index.php?r=admin/mytask/index&s=2&uid=<?=$uid?>");
	});
});
</script>