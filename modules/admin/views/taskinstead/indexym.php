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

</head>
<body>	
<a class="left" id="left1" href="index.php?r=admin/mytask/index&s=1&uid=<?=$uid?>"><span id="left2" class="wordl">未完成</span></a>
<a class="right" id="right1" href="index.php?r=admin/mytask/index&s=2&uid=<?=$uid?>"><span id="right2" class="wordr">已完成</span></a>
<div id="wrap" class="wrap">
<div id="scroller">
	
	<div class="moBox moPadTop">
		<div id="listBox" class="listBox">
			<!--
				已分派
            	molistIteam 自定义样式修改
            	moListCur 选择转给他人的时候给每一个  未分派的人增加这个 class
            -->
			<div class="listIteam molistIteam">
				<span class="icon_yizhipai"></span>				
				<a href="index.php?r=admin/taskdetail/index&amp;id=30" class="listInner">  								 
				  	<p class="listInfo">					
                    <span class="title">                        
                    <img src="../web/img/sanjiao.png" style="height:12px;margin-bottom:3px;">
                    	已经分派的任务标题
                    </span>
					</p>					
					<p class="listInfo">
						<span class="date">考核日期：
						<span style="color:#666">2016-03-08至2016-03-22</span>
						</span>					     
					    <span class="righttip color0">未提交</span>
					</p>	
				</a>
			</div>
			<!--选择转给他人显示-->
			<div class="listIteam molistIteam moListCur">
				<div class="customRadio moMytaskRadio">					
					<input type="checkbox" name="sex" value="男" checked="false">
					<a href="javascript:void(0);">
						<span class="ficon icon-ok"></span>
						<span class="icons icons-circal"></span>
					</a>
				</div>
				<a href="index.php?r=admin/taskdetail/index&amp;id=30" class="listInner">  								 
				  	<p class="listInfo">					
                    <span class="title">                        
                    <img src="../web/img/sanjiao.png" style="height:12px;margin-bottom:3px;">支持依规依纪严肃处理违规违纪行为和“一案双查”，强化责任追究的落实情况</span>
					</p>					
					<p class="listInfo">
						<span class="date">考核日期：
						<span style="color:#666">2016-03-08至2016-03-22</span>
						</span>					     
					   <!-- <span class="righttip color0">未提交</span>-->
					</p>
				</a>
			</div>
			
			<div class="listIteam" id="empty">
				<div class="empty">暂无</div>
			</div>
			
			<?php foreach ($list as $key=>$value): ?>
			<div class="listIteam" id="contentlist_">
				
				<!--<span class="icon_yizhipai"></span>
				
				<div class="customRadio moMytaskRadio">					
					<input type="checkbox" name="sex" value="男" checked="fasle">
					<a href="javascript:void(0);">
						<span class="ficon icon-ok"></span>
						<span class="icons icons-circal"></span>
					</a>
				</div>-->
								
		          <?php if($value['taskstate']=="0"):?> 
				  <a href="index.php?r=admin/taskdetail/index&id=<?=$value['taskId']?>" class="listInner">  								 
				  <?else:?>
				  <a href="index.php?r=admin/taskdetailed/index&id=<?=$value['taskId']?>" class="listInner">  							
			     <?endif?>
					<p class="listInfo">					
                    <span class="title">                        
                    <img src="../web/img/sanjiao.png" style="height:12px;margin-bottom:3px;"><?=$value['content']?></span>
					</p>					
					<p class="listInfo">
						<span class="date">考核日期：
						<?php if($value['endtime']<date('Y-m-d',time())&&$s==1):?>
						<span style="color:#666"><?=$value['starttime']?>至<?=$value['endtime']?></span>
						<?php else:?>
						<?=$value['starttime']?>至<?=$value['endtime']?>
						<?endif?>
						</span>	
					    <?php if($value['taskstate']=="0"):?> 
					    <span class="righttip color0">未提交</span>
					    <?elseif($value['taskstate']=="1"):?>
					    <span class="righttip color1">审核中</span>
					     <?elseif($value['taskstate']=="2"):?>
					    <span class="righttip color2">已通过</span>
					     <?elseif($value['taskstate']=="3"):?>
					    <span class="righttip color3">未通过</span>
					    <?endif?>
					</p>					
					
				</a>
			</div>
			<? endforeach?>
		</div>
		<!--  <div class="moBtnBox">
		<a id="J_sendOther" href="javascript:void(0);" class="btn_sendOther">转给他人</a>		
        </div>
        <div id="J_result" class="resultBox">
        	<p>您已选择：<em id="J_name">王静</em></p>
        	<a id="J_submitOther" class="btn_sendOther" href="javascript:void(0);">提交</a>
        </div>-->
	</div>
	
	<input type="hidden" id="count" value=<?=$count?>>
	<input type="hidden" id="s" value=<?=$s?>>
</div>
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
});
</script>