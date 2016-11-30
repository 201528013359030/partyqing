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
<?=Html::cssFile('@web/css/announce.css')?>
<?=Html::cssFile('@web/css/bootstrap.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>
<?=Html::jsFile('@web/js/htmlset.js')?>
<style>
.btnBox .btnCheck {
background-color: #30BF78;
width: 36%;
margin-right: 8px;
}
.btnBox .active {
background-color: #f2f2f2;
color: #444;
}
.head0{
	display:inline-block;
	width:70%;
	margin-top:20px;
	vertical-align:top;
}
.note {
    display: inline-block;
    width: .625em;
    height: .625em;
    background: #4bb1ff;;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
}
.mcurrent .note {
    width: 1.125em;
    height: 1.125em;
    border: .125em #D1EAFC solid;
    background: #4bb1ff;
}
.mcurrent{margin:20px 20px 0px 20px;}
.note0{margin-left:7px;color:#4bb1ff;vertical-align:top;}
.leftex{
display:inline-block;
float:left;
height:35px;
width:30%;
margin:10px 0px 10px 13%;
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
height:35px;	
margin:10px 13% 10px 0px;
background-color:#fff;	
text-align:center;	
border-style:solid;
border-color:#929292;
border-width:1px;
border-radius:10px;
}
.wordlex{
display:inline-block;	
margin-top:7px;
color:#fff;
font-weight:bold;	
}
.wordrex{
display:inline-block;	
margin-top:7px;
color:#929292;
font-weight:bold;	
}
</style>
</head>
<body>
<div class="wrap">
<div style="height:10px;background-color:#eeeeee"></div>
	<div>	
	<div style="display:inline-block;margin-top:20px;margin-left:20px;width:50px;"><img style="width:40px;" src="<?=$content['avator']?>"></div>
		<div class="head0">		
		<span ><?=$content['name']?></span>
			<p style="margin-top:5px;">      
				<span style="color:#929292;font-size:11pt">
				<?php if($content['editflag']=="1"):?>
				待修改
				 <?else:?>
				<?php if($content['name1']==""):?>
				已完成	
                <?else:?>
				<?=$content['name1']?><?php if($content['taskstate']=="1"):?>（审核中）<?elseif($content['taskstate']=="2"):?>（已通过）<?elseif($content['taskstate']=="3"):?>（未通过）<?endif?>
				<?endif?>
				<?endif?>
				</span>
				<?php if($a&&$content['assign']=="1"):?>
				<span style="float:right">已指派：<?=$sname?></span>
			<?php //if($content['taskstate']=="3"&&$a!="1"&&$content['assignuid']==$suid):?>
			<!--  <a style="color:#4B71E2" href="index.php?r=admin/taskdetail/index&id=<?//=$id?>">重新汇报</a>-->
			   <?endif?>
			</p>
		</div>
	</div>
	<div style="margin-top:10px;height:10px;background-color:#eeeeee"></div>
		<div style="margin:20px 20px 20px 20px;">							
			<span style="color:#929292;">任务名称：</span><span style="display:inline-block;margin-top:10px;"><?=$content['content']?></span>			
	    </div>
		<div style="height:10px;background-color:#eeeeee"></div> 
<div style="padding-bottom:40px;background-color:#fff">			   
	<div style="margin:20px 20px 20px 20px;">
		<span style="color:#929292;">汇报内容：</span>
		<span style="display:block;margin-top:10px;"><?=$content['taskcontent']?></span>
		</div>
	<span style="display:inline-block;margin-left:20px;margin-bottom:20px;color:#4bb1ff;">查看附件：</span>
	<div class="moGrid" id="attaBox">	
	<?php if($attachList!=""):?> 
		<div class="attaBox">		
		  <?php foreach ($attachList as $key=>$value): ?>
			<i class="ficon ic_atta"></i>
            <div href="#" class="attaIteam" style="cursor:pointer;" onclick='download_file("<?=$value['path']?>","<?=$value['name']?>","<?=$value['size']?>","<?=$value['url']?>");'>
				<i class="ficon ic_file"></i><?=$value['name']?>
			</div>
			<? endforeach?>		
		</div>
	<?endif?>
	</div>
<?php if($content['name1']==""):?>	
<?else:?>
	<div style="height:10px;background-color:#eeeeee"></div>
<?endif?>	
	<?php if($check==1):?>
	<?php if($content['taskstate']==1):?>
	<div style="margin:20px 20px 20px 20px;"> 
	<form name="send_form" id="send_form" method="post" enctype="multipart/form-data" action="index.php?r=admin/taskdetailed/check">   	
	    <div style="margin-left:20px">意见
	    <input type="text" id="comment" name="comment" value="" style="margin-left:10px;width:80%;height:35px;font-size:12pt;border-radius:5px;" placeholder="请输入您的批语"></div>    
	    <input type="hidden" id="taskid" name="taskid" value=<?=$id?>>	    
	    <a class="leftex"  href="javascript:void(0);" onclick="send_submit('1');"><span class="wordlex">通过</span></a>
        <a class="rightex" href="javascript:void(0);" onclick="send_submit('2');"><span class="wordrex">不通过</span></a>       	  		
	</form>
	</div>
</div>
<div style="height:10px;background-color:#eeeeee"></div>

    <?endif?>
	<?endif?>
<?php if($content['name1']==""):?>
<?else:?>
<div style="padding-bottom:40px;background-color:#fff">
<span style="display:inline-block;margin-left:20px;margin-top:20px;">流程跟踪</span>
<?php foreach ($list as $key=>$value): ?>
<div class="mcurrent">
	<span class="note"></span><span class="note0">
<?=$content['name1']?><?php if($value['comment']=="1"):?>审阅中...<?elseif($value['comment']=="2"):?>已通过。<?elseif($value['comment']=="3"):?>未通过。<?endif?>	
	</span>	
</div>
<?php if($value['commentcontent']!=""):?>
<span style="display:inline-block;margin:5px 10px 0px 20px;font-size:11pt;color:#929292">(意见：<?=$value['commentcontent']?>)</span>	
<?endif?>
<?endforeach?>	
</div>
</div>
<?endif?>
<script type="text/javascript">
function send_submit(x){
	//alert("yes");
	  if(x=="2"){   
		  document.send_form.action="index.php?r=admin/taskdetailed/checkno";   
	  }else{   
		  document.send_form.action="index.php?r=admin/taskdetailed/check";   
	  }   
    document.send_form.submit();
    return false;
}

var cls;
function g( selector ){
	var method = selector.substr(0,1) == '.'?'getElementsByClassName':'getElementById';
	return document[method]( selector.substr(1) );
}	

var u = navigator.userAgent, app = navigator.appVersion;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
API.init();
function download_file(file,name,size,url){
    //if(!download_start(name,url,size)){
   // }
   // window.location.href='index.php?r=admin/noticecontent/download&file='+file+'&name='+name;
   // return false;
    if(isAndroid || isiOS){
        download_start(name,url,size);
    }else{
        download_start(name,url,size);
        window.location.href='index.php?r=admin/taskdetailed/download&file='+file+'&name='+name;
    }
    return false;
}
var fileID = 1;
var taskID = 1;
function download_start(name,url,size){
    var op = {
        "name": "Download",
        "callback": "OnDownloadCb",
        "params": {
            "fileName": name,
            "fileID": fileID++,
            "taskID": taskID++,
            "size": size,
           // "path": "<?//=$offline_ip?>"+url,
            "path": url,
        }
    };
    //alert(JSON.stringify(op));
    API.send_tonative(op);
}
function OnDownloadCb(param){
    params = param.result.params; 
   
    // alert(JSON.stringify(params));
    if(params.transferStatus == 'Success'){
 //       alert("下载成功");
    }else if(params.transferStatus == 'Failure'){
  //      alert("下载失败");
    }

}

</script>
</body>
</html>




