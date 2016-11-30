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
    <?=Html::cssFile('@web/js/ligerUI/skins/Aqua/css/ligerui-all.css')?>
    <?=Html::cssFile('@web/css/announce.css')?>
    <?//=Html::cssFile('@web/css/bootstrap-switch.min.css')?>
    <?=Html::jsFile('@web/js/jquery.js')?>
    <?=Html::jsFile('@web/js/bootstrap.min.js')?>
    <?=Html::jsFile('@web/js/ligerUI/js/core/base.js')?>
    <?=Html::jsFile('@web/js/ligerUI/js/plugins/ligerTree.js')?>
    <?=Html::jsFile('@web/js/iscroll.js')?>
    <?=Html::jsFile('@web/js/htmlset.js')?>
    <?=Html::jsFile('@web/ueditor/ueditor.config.js')?>
    <?=Html::jsFile('@web/ueditor/ueditor.all.min.js')?>
    <?//=Html::jsFile('@web/js/bootstrap-switch.min.js')?>
</head>
<style>
.l-tree .l-tree-icon-none img {
    margin-bottom: 4px;
    border: 0;
    height: 16px;
    width: 16px;
    top: 2px;
    margin-left: 2px;
}

.l-tree li .l-body{
height: 42px;
line-height: 22px;
overflow: hidden;
width: 2000px;
font-size:12pt;
}
.btn-primary0,.btn-primary0:hover, .btn-primary0:focus, .btn-primary0.focus, .btn-primary0:active, .btn-primary0.active, .open>.dropdown-toggle.btn-primary0 {
color: #fff;
background-color: #ffacad;
border-color: #ffacad;
}
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
border-radius:13px;		
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
    width: 1.225em;
    height: 1.225em;
    border: 0.175em #D1EAFC solid;
    background: #4bb1ff;
}
.mcurrent{margin:10px 20px 0px 20px;}
.note0{display:inline-block;margin-left:10px;color:#4bb1ff;vertical-align:top;}
</style>
<script>
var isiOS = false;
var isAndroid = false;
var u = navigator.userAgent, app = navigator.appVersion;
isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
//    alert('是否是Android：'+isAndroid);
//    alert('是否是iOS：'+isiOS);

function receiverSelects(){      //汇报对象
    document.getElementById("modalTree").click();
    if($("#loading").css("display") == "none"){      
        return;
    }
    $.get('index.php?r=admin/taskdetail/contacts',{},function(data){
    	//alert(JSON.stringify(data));
        if(data){
        	//alert(JSON.stringify(data.tree));
           $("#loading").css("display","none");
     	   tree = $("#tree").ligerTree(data.tree);
           manager = $("#tree").ligerGetTreeManager();              
        }else{
            alert('error');
        }
    },'json');

}
function receiverSelectzp(){      //指派对象
    document.getElementById("modalTreezp").click();
    if($("#loading").css("display") == "none"){      
        return;
    }
    $.get('index.php?r=admin/taskdetail/contactzp',{},function(data){
    	//alert(JSON.stringify(data));
        if(data){
        	//alert(JSON.stringify(data.tree));
           $("#loadingzp").css("display","none");
     	   tree = $("#treezp").ligerTree(data.tree);
           manager = $("#treezp").ligerGetTreeManager();              
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
   $("#announceform-receiver").css("display","none");
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
        //$("#announceform-receiver").css("display","block"); 
        $("#announceform-receiver0").css("display","block"); 
    }
    $("#clientType").attr("value",clientType);

    if('<?=YII_ICT?>' == true){
        $("#selectType").css("display","none");
        //$("#announceform-receiver").css("display","block");
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
function getCheckedzp()   //指派
{
    var notes = manager.getChecked();
    var text = "";
    var id = "";
    var photo = "";
    //alert(notes[0].data.id);
    //alert(notes[1].data.id);
    //console.log(JSON.stringify(notes));
    console.log(notes);
    if(notes.length == 0){
        text = "请选择 ";
        id = 0;
        document.getElementById("closeContactszp").click();
        return true;
    }else 
    if(notes[0].data.id){
   	     if(notes.length>1){
	     alert("只能指派一人！");return;
	     }
    }else{
    	if(notes.length>2){
      	     alert("只能指派一人！");return;
      	 }
    }  
    for (var i = 0; i < notes.length; i++)
    {
    	if(notes[i].data.id){
	        text += notes[i].data.text + ",";
	        id += notes[i].data.id + ",";
	        photo += notes[i].data.photo + ",";
    	}
    }

    var geturl = "index.php?r=admin/taskdetail/savezp1&uid="+id+"&id="+"<?=$taskId?>"; 	       
	geturl = encodeURI(encodeURI(geturl));
	window.location.href =geturl;	
	return false;	
    //$("#announceform-receiveridzp").attr("value",id);
    document.getElementById("closeContactszp").click();
    return true;
}
function getCheckeds()
{
    var notes = manager.getChecked();
    var text = "";
    var id = "";
    var photo = "";
    //alert(notes[0].data.id);
    //alert(notes[1].data.id);
    //console.log(JSON.stringify(notes));
   
    if(notes.length == 0){      
        text = "请选择 ";
        id = 0;
    }else
    if(notes[0].data.id){
   	     if(notes.length>1){
	     alert("只能选择一人审核！");return;
	     }
    }else{
    	if(notes.length>2){
      	 alert("只能选择一人审核！");return;
      	 }
    }  
    for (var i = 0; i < notes.length; i++)
    {
    	if(notes[i].data.id){
	        text += notes[i].data.text + ",";
	        id += notes[i].data.id + ",";
	        photo += notes[i].data.photo + ",";
    	}
    }

    $("#announceform-receiver").text(text.substr(0,text.length-1));
    $("#announceform-receiverid").attr("value",id);
    $("#announceform-receivername").attr("value",text);
    $("#announceform-photo").attr("value",photo);
    document.getElementById("closeContacts").click();
    return true;
}
function closeContactsModal(){
    $("#announceform-receiver").css("display","block");
}
function closeContactsModalzp(){
    $("#announceform-receiverzp").css("display","block");
}
function receivertype(){
    $("#announceform-receiver").css("display","none");
}
function upload_btn_click(filetype){//上传文件2
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
        //console.log(file.name, fileSize, file.type);
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
			if(count > 9){
				$("#upload_attach").css("display","none");
			}
    		for(var i=1;i<11;i++){
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
	if(count < 10){
		$("#upload_attach").css("display","block");
	}
}
function file_del0(id){
	//alert(id);
	if(confirm("确定删除吗？")){
	$.get('index.php?r=admin/taskalter/del',{attachid:id,id:<?=$taskId?>},function(data){
		if(data){
			$("#fujian"+id).css("display","none"); 
		}else{
			alert('error');
		}
     },'json');
	}
}
var isSend = false;
function send_submit(){
    if(isSend){
        return false;
    }
    $("#announceform-contBox").css("display","none");
    $("#announceform-recBox").css("display","none");    
    if( $.trim($("#announceform-content").val()) == ""){
		$("#announceform-contBox").css("display","block");
		return false;
	}
    if($("#announceform-receiverid").val() == 0){
		//$("#announceform-recBox").css("display","block");
		//return false;
 	  // if(confirm("您确定不需要汇报吗？")){
  		   isSend = true;
		   $("#sendBtn").css("background-color","#e6e6e6");
		   document.send_form.submit();
		   return false;
	       //return true;
	  //  }else{
	  //     return false;
	  //  }
    }
    isSend = true;
	$("#sendBtn").css("background-color","#e6e6e6");
    document.send_form.submit();
    return false;
}


</script>
<body class="bg_white">	
<div id="wrap" class="wrap">
	<div id="announceform-contBox" class="tipBox" style="display:none">		
		<div class="tipInner">
			<i class="ficon ic_wanning"></i>正文不能为空
		</div>
	</div>	
	<div id="announceform-recBox" class="tipBox" style="display:none">		
		<div class="tipInner">
			<i class="ficon ic_wanning"></i>请选择接收人
		</div>
	</div>
	<form name="send_form" id="send_form" method="post" enctype="multipart/form-data" action="index.php?r=admin/taskalter/save">   
	<div class="moGrid">
		<div class="formBox">			
   <div class="moGrid" style="padding-bottom:0px;width:100%">		
		<div class="header">
			<h4><?=$info['content']?></h4>
			<span style="display:block;margin-top:10px;color:#4B71E2;font-size:11pt"><?php if($info['editflag']=="1"):?>待修改<?else:?>
			<?php if($info['approverId']==""):?>已完成<?else:?>
			<?=$name0?><?php if($info['taskstate']=="1"):?>（审核中）<?elseif($info['taskstate']=="2"):?>（已通过）<?elseif($info['taskstate']=="3"):?>（未通过）
			<?endif?><?endif?>
			<?endif?>	
			</span>
			<span class="fl" style="margin-top:10px;color:#727272">考核时间：<?=$info['starttime']?>至<?=$info['endtime']?></span> 			
		    <?php if($zp==0):?>
		    <a href="javascript:void(0);" onclick="receiverSelectzp();" id="announceform-receiverzp" class="button0"><span style="display:inline-block;margin-top:3px;font-size:10pt">指派给他人</span></a>
            <?endif?>
		</div>
	</div>           	
	<hr>				
			<div class="inpBox">				
			<span style="display:inline-block;top:10px">汇报内容：</span><textarea id="announceform-content" class="txtare" name="AnnounceForm[content]" style="-webkit-tap-highlight-color:rgba(0,0,0,0);height: 150px;width:75%" placeholder="请输入汇报的具体内容（必填）" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'"><?=$info['taskcontent']?></textarea>		            		
			</div>			
			<!--	描述：上传附件的按钮            -->
			
			<div id="upload_attach" class="inpBox" style="margin-top:15px;cursor:pointer;">
				<div class="btnAtta" onclick="upload_btn_click(2);">
					<i class="ficon ic_atta"></i>
					<span class="ic_text">上传附件</span>					
					<!--input type="file" name="" value="" class="btnfile"-->					
				</div>
				<span  style="display:inline-block;margin-top:5px;margin-left:10px;color:#a2a2a2">点击上传文件</span>
			</div>
			<!--end 上传附件按钮-->
			<p style="margin-top:15px;margin-left:15px;;color:#727272">
			<?=$info['suporting']?>
		    </p>		   
<div class="moGrid" style="margin:0;width:100%" id="attaBox">	
	<?php if($attachList!=""):?> 	
		  <?php foreach ($attachList as $key=>$value): ?>
		  <div id="fujian<?=$key?>" style="background: #f8f8f8;width:100%;margin-bottom: .625em;padding:10px">
            <div href="#" style="display:inline-block;cursor:pointer;width:85%" onclick='download_file("<?=$value['path']?>","<?=$value['name']?>","<?=$value['size']?>","<?=$value['url']?>");'>
				<i class="ficon ic_file"></i><?=$value['name']?>
			</div>
			<div class="ficon ic_x fr" style='cursor:pointer;display:inline-block;width:13%;text-align:right;padding-right:3px;height:30px' onclick="file_del0('<?=$key?>')"></div>				
		  </div>	
			<? endforeach?>					
	<?endif?>
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
								
				<div id="attach4" href="#" class="attaIteam" style="display:none;">
					<div class="ficon ic_x fr" style='cursor:pointer;' onclick='file_del(4)'></div>
					<i id="attachName4" class="ficon ic_file"></i>
				</div>
				
				<div id="attach5" href="#" class="attaIteam" style="display:none;">
					<div href="#" class="ficon ic_x fr" style='cursor:pointer;'  onclick='file_del(5)'></div>
					<i id="attachName5" class="ficon ic_file"></i>
				</div>

				<div id="attach6" href="#" class="attaIteam" style="display:none;">
					<div href="#" class="ficon ic_x fr" style='cursor:pointer;' onclick='file_del(6)'></div>
					<i id="attachName6" class="ficon ic_file"></i>
				</div>
				
				<div id="attach7" href="#" class="attaIteam" style="display:none;">
					<div class="ficon ic_x fr" style='cursor:pointer;' onclick='file_del(7)'></div>
					<i id="attachName7" class="ficon ic_file"></i>
				</div>
				
				<div id="attach8" href="#" class="attaIteam" style="display:none;">
					<div href="#" class="ficon ic_x fr" style='cursor:pointer;'  onclick='file_del(8)'></div>
					<i id="attachName8" class="ficon ic_file"></i>
				</div>

				<div id="attach9" href="#" class="attaIteam" style="display:none;">
					<div href="#" class="ficon ic_x fr" style='cursor:pointer;' onclick='file_del(9)'></div>
					<i id="attachName9" class="ficon ic_file"></i>
				</div>
				<div id="attach10" href="#" class="attaIteam" style="display:none;">
					<div href="#" class="ficon ic_x fr" style='cursor:pointer;' onclick='file_del(10)'></div>
					<i id="attachName10" class="ficon ic_file"></i>
				</div>
			</div>
			<!--end 结束附件框-->
            <hr>
            <h4 style="margin-bottom: 15px;display:none">汇报对象</h4>
			<div  onclick="receiverSelects();" id="announceform-receiver" class="inpBox nameList" style="cursor:pointer;display:none" title="点击选择接收者">
				<img style="width:50px;" src="../web/img/add.png">
			</div>
			<div style="#display: none;">
				<input id="announceform-contentImg" type="hidden" name="AnnounceForm[contentImg]" value="">
				<input id="announceform-attach1" type="hidden" name="AnnounceForm[attach1]" value="">
				<input id="announceform-attach2" type="hidden" name="AnnounceForm[attach2]" value="">
				<input id="announceform-attach3" type="hidden" name="AnnounceForm[attach3]" value="">
				<input id="announceform-attach4" type="hidden" name="AnnounceForm[attach4]" value="">
				<input id="announceform-attach5" type="hidden" name="AnnounceForm[attach5]" value="">
				<input id="announceform-attach6" type="hidden" name="AnnounceForm[attach6]" value="">
				<input id="announceform-attach7" type="hidden" name="AnnounceForm[attach7]" value="">
				<input id="announceform-attach8" type="hidden" name="AnnounceForm[attach8]" value="">
				<input id="announceform-attach9" type="hidden" name="AnnounceForm[attach9]" value="">
				<input id="announceform-attach10" type="hidden" name="AnnounceForm[attach10]" value="">
				<input id="announceform-attachCount" type="hidden" name="AnnounceForm[attachCount]" value=0>
				<input id="announceform-receiverid" type="hidden" name="AnnounceForm[receiverId]" value="<?=$model->receiverId?>">
				<input id="announceform-receivername" type="hidden" name="AnnounceForm[receiverName]" value="<?=$model->receiver?>">
				<input id="announceform-photo" type="hidden" name="AnnounceForm[photo]" value="">
				<input id="announceform-filetype" type="hidden" name="AnnounceForm[filetype]" value="">
                <input id="announceform-group" type="hidden" name="AnnounceForm[group]" value=<?=$model->group?>>
                <input id="announceform-taskId" type="hidden" name="AnnounceForm[taskId]" value=<?=$taskId?>>	
                <input id="clientType" type="hidden" name="clientType" value=0>			               	
			</div>
            <div>       
            </div>					
		</div>
	</div>
	</form>
<div style="padding-bottom:40px;background-color:#fff">
<span style="display:inline-block;margin-left:20px;">流程跟踪</span>
<?php foreach ($list as $key=>$value): ?>
<div class="mcurrent">
	<span class="note"></span><span class="note0">
<?=$name0;?><?php if($value['comment']=="1"):?>审阅中...<?elseif($value['comment']=="2"):?>已通过。<?elseif($value['comment']=="3"):?>未通过。<?endif?>	
	</span>	
</div>
<?php if($value['commentcontent']!=""):?>
<span style="display:inline-block;margin:5px 10px 0px 20px;font-size:11pt;color:#929292">(意见：<?=$value['commentcontent']?>)</span>	
<?endif?>
<?endforeach?>	
</div>
	<div class="moGrid">
		<div class="btnBox">                    
			<a id="sendBtn" href="javascript:void(0);" class="btnIteam btnSubmit" style="text-decoration:none;background-color: #ffacad;width:90%;-webkit-border-radius:10px;border-radius: 10px;" onclick='send_submit();'>							
            <span class="ic_text" >提&nbsp;&nbsp;交</span>
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
</div>
<button id='modalTreezp' class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalzp" data-backdrop="static" style="display: none;">
</button>
<div class="modal fade" id="myModalzp" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style='z-index:1060'>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"  data-dismiss="modal" aria-hidden="true" onclick="closeContactsModalzp()">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					接收人
				</h4>
			</div>
			<div class="modal-body" style="height:350px;">	
				<div style="width:100%; height:320px; margin:auto; #float:left; clear:both; border:1px solid #ccc; overflow:auto;  ">
				    <div id="loadingzp" style="display:#none;padding-top:30%;padding-left:40%;">
                        加载中...
				    </div>					
					<ul id="treezp" style="min-width:300px;line-height:2.5em"></ul>
				</div> 
			</div>
			<div class="modal-footer">
				<button id="closeContactszp" type="button" class="btn btn-default"  data-dismiss="modal" onclick="closeContactsModalzp()" >关闭
				</button>
				<button id="saveContacts" type="button" class="btn btn-primary0" onclick="getCheckedzp()">
					提交更改
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
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
			<div class="modal-body" style="height:350px;">	
				<div style="width:100%; height:320px; margin:auto; #float:left; clear:both; border:1px solid #ccc; overflow:auto;  ">
				    <div id="loading" style="display:#none;padding-top:30%;padding-left:40%;">
                        加载中...
				    </div>					
					<ul id="tree" style="min-width:300px;line-height:2.5em"></ul>
				</div> 
			</div>
			<div class="modal-footer">
				<button id="closeContacts" type="button" class="btn btn-default"  data-dismiss="modal" onclick="closeContactsModal()" >关闭
				</button>
				<button id="saveContacts" type="button" class="btn btn-primary0" onclick="getCheckeds()">
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
<a id="sendSucceed" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#sendModal" data-backdrop="static" style="display:none">
</a>
<div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="sendModalLabel" aria-hidden="true">
	<div class="modal-dialog" style='z-index:1061'>
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="sendModalLabel">
				</h4>
			</div>
			<div class="modal-body">
				<div style="text-align: center;">
                    发送成功！
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeWebview()">确定
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
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
var cls;
var u = navigator.userAgent, app = navigator.appVersion;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
API.init();
function download_file(file,name,size,url){
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
//$("[name='AnnounceForm[top]']").bootstrapSwitch();

</script>
</body>
</html>
