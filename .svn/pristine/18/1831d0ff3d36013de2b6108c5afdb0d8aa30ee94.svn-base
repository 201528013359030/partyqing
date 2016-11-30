<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>
<style type="text/css">
.text-right {
	padding-top:8px;
	font-size: 16px;
}
.col-md-1,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-md-10{
	padding-right: 0px;
}
.row{
	padding-top:10px;
}
.modal-footer {
  text-align: center;
}
</style>
<head>


</head>

<script>

$(function(){
	$("#announceform-receiver").click(function(){
		$.get('index.php?r=admin/announce/contacts',{},function(data){
			if(data){
           		tree = $("#tree1").ligerTree(data.tree);
           		manager = $("#tree1").ligerGetTreeManager();
				document.getElementById("modalTree").click();
			}else{
				alert('error');
			}
	     },'json');
	});

	var ue = UE.getEditor('editor');

});
function getContent() {
    var arr = [];
    arr.push("使用editor.getContent()方法可以获得编辑器的内容");
    arr.push("内容为：");
    arr.push(UE.getEditor('editor').getContent());
    alert(arr.join("\n"));
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
    $("#announceform-receiver").attr("value",text);
    $("#announceform-receiverid").attr("value",id);
    $("#announceform-photo").attr("value",photo);
}
function upload_btn_click(){
  //  $("#upload_button").click();
    document.getElementById("upload_button").click();
}

function upload_fun(x){
    var file = $('#upload_button').get(0).files[0];
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
        console.log(file.name, fileSize, file.type);
        upload_file_start(file.name,fileSize);
        document.getElementById("uploadModalBtn").click();
        if(errorSize == 1){
            upload_end(0,'上传失败',str);
            return 0;
        }
    }
    document.upload_form.submit();
 //   var file = $('#upload_img');
//    file.after(file.clone().val("")); 
//    file.remove();
}
function upload_file_start(name,size){
    $("#up_file_name").text(name);
    $("#up_file_size").text(size);

}
function upload_end(result,state,str,fileinfo){
  //  sleep(1000);
  	alert(JSON.stringify(fileinfo));
    if(result){
        $("#up_file_state").css("color","#00FF00");
    	$("#announceform-attach").attr("value",JSON.stringify(fileinfo));
    }else{
        $("#errorSize").text(str);
        $("#errorSize").css("display","block");
    }
    $("#up_file_state").text(state);
    
}


</script>

<div style="height:50px">
</div>
<?php $form = ActiveForm::begin([
	'action' => ['announce/save'],
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-md-5\">{input}</div>\n<div class=\"col-md-5\">{error}</div>",
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ],
]); ?>

<?=$form->field($model, 'type')->dropDownList(['1'=>'普通公告','2'=>'企业动态'],['style'=>'width:120px']) ?>
<?=$form->field($model, 'title')->textInput(["placeholder"=>"标题"]); ?>
<?=$form->field($model, 'receiver')->textInput(); ?>
<?=$form->field($model, 'content')->textarea(['rows'=>1]); ?>

<div style="display: none;">
	<?=$form->field($model, 'attach')->hiddenInput(['value'=>'0']) ?>
	<?=$form->field($model, 'receiverId')->hiddenInput(['value'=>'0']) ?>
	<?=$form->field($model, 'photo')->hiddenInput(['value'=>'0']) ?>
</div>
<div class="row">
	<div class="col-md-2">
	</div> 
	<div class="col-md-8">
		<div>
			<div>
				<script id="editor" type="text/plain" style="width:600px;height:300px;">这里是正文</script>
			</div>
			<div id="btns">
			    <div>
			        <button onclick="getContent()">获得内容</button>

			    </div>
			</div>
		</div>
	</div>
	<div class="col-md-2"> 
	</div> 
</div>
<div class="row">
	<div class="col-md-2">
	</div> 
	<div class="col-md-8">
		<a href="#" onclick="upload_btn_click();">上传附件</a>
	</div>
	<div class="col-md-2"> 
	</div> 
</div>
<div class="row">
	<div class="col-md-2">
	</div> 
	<div class="col-md-8">
	<p>
		<?= Html::submitButton('发布', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
		<?= Html::resetButton('重置', ['class'=>'btn btn-default','name' =>'submit-button']) ?>
	</p>
	</div>
	<div class="col-md-2"> 
	</div> 
</div>
<?php ActiveForm::end();?>

<div id="uploadfile" style="display:none">
	<form name="upload_form" id="upload_form" class="upload_form"  method="post" target='upload_frame' enctype="multipart/form-data" action="">
		<input type="file" id="upload_button" name="upload_file" class="upload_button"  onchange="upload_fun(this.value);">
		<iframe id="upload_frame" name="upload_frame" style="display:none"></iframe>
	</form> 
</div>

<button id='modalTree' class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" #data-backdrop="static" style="display: none;">
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style='z-index:1060'>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					接收人
				</h4>
			</div>
			<div class="modal-body" style='height:350px;'>	
				<div style="width:400px; height:320px; margin:auto; #float:left; clear:both; border:1px solid #ccc; overflow:auto;  ">
					<ul id="tree1"></ul>
				</div> 
				<div style="display:none">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"  data-dismiss="modal">关闭
				</button>
				<button id="saveContacts" type="button" class="btn btn-primary" onclick="getChecked()">
					提交更改
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
					上传文件
				</h4>
			</div>
            <div id="errorSize" class="alert alert-danger" style="display:none" >错误！文件不可大于200MB。</div>
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
							<td id="up_file_state" style="color:#FF0000;min-width:6em">正在上传</td>
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





