<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\View;
?>
<style>
<!--
-->
</style>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta content="telephone=no" name="format-detection" />
<title>任务详情</title>
<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
 <?=Html::jsFile('@web/js/jquery.js')?>
 <?=Html::jsFile('@web/js/htmlset.js')?>
<script>
var isiOS = false;
var isAndroid = false;
var u = navigator.userAgent, app = navigator.appVersion;
isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
//    alert('是否是Android：'+isAndroid);
//    alert('是否是iOS：'+isiOS);
function upload_btn_click(filetype){
	$("#announceform-filetype").attr("value",filetype);
  //  $("#upload_button").click();
   // uploadFileStart();
   // TransferStatus('teset','0','Cancel','100');
    //var params={'status':'Transmission','fileName':'tets.tst','size':'1000','fileId':0,'uploadPath':'123'};
    //OnUploadCb(params);
   // var params={'status':'Success','fileName':'tets.tst','size':'1000','fileId':0,'uploadPath':'123'};
   // OnUploadCb(params);
   // return;
    $("#closeUpload").css('display','none');
    $("#up_file_state").text("正在上传");
    $("#up_file_state").css("color","#FF0000");

    if(isiOS || isAndroid){
        uploadFileStart();
        return;
    }
    document.getElementById("upload_button").click();
}
</script>
</head>
<body>
	
<div id="wrap" class="wrap">
	<div class="moGrid">		
		<div class="header">
			<h4><?=$info['content']?></h4>
			<span class="fl corDate">考核时间：<?=$info['starttime']?>至<?=$info['endtime']?></span> 			
		</div>
	</div>
	<div class="moGrid">	
		<div class="content">
		汇报内容：<textarea rows="5" style="width:70%" placeholder="请输入汇报的具体内容（必填）"></textarea>
			<p>
			<?=$info['suporting']?>
		    </p>
		</div>
	</div>
	<div id="upload_attach" class="inpBox" style="#display:none;cursor:pointer;">
				<div class="btnAtta" onclick="upload_btn_click(2);">
					<i class="ficon ic_atta"></i>
					<span class="ic_text">上传附件</span>					
					<!--input type="file" name="" value="" class="btnfile"-->					
				</div>
	</div>
	<!--
			描述：添加完的附件放在这里 class="inpBox inpBox_atta"
            	attaIteam 为每一条上传的附件
            	附件删除按钮 
            	<a href="#" class="ficon ic_x fr"></a>
            -->
			<div class="inpBox inpBox_atta">
				
				<div id="attach1" href="#" class="attaIteam" style="display:none;">
					<div class="ficon ic_x fr" style='cursor:pointer;' onclick='file_del(1)'></div>
					<i id="attachName1" class="ficon ic_file"></i>
				</div>
				
				<div id="attach2" href="#" class="attaIteam" style="display:none;">
					<div href="#" class="ficon ic_x fr" style='cursor:pointer;'  onclick='file_del(2)'></div>
					<i id="attachName2" class="ficon ic_file"></i>
				</div>

				<div id="attach3" href="#" class="attaIteam" style="display:none;">
					<div href="#" class="ficon ic_x fr" style='cursor:pointer;' onclick='file_del(3)'></div>
					<i id="attachName3" class="ficon ic_file"></i>
				</div>
				
			</div>
			<!--end 结束附件框-->
			
			<div style="#display: none;">
				<input id="announceform-filetype" type="hidden" name="AnnounceForm[filetype]" value="">              	
			</div>
	<div class="moGrid">
		<div class="btnBox">
	
		</div>
	</div>
</div>
<input type="hidden" id="confrimed_count" value=<?//=$confirmed_count?>></input>
<script type="text/javascript">

</script>
</body>
</html>




