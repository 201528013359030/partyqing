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
<title>待我审核</title>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
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
.listInfo .title {
display: inline-block;
vertical-align: top;
font-size: 1.125em;
line-height: 1.5;
max-height: 4.4em;
overflow: hidden;
color: #444;
width: 96%;
}

.leftex{
display:inline-block;
float:left;
height:40px;
width:30%;
margin:20px 0px 10px 13%;
background-color:#ffacad;	
text-align:center;
border-style:solid;
border-color:#ffacad;
border-width:1px;
border-radius:10px;		
}
.rightex{
display:inline-block;
float:right;
width:30%;
height:40px;	
margin:20px 13% 10px 0px;
background-color:#eeeeee;	
text-align:center;	
border-style:solid;
border-color:#929292;
border-width:1px;
border-radius:10px;
}
.button0{
position: fixed;
bottom:0px;
width:100%;
}
.wordlex{
display:inline-block;	
margin-top:9px;
color:#fff;
font-weight:bold;
}
.wordrex{
display:inline-block;	
margin-top:9px;
color:#929292;
font-weight:bold;	
}
.but{
display: inline-block;
width: 20px;
height: 20px;		
border: 1px #D2D2D2 solid;
color: #fff;
-border-radius: 15px;		
-webkit-border-radius: 15px;
vertical-align:bottom;
}
.but0{
display: inline-block;
width: 20px;
height: 20px;	
background:url(../web/img/duoxuan.png);	
background-size:20px 20px;	
color: #fff;
-border-radius: 15px;		
-webkit-border-radius: 15px;	
vertical-align:bottom;	
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
		
			$.get("index.php?r=admin/taskcheck/getdata",{s:$("#s").val()
		},function(data){
			//alert(333);
	 		//alert(JSON.stringify(data));	
			var list=eval(data);
			if(list.length){				
				for (i=0; i<list.length; i++) {
					iteam = document.createElement('div');
					iteam.className = 'listIteam';
                    if(list[i].taskstate=="0"){
                       comment="<span class='righttip color0'>未提交</span>"; 
                    }else if(list[i].taskstate=="1"){
                       comment="<span class='righttip color1'>审核中</span>"; 
                    }else if(list[i].taskstate=="2"){
                       comment="<span class='righttip color2'>已通过</span>"; 
                    }else if(list[i].taskstate=="3"){
                       comment="<span class='righttip color3'>未通过</span>"; 
                    }else{
                       comment ="";                 
                    }	
                  iteam.innerHTML = "<a href='index.php?r=admin/taskdetailed/index&a=1&check=1&id="+list[i].taskId+"' class='listInner'><p class='listInfo'><span class='title'>"+list[i].content+"</span></p><p class='listInfo'><span class='date'>考核日期："+list[i].starttime+"至"+list[i].endtime+"</span>"+comment+"</p></a>";
					
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
<body >	
<a class="left" id="left1" href="index.php?r=admin/taskcheck/index&s=1&uid=<?=$uid?>"><span id="left2" class="wordl">待审核</span></a>
<a class="right" id="right1" href="index.php?r=admin/taskcheck/index&s=2&uid=<?=$uid?>"><span id="right2" class="wordr">已审核</span></a>
<div id="wrap" class="wrap" style="background-color:#eeeeee">
<div id="scroller">
	<div id="pullDown" style="background-color:#eeeeee" >
		<span class="pullDownIcon"></span><span class="pullDownLabel">下拉即可加载...</span>
	</div>
	<div class="moBox">
		<div id="listBox" class="listBox">
			<div class="listIteam" id="empty">
				<div class="empty">暂无</div>
			</div>
			<div style="height:10px;background-color:#eeeeee"></div>
			<?php foreach ($list as $key=>$value): ?>
			<div class="listIteam"  id="contentlist_" style="background-color:#fff">
		        <a href="index.php?r=admin/taskdetailed/index&a=1&check=1&id=<?=$value['taskId']?>" class="listInner">  				
					<p class="listInfo" style="display:table;width:100%">					
                    <span class="title">                        
                    <?=$value['content']?>
                    </span>
                    <span style="display:inline-block;display: table-cell;vertical-align: middle;color:#929292;width:30%;text-align:center;">
                    <?=$value['name']?>                  
                    <?php if($s==1):?>	
                    <span style="display:inline-block;margin-left:5px;">
                    <input type="checkbox" id="la<?=$key?>" name="task" style="display:none" value="<?=$value['taskId']?>"/> 
                    <label for="la<?=$key?>"><span class="but" id="a<?=$key?>" onclick="changea('<?=$key?>')"></span></label>       
                    <?else:?>
                          <span style="color:blue;"><?php if($value['taskstate']==2):?>
                                                                                     已通过	
                          <?elseif($value['taskstate']==3):?> 
                                                                                     不通过
                          <?endif?></span>
                    <?endif?>
                    </span>
                     </span>
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
</div>
<?php if($s==1&&$count!=0):?>	
		<div class="button0">		
		<a class="leftex"  href="javascript:void(0);" onclick="checkeds();"><span class="wordlex">通过</span></a>
        <a class="rightex" href="javascript:void(0);" onclick="checkedno();"><span class="wordrex">不通过</span></a>
        </div>
<?endif?> 
</body>
</html>
<script type="text/javascript">
function changea(x){
	var a=x;
	var b=document.getElementById('a'+a).className;
	if(b=="but"){
	document.getElementById('a'+a).className = 'but0';
	 }else{
	document.getElementById('a'+a).className = 'but'; 
		}
}
function checkeds(){   //通过
	 //$('input:checkbox[name="multiple"]:checked')和$("input[name='multiple']:checked")是一样的效果		 
	 var task=new Array();
	 $('input:checkbox[name="task"]:checked').each(function(x) //multiple checkbox的name  
	   {  
	       task[x]=$(this).val(); 
		   //alert($(this).val());
		   //alert (mycars[x]);
	   }); 
	   if(task==""){alert("请选择！");}else{
	          if(confirm('确定通过吗？')){     
	          var geturl = "index.php?r=admin/taskcheck/check&check="+task;
			  geturl = encodeURI(encodeURI(geturl));
			  window.location.href =geturl;	
			  return false;	
			  }
	  } 
}
function checkedno(){    //订单有误
	 var task=new Array();
	 $('input:checkbox[name="task"]:checked').each(function(x) //multiple checkbox的name  
	   {  
	       task[x]=$(this).val(); 
		   //alert($(this).val());
		   //alert (mycars[x]);
	   }); 
	   if(task==""){alert("请选择！");}else{
	          if(confirm('确定不通过吗？')){     
	          var geturl = "index.php?r=admin/taskcheck/checkno&checkno="+task;
			  geturl = encodeURI(encodeURI(geturl));
			  window.location.href =geturl;	
			  return false;	
			  }
	  } 
}
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
});
</script>