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
<style>
body{
	background-color:#ededed;
	margin:0;
}
.list{
background-color:#ffffff;
margin:10px 0px 10px 0px;
padding:10px 20px 10px 30px;
line-height:40px;
font-size:12pt;
color:#4d4d4d;
}
</style>
</head>
<body>
			<div class="listIteam" id="empty">
				<div class="empty">暂无</div>
			</div>
			<?php foreach ($list as $key=>$value): ?>
			<div class="list">		       				                      
            <?=$value['gradename']?><hr style="border-top:#ededed"/>
            <div style="margin-left:20px;line-height:45px">普通标准：<span style="float:right"><span style="color:#ce2124">¥</span><?=$value['common_money']?></span></br>
             <?php if($value['peak_month']==""):?>  
             <? else:?>            
                                旺季期间(<?=$value['peak_month']?>)：
                    <span style="float:right"><span style="color:#ce2124">¥</span><?=$value['peak_money']?></span></br>                        	
			<?endif?>
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
