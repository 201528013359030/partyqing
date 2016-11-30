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
<title>公告详情</title>
<?=Html::cssFile('@web/css/announce.css')?>
<?=Html::cssFile('@web/css/bootstrap.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>
<?=Html::jsFile('@web/js/htmlset.js')?>
</head>
<body>
	
<div id="wrap" class="wrap">
	<div class="moGrid">		
		<div class="header">
			<h1><?=$noticecontent['title']?></h1>
			<p class="lead">
				<span class="fr corFocus"><i class="ficon ic_checked"></i><?=$confirm_count?></span><span class="fr corFocus"><i class="ficon ic_eye"></i><?=$read_count?></span>
				<span class="fl corDate"><?=date('Y-m-d H:i:s',$noticecontent['time'])?></span> <span class="fl corFocus"><?=$noticecontent['sender_name']?></span>
			</p>
		</div>
	</div>
	<div class="moGrid">	
		<div class="content">
			<!-- <p>				
				<img src="images/temp1.jpg">
			</p> -->
			<p>
			<?=$noticecontent['content']?>
			</p>
		</div>
	</div>
	<div class="moGrid" id="attaBox">
	<?php if($attachList!=""):?> 
		<div class="attaBox">
		
		  <?php foreach ($attachList as $key=>$value): ?>
			<i class="ficon ic_atta"></i>
            <a href="#" class="attaIteam" onclick='download_file("<?=$value['path']?>","<?=$value['name']?>","<?=$value['size']?>");'>
				<i class="ficon ic_file"></i><?=$value['name']?>
			</a>
			<? endforeach?>
		
		</div>
	<?endif?>
	</div>
	<div class="moGrid">
		<div class="btnBox">
			<a href="javascript:void(0);" class="btnIteam btnCheck" id="J-check" style="display: inline-block;">
				<i class="ficon ic_check"></i>
				<span class="ic_text">确认</span>
			</a>
			<a href="javascript:void(0);" class="btnIteam btnCheck active" id="J-checked"  style="display:none;" data-toggle="modal" data-target="#myModal">
				<i class="ficon ic_check"></i>
				<span class="ic_text">已确认</span>
			</a>
			<a href="index.php?r=admin/noticereader/index&id=<?=$announce_id?>" class="btnIteam btnMem">
				<i class="ficon ic_user"></i>
				<span class="ic_text">查看接收人(<?=$all_count?>)</span>
			</a>
		</div>
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
                   已经确认过！
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="">确定
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>

<a id="uploadModalBtn" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#uploadModal" style="display:none">
</a>
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" style='z-index:1060'>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="uploadModalLabel">
                    下载文件
                </h4>
            </div>
            <div id="errorSize" class="alert alert-danger" style="display:none" >错误！</div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>文件名</th>
                            <th>大小</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="up_file_name" style=""></td>
                            <td id="up_file_size" style="min-width:6em"></td>
                            <td id="up_file_state" style="color:#FF0000;min-width:6em">正在下载</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="">关闭
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<input type="hidden" id="attach_count" value=<?=$attach_count?>></input>
<input type="hidden" id="confrimed_count" value=<?=$confirmed_count?>></input>

<script type="text/javascript">
$(function(){	

	var confirmed_count=$("#confrimed_count").val();
// 	alert(confirmed_count);
	if(confirmed_count=="1"){	
		
		$("#J-check").attr('style','display: none;');	
		$("#J-checked").attr('style','display: inline-block;');	
	}else{
		
		$("#J-check").attr('style','display: inline-block;');	
		$("#J-checked").attr('style','display:none;');	
	}

});

var cls;

function g( selector ){
	var method = selector.substr(0,1) == '.'?'getElementsByClassName':'getElementById';
	return document[method]( selector.substr(1) );
}	

g('#J-check').onclick = function(){
	
	$.get("index.php?r=admin/noticecontent/confirm",{id:<?=$announce_id?>
	},function(data){
// 		alert(data);
		if(data){
// 			alert('success');
		}else{
// 			alert("fail");
		}
	},'json');	
	this.style.display = 'none';
	g('#J-checked').style.display = 'inline-block';
}
 g('#J-checked').onclick = function(){
	   document.getElementById("sendSucceed").click();
// 	alert('您已经确认过了');
}
function download_file(file,name){
    download_start(file,name);
    return;
    window.location.href='index.php?r=admin/noticecontent/download&file='+file+'&name='+name;
    return false;
}
function download_start(name,url,size){
    var op = {
        "name":"CloseWebView",
        "params":{"name": name,"url": url,"size": size}
    };
    API.send_tonative(op);
}
</script>


</body>
</html>




