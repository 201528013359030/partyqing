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
</style>
</head>
<body>
<div id="wrap" class="wrap">
<div id="scroller">
   <div class="moBox"  style="height:20px;" id="searchBox">
		<div class="searchBox">
			<div class="searchInner">
			<input id="searchtitle" class="inpSearch" name="searchtitle" value="" type="text" placeholder="输入搜索关键字">			
			<a href="javascript:void(0);" class="ficon ic_search" id="search"></a>			
			</div>
		</div>		
	</div>
	<div style="margin-top:20px;margin-bottom:10px;height:10px;background-color:#ededed"></div>
	<div class="moBox">
		<div id="listBox" class="listBox">
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
					<span class="tip ficon ic_arrow_right"></span>																		
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
document.getElementById('searchtitle').addEventListener('input', function(e){
//     var value = e.target.value;
	//alert("3355");
	$.get("index.php?r=admin/triptip/search",{searchtitle:$("#searchtitle").val()
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
	
			     iteam.innerHTML = "<a href='index.php?r=admin/triptiplist/index&stateid="+list[i].id+"' class='listInner'><p class='listInfo'><span class='title'>"+list[i].statename+"</span></p><p class='listInfo'></p></a>";
					
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
