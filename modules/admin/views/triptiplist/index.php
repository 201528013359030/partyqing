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
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
<?=Html::cssFile('@web/css/mytask_undo.css')?>
<style>
body{
	background-color:#ededed;
	margin:0;
}

.list{
background-color:#ffffff;
margin:10px 0px 10px 0px;
padding:10px 15px 10px 10px;
line-height:40px;
font-size:12pt;
color:#4d4d4d;

}
.traffic{
	display:inline-block;
	word-wrap:break-word;
    word-break:break-all;
	overflow:hidden;
	height:100%;
	width:30%;
	margin:0;
	padding:0;
	border-right:1px solid #ededed;
	vertical-align:top;
}
hr{margin:0;}
table{
margin:3px;
width:100%;
margin-top:6px;
border-collapse: collapse;
}
table td{
padding:10px;
font-size:11pt;
border:1px solid #ededed;
min-width:60px;
vertical-align:top;
}
</style>
</head>
<body>

			<div class="listIteam" id="empty">
				<div class="empty">暂无</div>
			</div>
			<?php foreach ($list as $key=>$value): ?>
			<div class="list">
            <span style="color:#ce2124"><?=$value['gradename']?></span>
            <hr style="border-top:#fff;width:108%;margin-left:-20px;"/>
                              <span style="margin-left:5px;">交通标准 </span>
<div style="width:100%">
<table border="1" cellpadding="10">
   <tr>
     <td   style="border-left:1px solid #fff; border-right:1px solid #fff;"><span style="color:#fd7474;"><!--  火车</span><img src="../web/img/train.png" style="margin-bottom:7px;margin-left:5px;vertical-align:bottom;height:25px;">
     </br>  -->
     <span style="display:inline-block;margin-top:10px;color:#8d8d8d;line-height:20px;"><?=$value['traffic']['train']?></span>
     </td>
   <!--
    <td type="hidden"><span style="color:#fd7474;">轮船</span><img src="../web/img/lc.png" style="margin-bottom:7px;margin-left:5px;vertical-align:bottom;height:25px;">
             </br><span style="display:inline-block;margin-top:10px;color:#8d8d8d;line-height:20px;"><?//=$value['traffic']['ship'];?></span></td>
     <td type="hidden" style="border-right:1px solid #fff;"><span style="color:#fd7474;">飞机</span><img src="../web/img/plane.png" style="margin-bottom:7px;margin-left:5px;vertical-align:bottom;height:25px;">
             </br><span style="display:inline-block;margin-top:10px;color:#8d8d8d;line-height:20px;"><?//=$value['traffic']['plane'];?></span></td>
   -->
    </tr>
</table>
</div>
            <span style="margin-left:5px;">住宿标准</span>
            <div style="margin-left:20px;line-height:35px;"><span style="color:#8d8d8d;">普通标准：</span><span style="float:right"><span style="color:#ce2124">¥</span><?=$value['common_money']?></span></br>
             <?php if($value['peak_month']==""):?>
             <? else:?>
                    <span style="color:#8d8d8d;"> 旺季期间(<?=$value['peak_month']?>)：</span>
                    <span style="float:right"><span style="color:#ce2124">¥</span><?=$value['peak_money']?></span></br>
			<?endif?>
			<span style="margin-left:-15px;">伙食补助：</span><span style="float:right"><span style="color:#ce2124">¥</span><?=$value['ricemoney']?></span></br>
			<span style="margin-left:-15px;">交通补助：</span><span style="float:right"><span style="color:#ce2124">¥</span><?=$value['trafficmoney']?></span>
			</div>
			</div>
			<? endforeach?>
			<input type="hidden" id="count" value=<?=$count?>>
</body>
</html>
<script type="text/javascript">
$(function(){
	//$("#searchtitle").val("");
    var count=$("#count").val();
    //alert(count);
    if(count==0){
        $("#empty").show();
    }else{
    	$("#empty").hide();
    }
});
</script>
