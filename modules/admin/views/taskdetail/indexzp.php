<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\jui\DatePicker;
//use dosamigos\datepicker\DatePicker;
?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>任务详情</title>
    <?=Html::cssFile('@web/css/bootstrap.min.css')?>
    <?=Html::cssFile('@web/css/announce.css')?>
    <?=Html::jsFile('@web/js/jquery.js')?>
</head>
<style>
.inpBox .btnAtta {
background-color: #ffacad;
color: #fff;
width: 100px;
height: 30px;
line-height: 30px;
display: inline-block;
vertical-align: top;
padding: 0 10px;
overflow: hidden;
-webkit-border-radius:10px;
border-radius: 10px;
position: relative;
}
.button0{
display:inline-block;
float:right;
vertical-align:top;
color:#ffacad;
height:30px;
width:80px;
margin:5px 0px 0px 5px;
background-color:#fff;	
text-align:center;
border-style:solid;
border-color:#ffacad;
border-width:2px;
border-radius:15px;		
}
</style>

<body class="bg_white" style="background-color: #efefef">	
   <div class="moGrid" style="width:100%;background-color: #fff;text-align:right;padding-bottom:0px;">
		<div class="formBox" style="width:90%;margin:15px auto">			
              <div class="moGrid" style="padding-bottom:0px;width:100%;">		
		           <div class="header">
			          <h4 style="text-align: left;"><?=$info['content']?></h4>
			          <span class="fl" style="margin-top:10px;color:#727272">考核时间：<?=$info['starttime']?>至<?=$info['endtime']?></span> 			
		           <span class="fr" style="margin-top:10px;color:#727272">已指派给：<?=$name?></span>
		           </div>
	          </div>           									
		</div>
	</div>

	<div class="moGrid">
		<div class="btnBox">                    
			<a id="sendBtn" href="javascript:void(0);" class="btnIteam btnSubmit" style="text-decoration:none;background-color: #ff7777;width:90%;-webkit-border-radius:13px;border-radius: 13px;">							
            <span class="ic_text" style="display:inline-block;line-height: 2.9;height: 2.9em;font-size:12pt;">取消指派</span>
			</a>	
					
		</div>
	</div>
<script type="text/javascript">
var win_w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
    win_h =  document.documentElement.clientHeight || document.body.clientHeight || window.innerHeight,
    win_scroll_top = document.documentElement.scrollTop || document.body.scrollTop; 
//定义公共函数
function g( selector ){
	var method = selector.substr(0,1) == '.'?'getElementsByClassName':'getElementById';
	return document[method]( selector.substr(1) );
}
function cancel(){
	//onclick='cancel();'
	 var geturl = "index.php?r=admin/taskdetail/cancel&id="+"<?=$id?>"; 	       
		geturl = encodeURI(encodeURI(geturl));
		window.location.href =geturl;	
		return false;	
}
$(function(){
	$("#sendBtn").click(function() {
		window.location.replace("index.php?r=admin/taskdetail/cancel0&id="+"<?=$id?>");
	});
});
</script>
</body>
</html>
