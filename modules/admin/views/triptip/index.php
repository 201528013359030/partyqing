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
<title>出差助手</title>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>
<style>
.listInner {
padding-top: 10px;
padding-left: 4%;
display: block;
position: relative;
border-bottom: 0px #d0d0d0 solid;
}
.listIteam {
position: relative;
height:50px;	
}
#pullUp {
border-bottom: 0px solid #ccc;
height:0px;
}
.title0{
display: inline-block;
font-size: 1.125em;
line-height: 1.125;
max-height: 2.2em;
overflow: hidden;
color:#fd7474;
width: 95%;
margin-left:4%;
margin-top:10px;
}
.title1{
display: inline-block;
font-size: 1.125em;
line-height: 1.125;
max-height: 2.2em;
overflow: hidden;
width: 40%;
margin-left:4%;
margin-top:20px;
color:#000;
}
select{
	width:93%;
	margin:10px 0px 0px 10px;
	height: 2.2em;
border: #d0d0d0 1px solid;
background: #fff;	
-webkit-border-radius: 15px;
border-radius: 15px;
}
.searchInner {
width: 100%;
height: 2.2em;
border: #d0d0d0 1px solid;
background: #fff;
-webkit-border-radius: 15px;
border-radius: 15px;
}
#scroller {
padding-bottom: 20px;
}
</style>
</head>
<body>
<div id="wrap" class="wrap">
<div id="scroller">
<div style="background-color: #ededed;padding-bottom:10px">
  <div style="display:inline-block;width:47%;">
  <select id="grade" onchange="grade()">
  <?php foreach ($grade as $key=>$value): ?>
  <option value ="<?=$value['gradeid']?>"><?=$value['grade']?></option>
  <? endforeach?>
  </select>
   </div>
   <div class="moBox"  style="display:inline-block;height:20px;width:47%" id="searchBox">
		<div class="searchBox" style="width:100%;margin-top:6px;margin-right:0px">
			<div class="searchInner">
			<input id="searchtitle" class="inpSearch" style="width:75%;height: 2.2em;" name="searchtitle" value="" type="text" placeholder="请输入城市名称">			
			<a href="javascript:void(0);" class="ficon ic_search" id="search"></a>			
			</div>
		</div>		
	</div>
</div>
<div style="height: 56px;padding-top:8px;border-bottom:1px solid #ededed">				
                <span class="title0">常去城市</span>
	</div>
	<div>				
	<?php foreach ($listtop as $key=>$value): ?>	
                <a href="index.php?r=admin/triptiplist/index&stateid=<?=$value['stateid']?>">
                <span class="title1"><?=$value['statename']?></span>
                </a>
   <? endforeach?>             
	</div>
	<div style="margin-top:20px;margin-bottom:10px;height:10px;background-color:#ededed"></div>	
	<div class="moBox">
		<div id="listBox" class="listBox">		  
	        <div style="height: 50px;margin-bottom:10px;border-bottom:1px solid #ededed">				
                <span class="title0">按地区搜索</span>
			</div>
			<div class="listIteam" id="empty">
				<div class="empty">暂无</div>
			</div>
			<?php foreach ($list as $key=>$value): ?>			
			<div class="listIteam"  id="contentlist_">
		        <a href="index.php?r=admin/triptiplist/index&stateid=<?=$value['id']?>" class="listInner"> 				
					<p class="listInfo">					
                    <span class="title">      
                    <?=$value['statename']?></span>
					</p>
					<span class="tip ficon ic_arrow_right" style="margin-top:-17px;"></span>																		
				</a>
			</div>
			<? endforeach?>
		</div>
	</div>
	<div id="pullUp">		
	</div>
	<input type="hidden" id="count" value=<?=$count?>>
</div>
</div>
</body>
</html>
<script type="text/javascript">
function grade(){
	var gradeid=$('#grade option:selected').val();//选中的值
	$.get("index.php?r=admin/triptip/grade",{gradeid:gradeid
	},function(data){
	},'json');
}
	//var gradename=$('#grade option:selected').text();//选中的文本
document.getElementById('searchtitle').addEventListener('input', function(e){
//     var value = e.target.value;
	//var gradeid=$('#grade option:selected').val();//选中的值
	$.get("index.php?r=admin/triptip/search",{searchtitle:$("#searchtitle").val(),
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
	
			     iteam.innerHTML = "<a href='index.php?r=admin/triptiplist/index&stateid="+list[i].id+"'class='listInner'><p class='listInfo'><span class='title'>"+list[i].statename+"</span></p><span class='tip ficon ic_arrow_right'></span></a>";
					
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
$(function(){
	$("#searchtitle").val("");	
    var count=$("#count").val();
    //alert(count);
    if(count==0){
        $("#empty").show();
    }else{
    	$("#empty").hide();
    }
	var count=$("#count").val();
	if(count*1>10){
		$("#pullUp").show();
	}else{
		$("#pullUp").hide();
	}
	var gradeid=$('#grade option:selected').val();//选中的值
	$.get("index.php?r=admin/triptip/grade",{gradeid:gradeid
	},function(data){
	},'json');
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
