<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\View;

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\jui\DatePicker;
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
    <?=Html::cssFile('@web/css/bootstrap.min.css')?>
    <?=Html::cssFile('@web/js/ligerUI/skins/Aqua/css/ligerui-all.css')?>
    <?=Html::cssFile('@web/css/announcemy.css')?>
    <?=Html::cssFile('@web/css/bootstrapmy.css')?>
    <?=Html::jsFile('@web/js/jquery.js')?>
    <?=Html::jsFile('@web/js/bootstrap.min.js')?>
    <?=Html::jsFile('@web/js/ligerUI/js/core/base.js')?>
    <?=Html::jsFile('@web/js/ligerUI/js/plugins/ligerTree.js')?>
    <?=Html::jsFile('@web/js/iscroll.js')?>
    <?=Html::jsFile('@web/js/htmlset.js')?>

<script>
var isiOS = false;
var isAndroid = false;
var u = navigator.userAgent, app = navigator.appVersion;
isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
//    alert('是否是Android：'+isAndroid);
//    alert('是否是iOS：'+isiOS);

function receiverSelect3(){  //教师
    var group = "<?=$model->group?>";
    if(group != "0"){
        return;
    }
    document.getElementById("modalTree").click();
    if($("#loading").css("display") == "none"){
        return;
    }
    $.get('index.php?r=admin/announce/contacts3',{},function(data){
    	//alert(JSON.stringify(data));
        if(data){
            $("#loading").css("display","none");
            tree = $("#tree1").ligerTree(data.tree);
            manager = $("#tree1").ligerGetTreeManager();
        }else{
            alert('error');
        }
    },'json');

}
function receiverSelects(){      //审批
    var group = "<?=$model->group?>";  
    document.getElementById("modalTree0").click();
    if($("#loading0").css("display") == "none"){      
        return;
    }
    $.get('index.php?r=admin/announce/contactss',{},function(data){
    	//alert(JSON.stringify(data));
        if(data){
           $("#loading0").css("display","none");
     	   tree = $("#tree2").ligerTree(data.tree);
           manager0 = $("#tree2").ligerGetTreeManager();              
        }else{
            alert('error');
        }
    },'json');

}
function selectContacts(){
    var op = {
        "name": "SelectContacts",
        "callback": "OnSelectContactsCb",
        "params": {
            "maxCount": 2000
        }
    };
 //   alert(JSON.stringify(op));
    API.send_tonative(op);
    
}
function OnSelectContactsCb(data){
//  alert(JSON.stringify(data));
    var params = data.result.params; 
    var text = "";
    var id = "";
     var avatar = "";   
 for (var i = 0; i < params.contacts.length; i++)
    {
        text += params.contacts[i].contactInfo.name + ",";
        id += params.contacts[i].contactInfo.uid + ",";
      if(typeof(params.contacts[i].contactInfo.avatar) == "undefined"){
       	    avatar += "" + ",";
            }else{
        avatar += params.contacts[i].contactInfo.avatar + ",";
           }     
  }
    if(text.length == 0){
        text = "选择接收人";
        id = 0;
        avatar = "";  
    }
//alert(JSON.stringify(avatar));
    $("#announceform-receiver").text(text.substr(0,text.length-1));
    $("#announceform-receiverid").attr("value",id);
    $("#announceform-receivername").attr("value",text);
     $("#announceform-photo").attr("value",avatar); 
   $("#announceform-receiver").css("display","block");
    return;
}
$(function(){
	//$("#announceform-receiver").click(function(){
	$("#receiverOther").click(function(){
        if(isiOS || isAndroid){
            selectContacts();
            return;
        }
		var group = "<?=$model->group?>";
		if(group != "0"){
			return;
		}
		document.getElementById("modalTree").click();
        if($("#loading").css("display") == "none"){
            return;
        }
		$.get('index.php?r=admin/announce/contacts',{},function(data){
			if(data){
                $("#loading").css("display","none");
           		tree = $("#tree1").ligerTree(data.tree);
           		manager = $("#tree1").ligerGetTreeManager();
			}else{
				alert('error');
			}
	     },'json');
	});
    if(<?=$sendSucceed?>){
        document.getElementById("sendSucceed").click();
    }
    if(isAndroid == true){
    //    $("#other").css("display","none");
        var clientType = 1; 
    }else if(isiOS == true){
     //   $("#other").css("display","none");
        var clientType = 2; 
    }else{
        var clientType = 3; 
    }
	var group = "<?=$model->group?>";
    if(group != 0){
        $("#selectType").css("display","none");
        $("#announceform-receiver").css("display","block"); 
        $("#announceform-receiver0").css("display","block"); 
    }
    $("#clientType").attr("value",clientType);
    if(clientType == 2 || clientType == 1){
//        $("#uploadImg").css("display","none");
 //       $("#upload_attach").css("display","none");
    }else{
        $("#announceform-content").css("display","none");
        $("#UEContent").css("display","block");
        $("#uploadImg").css("display","none");
    }
    if('<?=YII_ICT?>' == true){
        $("#selectType").css("display","none");
        $("#announceform-receiver").css("display","block");
        $("#announceform-receiver0").css("display","block"); 
    }

});
API.init();
function closeWebview(){
    var op = {
        "name":"CloseWebView"
    };
    API.send_tonative(op);
}
var fileId = 0;
var taskID = 0;
var fileInfo = [];
function uploadFileStart(){
    taskID++;
    var op = {
        "name": "Upload",
        "callback": "OnUploadCb",
        "params": {
            "uploadUrl": "offline_media/offline_upload.php",
            "webAppTransferID": fileId++,
            "taskID": taskID,
        }
    };
    fileInfo[taskID] = { 
        'name':'',
        'size':'',
        'path':'',
        'transferStatus':'start',
    }
//    alert(JSON.stringify(fileInfo));
 //   alert(JSON.stringify(op));
    API.send_tonative(op);
}
var closeUpload = [];
function closeModal(){
    closeUpload[taskID] = true;
    play = 0;
  	//$("#closeUpload").text('取消上传');
}
var play = 0;
function OnUploadCb(param){
    params = param.result.params; 
//    alert(JSON.stringify(params));
 //   alert(params.taskID);
    var tmp = fileInfo[params.taskID];
    //alert(JSON.stringify(tmp)+"  123");
//    alert(tmp.transferStatus);
    if(tmp){
        if(tmp.transferStatus == 'Success'){

  //          alert(JSON.stringify(tmp)+"  "+params.taskID);
            return;
        }
    }
    fileInfo[params.taskID] = { 
        'name':params.fileName,
        'size':params.size,
        'path':params.uploadPath,
        'transferStatus':params.transferStatus,
    }
    if(play == 0){
        if (params.size > 1024 * 1024){ 
            fileSize = (Math.round(params.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
        }else{ 
            fileSize = (Math.round(params.size * 100 / 1024) / 100).toString() + 'KB';
        }
        $("#up_file_name").text(params.fileName);
        $("#up_file_size").text(fileSize);
  //      document.getElementById("uploadModalBtn").click();
        $("#uploadModalBtn").trigger("click");
        play = 1;
    }
    if(params.transferStatus == "Failure"){
        var state = "上传失败";
        upload_file_end(0,state,null,fileInfo[params.taskID],params.taskID);
        return;
    }else if(params.transferStatus == "Transmission"){
        var state ="正在上传";    
    }else if(params.transferStatus == "Cancel"){
        var state = "上传已取消";
        upload_file_end(0,state,null,fileInfo[params.taskID],params.taskID);
        return;
    }else if(params.transferStatus == "Success"){
  	    var filetype = $("#announceform-filetype").attr('value');
        if(filetype == 1){
            if (!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(params.fileName)) {  
                var state= "不支持的图片类型";  
                upload_file_end(0,state,null,fileInfo[params.taskID],params.taskID);
            }else{
                var state ="上传成功";    
//    alert(JSON.stringify(params));
                upload_file_end(1,state,null,fileInfo[params.taskID],params.taskID);
            }  
        }else{
            var state ="上传成功";    
            upload_file_end(1,state,null,fileInfo[params.taskID],params.taskID);
        }
    }
}
function getChecked()
{
    var notes = manager.getChecked();
    var text = "";
    var id = "";
    var photo = "";
    for (var i = 0; i < notes.length; i++)
    {
    	if(notes[i].data.id){
	        text += notes[i].data.text + ",";
	        id += notes[i].data.id + ",";
	        photo += notes[i].data.photo + ",";
    	}
    }
    if(text.length == 0){
        text = "选择接收人";
        id = 0;
    }
    $("#announceform-receiver").text(text.substr(0,text.length-1));
    $("#announceform-receiverid").attr("value",id);
    $("#announceform-receivername").attr("value",text);
    $("#announceform-photo").attr("value",photo);
    document.getElementById("closeContacts").click();
    return true;
}
function getCheckeds()
{
    var notes = manager0.getChecked();
    var text = "";
    var id = "";
    var photo = "";
    for (var i = 0; i < notes.length; i++)
    {
    	if(notes[i].data.id){
	        text += notes[i].data.text + ",";
	        id += notes[i].data.id + ",";
	        photo += notes[i].data.photo + ",";
    	}
    }
    if(text.length == 0){
        text = "选择审批人";
        id = 0;
    }
    $("#announceform-receiver0").text(text.substr(0,text.length-1));
    $("#announceform-receiverid0").attr("value",id);
    $("#announceform-receivername0").attr("value",text);
    $("#announceform-photo0").attr("value",photo);
    document.getElementById("closeContacts0").click();
    return true;
}
function closeContactsModal(){
    $("#announceform-receiver").css("display","block");
}
function closeContactsModal0(){
    $("#announceform-receiver0").css("display","block");
}
function receivertype(){
    $("#announceform-receiver").css("display","none");
    $("#announceform-receiver0").css("display","none");
}
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

function upload_fun(x){
    var file = $('#upload_button').get(0).files[0];
  	var filetype = $("#announceform-filetype").attr('value');
    if (file) {
       
        var fileSize = 0;
        var errorSize = 0;
        var str = "";
        if (file.size > 1024 * 1024){ 
            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
            if(Math.round(file.size * 100 / (1024 * 1024)) / 100 > 200){
                str = "错误！文件不可大于200MB。";
                errorSize =1;   
            }
        }else{ 
            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
        }
        if(filetype == 1){
            if (!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(file.name)) {  
                alert("图片类型必须是.gif,jpeg,jpg,png中的一种");  
                return false;  
            }  
        }
        console.log(file.name, fileSize, file.type);
        upload_file_start(file.name,fileSize);
        if(filetype != 1){
           
            $("#uploadModalBtn").trigger("click");
            //document.getElementById("uploadModalBtn").click();
        }
        if(errorSize == 1){
            upload_file_end(0,'上传失败',str,null,null);
            return 0;
        }
    }
    $("#taskID").val(++taskID);
    document.upload_form.submit();
    var file = $('#upload_button');
    file.after(file.clone().val("")); 
    file.remove();
}
function upload_file_start(name,size){
    $("#up_file_name").text(name);
    $("#up_file_size").text(size);

}
function upload_file_end(result,state,str,fileinfo,tmpTaskID){
    if(closeUpload[tmpTaskID] == true){
        return;
    }
  	var filetype = $("#announceform-filetype").attr('value');
  	$("#closeUpload").text('关闭');
    $("#closeUpload").css('display','inline-block');
 // 	alert(filetype);
    if(result){
        $("#up_file_state").css("color","#00FF00");
    	if(filetype == 1){
            //alert(fileinfo.path);
	    	$("#contentImg").attr("src",fileinfo.path);
	    	$("#contentBigImg").attr("src",fileinfo.path);
	    	$("#contentShowimg").attr("imgsrc",fileinfo.path);
	    	$("#announceform-contentImg").attr("value",JSON.stringify(fileinfo));
	    	$("#J-showimg").css("display","block");
            $("#addImgBox").css("display",'none');
            $("#editImgBox").css("display",'block');
    	}else{
			var count = parseInt($("#announceform-attachCount").attr("value"))+1;
			if(count > 2){
				$("#upload_attach").css("display","none");
			}
    		for(var i=1;i<4;i++){
    			var display = $("#attach"+i).css("display");
    			if(display == "none"){
    				break;
    			}
    		}
			$("#attachName"+i).text(fileinfo.name);
			$("#attach"+i).css("display","block");
    		$("#announceform-attach"+i).attr("value",JSON.stringify(fileinfo));
    		$("#announceform-attachCount").attr("value",count);
    	}
    	
    }else{
        if(str != null){
            $("#errorSize").text(str);
            $("#errorSize").css("display","block");
        }
    }
    $("#up_file_state").text(state);
    
}
function file_del(id){
	$("#attach"+id).css("display","none");
	$("#announceform-attach"+id).val("");
	var count = $("#announceform-attachCount").attr("value")-1;
	$("#announceform-attachCount").attr("value",count);
	if(count < 3){
		$("#upload_attach").css("display","block");
	}
}
var isSend = false;
function send_submit(){
    if(isSend){
        return false;
    }
    $("#announceform-contBox").css("display","none");
    $("#announceform-tipBox").css("display","none");
    $("#announceform-recBox").css("display","none");
    if( $.trim($("#announceform-title").val()) == ""){
		$("#announceform-tipBox").css("display","block");
		return false;
	}else{
    }
	var group = "<?=$model->group?>";
    if(group == "0" && $("#announceform-receiverid").val() == 0 && ($("#receiverType").val() == 4 || '<?=YII_ICT?>')){
		$("#announceform-recBox").css("display","block");
		return false;
    }
	if( $.trim($("#announceform-content").val()) == "" && UE.getEditor('editor').getContent() == ""){
		$("#announceform-contBox").css("display","block");
		return false;
	}else{
    }
    isSend = true;
	$("#sendBtn").css("background-color","#e6e6e6");
    if($("#UEContent").css("display") == "block"){
        $("#announceform-content").val(UE.getEditor('editor').getContent());
        $("#announceform-UE").val(1);
    }
    document.send_form.submit();
    return false;
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
			
		</div>
	</div>
	<div id="upload_attach" class="inpBox" style="cursor:pointer;">
				<div class="btnAtta" onclick="upload_btn_click(2);">
					<i class="ficon ic_atta"></i>
					<span class="ic_text">上传附件</span>					
					<!--input type="file" name="" value="" class="btnfile"-->					
				</div>
	</div>
	<p>
			<?=$info['suporting']?>
	</p>
	<div  onclick="receiverSelects();" id="announceform-receiver0" class="inpBox nameList" style="cursor:pointer;display: none;" title="点击选择接收者">
				选择审批人
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
				<input id="announceform-contentImg" type="hidden" name="AnnounceForm[contentImg]" value="">
				<input id="announceform-attach1" type="hidden" name="AnnounceForm[attach1]" value="">
				<input id="announceform-attach2" type="hidden" name="AnnounceForm[attach2]" value="">
				<input id="announceform-attach3" type="hidden" name="AnnounceForm[attach3]" value="">
				<input id="announceform-attachCount" type="hidden" name="AnnounceForm[attachCount]" value=0>
				<input id="announceform-receiverid" type="hidden" name="AnnounceForm[receiverId]" value="">
				<input id="announceform-receivername" type="hidden" name="AnnounceForm[receiverName]" value="">
				<input id="announceform-photo" type="hidden" name="AnnounceForm[photo]" value="">
				<input id="announceform-filetype" type="hidden" name="AnnounceForm[filetype]" value="">
                <input id="announceform-group" type="hidden" name="AnnounceForm[group]" value=>
                <input id="announceform-UE" type="hidden" name="AnnounceForm[UE]" value=0>
                <input id="clientType" type="hidden" name="clientType" value=0>        
				
			</div>
			<div class="moGrid">
		<div class="btnBox">
                
			<a id="sendBtn" href="javascript:void(0);" class="btnIteam btnSubmit" style="text-decoration:none;background-color: #30BF78;" onclick='send_submit();'>				
		
            <span class="ic_text" >发&nbsp;&nbsp;布</span>
			</a>			
		</div>
	</div>			
			<div id="uploadfile" style="display:none">
		    <form name="upload_form" id="upload_form" class="upload_form"  method="post" target='upload_frame' enctype="multipart/form-data" action="">
			<!--input type="file" id="upload_button" name="upload_file" class="upload_button"  onchange="upload_fun(this.value);"-->
            <input id="taskID" type="hidden" name="taskID" value=0>
			<input type="file" id="upload_button" name="upload_file" class="upload_button"  onchange="upload_fun(this.value);">
			<iframe id="upload_frame" name="upload_frame" style="display:none"></iframe>
		    </form> 
	        </div>
	<div class="moGrid">
		<div class="btnBox">
	
		</div>
	</div>
</div>
<button id='modalTree' class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" data-backdrop="static" style="display: none;">
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style='z-index:1060'>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"  data-dismiss="modal" aria-hidden="true" onclick="closeContactsModal()">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					接收人
				</h4>
			</div>
			<div class="modal-body" style='height:350px;'>	
				<div style="width:100%; height:320px; margin:auto; #float:left; clear:both; border:1px solid #ccc; overflow:auto;  ">
				    <div id="loading" style="display:#none;padding-top:30%;padding-left:40%">
                        加载中...
				    </div>
					<ul id="tree1" style="min-width:300px"></ul>					
				</div> 
			</div>
			<div class="modal-footer">
				<button id="closeContacts" type="button" class="btn btn-default"  data-dismiss="modal" onclick="closeContactsModal()" >关闭
				</button>
			
                <button id="saveContacts" type="button" class="btn btn-primary0" onclick="getChecked()">				
            
					提交更改
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<a id="uploadModalBtn" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#uploadModal" data-backdrop="static" style="display:none">
</a>
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
	<div class="modal-dialog" style='z-index:1060'>
		<div class="modal-content">
			<div class="modal-header">
				<!--button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button-->
				<h4 class="modal-title" id="uploadModalLabel">
					上传文件
				</h4>
			</div>
            <div id="errorSize" class="alert alert-danger" style="display:none" >错误！文件不可大于200MB。</div>
			<div class="modal-body">
				<table class="table" style="table-layout:fixed;word-wrap:break-word;word-break:break-all">
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
							<td id="up_file_state" style="color:#FF0000;min-width:6em">正在上传</td>
						</tr>
					</tbody>
				</table>
				<div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="closeUpload" type="button" class="btn btn-default" style="display:none" data-dismiss="modal" onclick="closeModal()">取消上传
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<input type="hidden" id="confrimed_count" value=<?//=$confirmed_count?>></input>
<script type="text/javascript">
var win_w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
win_h =  document.documentElement.clientHeight || document.body.clientHeight || window.innerHeight,
win_scroll_top = document.documentElement.scrollTop || document.body.scrollTop;

//定义公共函数
function g( selector ){
var method = selector.substr(0,1) == '.'?'getElementsByClassName':'getElementById';
return document[method]( selector.substr(1) );
}
//处理弹出层尺寸
g('#J-showpic').style.width = win_w + 'px';
g('#J-showpic').style.height = win_h + 'px';
g('#J-showpic').style.lineHeight = win_h + 'px';

//点击显示弹出层操作
g('#J-showimg').onclick = function(){
g('#wrap').style.display = 'none';
g('#J-showpic').style.display = 'block';

document.addEventListener('DOMContentLoaded', scroller_pic('J-showwarp'), false);

}
g('#J-close').onclick = function(){
g('#wrap').style.display = 'block';
g('#J-showpic').style.display = 'none';
}

g('#J-del').onclick = function(){
g('#J-showimg').style.display = 'none';	
g('#announceform-contentImg').value = '';	
g('#wrap').style.display = 'block';
g('#J-showpic').style.display = 'none';
$("#addImgBox").css("display",'block');
$("#editImgBox").css("display",'none');
}

var myscroll_pic;
var flag = true;
function scroller_pic(ele){

setTimeout(function(){

	myscroll_pic =new iScroll(ele,{
					
		zoom:true,
		zoomMin:1,
		zoomMax:1,
		doubleTapZoom:2,
		wheelAction: 'zoom',
        momentum:false,
		hScrollbar:false, 
		vScrollbar:false,
		
		onZoomEnd:function(){
			if(this.scale>1){
				myscroll.stop();
				myscroll.enabled = false;
			}else{
				myscroll.enabled = true;
			}
			//console.log( this.scale );
		}
		
	});

 },200 );
              
}
//处理显示的图片在小格里放缩显示
function showpic(){
var box_w = '',
    img_w = '',
    img_h = '',
    index = 0,
    real_img = { w:'',h:'' };
    
var box = g('#J-showimg'),
    iteam = g('#J-showimg').getElementsByTagName('img')[0];
 
	setTimeout(function() {
		   		
		var img =  document.createElement('img');
		img.src = iteam.src;
		real_img.w = img.width;
		real_img.h = img.height;
		//console.log(real_img);
		var wh = box.clientWidth / box.clientHeight;
	var imgWh = real_img.w / real_img.h;
		
		if(wh > imgWh){
	    iteam.style.width = '100%';		        
    }else{
    	iteam.style['max-width'] = 'none';
        iteam.style.height = '100%';
    }
    
		//处理左右的值
    var left = Math.ceil( (box.clientWidth - box.firstChild.offsetWidth)/2 );
    var top = Math.ceil( (box.clientHeight - box.firstChild.offsetHeight)/2 );
    
    if(wh > imgWh){
        iteam.style['-webkit-transform'] = 'translateY('+top+'px)';		        
    }else{
    	iteam.style['-webkit-transform'] = 'translateX('+left+'px)';	
    }  
	
	},100);
	

}
showpic();
//$("[name='AnnounceForm[top]']").bootstrapSwitch();
var ue = UE.getEditor('editor');
function getContent() {
var arr = [];
arr.push("使用editor.getContent()方法可以获得编辑器的内容");
arr.push("内容为：");
arr.push(UE.getEditor('editor').getContent());
alert(arr.join("\n"));
}
</script>
</body>
</html>




