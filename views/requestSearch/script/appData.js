//http://192.168.139.11/mycrm/frontend/web/index.php?r=api/mdview&id=44

/*
 * @ getRequestList
 * @ 说明：获取意见反馈列表
 * @ parameter json参数说明：
 *  title	false	string	查询条件
	date	false	string	查询条件
	page	false	string	第几页
	status	false	string	0未处理，1已处理
 */
function getRequestList(parameter){
	var arr = {
		"auth_token":sessionStorage.getItem("NATIVE_AUTH_TOKEN"),
		"uid":sessionStorage.getItem("NATIVE_UID"),
		"title":parameter.title||"",
		"date":parameter.date||"",
		"page":parameter.page||"",
		"status":parameter.status||""
	};
	
	//console.log("getRequestList parameter:"+ JSON.stringify(arr));
	var results = commonFun.getJsonResult( "list",arr );
	
	if( /error/.test(results) ){
		$.toast("获取getRequestList有异常，请重试", "cancel");
		console.log("获取   方法名   报错："+results);
		return false;
	}else{
		return results
	}
	
}
function getUserinfo(){
	var arr = {
		"auth_token":sessionStorage.getItem("NATIVE_AUTH_TOKEN"),
		"uid":sessionStorage.getItem("NATIVE_UID")
	};
	var results = commonFun.getJsonResult("user.info",arr);
	if( /error/.test(results) ){
		$.toast("获取getUserinfo有异常，请重试", "cancel");
		console.log("获取   方法名   报错："+results);
		return false;
	}else{
		return results
	}
}
//提交意见反馈
function updateRequest(parameter){
	var str_file = JSON.stringify(parameter.file);
	var arr = {
		"auth_token":sessionStorage.getItem("NATIVE_AUTH_TOKEN"),
		"uid":sessionStorage.getItem("NATIVE_UID"),
		"title":parameter.title,
		"type":parameter.type,
		"content":parameter.content,
		"phone":parameter.contact,
		"senderName":parameter.senderName,
		"company":parameter.company,
		"file":str_file
	};
	//alert(JSON.stringify(arr));
	var results = commonFun.getJsonResult( "submit",arr );
	if( /error/.test(results) ){
		$.toast("获取updateRequest有异常，请重试", "cancel");
		console.log("获取   方法名   报错："+results);
		return false;
	}else{
		return results
	}
}

function updateAppend(id,text){
	var arr = {
		"auth_token":sessionStorage.getItem("NATIVE_AUTH_TOKEN"),
		"uid":sessionStorage.getItem("NATIVE_UID"),
		"id":id,
		"text":text
	};
	var results = commonFun.getJsonResult( "append",arr );
	if( /error/.test(results) ){
		$.toast("获取updateAppend有异常，请重试", "cancel");
		console.log("获取   方法名   报错："+results);
		return false;
	}else{
		return results
	}
}

function updateAnswerProgress(id,progress){
	var arr = {
		"auth_token":sessionStorage.getItem("NATIVE_AUTH_TOKEN"),
		"uid":sessionStorage.getItem("NATIVE_UID"),
		"id":id,
		"answer":"",
		"progress":progress
	};
	var results = commonFun.getJsonResult( "answer",arr );
	if( /error/.test(results) ){
		$.toast("获取updateAnswerProgress有异常，请重试", "cancel");
		console.log("获取   方法名   报错："+results);
		return false;
	}else{
		return results
	}
}

function updateAnswer(id,answer){
	var arr = {
		"auth_token":sessionStorage.getItem("NATIVE_AUTH_TOKEN"),
		"uid":sessionStorage.getItem("NATIVE_UID"),
		"id":id,
		"answer":answer,
		"progress":""
	};
	var results = commonFun.getJsonResult( "answer",arr );
	if( /error/.test(results) ){
		$.toast("获取updateAnswer有异常，请重试", "cancel");
		console.log("获取   方法名   报错："+results);
		return false;
	}else{
		return results
	}
}

function getRequestInfo(id){
	var arr = {
		"auth_token":sessionStorage.getItem("NATIVE_AUTH_TOKEN"),
		"uid":sessionStorage.getItem("NATIVE_UID"),
		"id":id
	};
	var results = commonFun.getJsonResult( "info",arr );
	if( /error/.test(results) ){
		$.toast("获取getRequestInfo有异常，请重试", "cancel");
		console.log("获取   方法名   报错："+results);
		return false;
	}else{
		return results
	}
}

function getRequestType(){
	var arr = {
		"auth_token":sessionStorage.getItem("NATIVE_AUTH_TOKEN"),
		"uid":sessionStorage.getItem("NATIVE_UID")
	};
	var results = commonFun.getJsonResult( "question.type",arr );
	//var results = {"1":"政府服务窗口质量差","2":"乱收费乱罚款乱检查"};
	if( /error/.test(results) ){
		$.toast("获取question.type有异常，请重试", "cancel");
		console.log("获取   方法名   报错："+results);
		return false;
	}else{
		
		var resultsType =[];
		for(var p in results){
			var iteam = {};
			iteam.value = p;
			iteam.title = results[p];
			resultsType.push(iteam);
		}
		//console.log(resultsType);
		return resultsType
	}
}

/*
 * @ renderRequestList 渲染意见反馈列表
 */
function renderRequestList( results ){
	var tpl = $("#tpl_request").html();
	var html = [];
	for( var i=0; i<results["list"].length; i++ ){			
		var _html = tpl
		.replace( /\{qID\}/g,results.list[i].qID )
		.replace( /\{title\}/g,results.list[i].title )
		.replace( /\{createTime\}/g,results.list[i].createTime );
		html.push(_html);
	}
	return html;
}
//渲染生成附件
function renderAttach( results ){
	
	var tpl = $("#tpl_attach").html();
	var html =[];
	for(var i=0; i<results.length; i++){
		var _html = tpl
		.replace( /\{name\}/g,results[i].name )
		.replace( /\{size\}/g,results[i].size )
		.replace( /\{path\}/g,results[i].path);
		html.push(_html);
	}
	return html;
}

function renderModel(results){
	var tpl_model = $("#tpl_model").html(),
		tpl_askMore =  $("#tpl_askMore").html(),
		tpl_attachIteam =  $("#tpl_attachIteam").html();
	var html_attach = [],
		html_askMore = [],
		html = "";
	var data_attach = results.attach;
	if(data_attach.length>0){
		for(var i=0; i<data_attach.length;i++){
			var _attach = tpl_attachIteam
			.replace( /\{name\}/g,data_attach[i].name )
			.replace( /\{size\}/g,data_attach[i].size )
			.replace( /\{path\}/g,data_attach[i].path );
			html_attach.push(_attach);
		}		
	}
	//console.log(data_attach);
	var html = tpl_model
	.replace( /\{title\}/g,results.title )
	.replace( /\{senderName\}/g,results.senderName )
	.replace( /\{phone\}/g,results.phone )
	.replace( /\{type\}/g,results.type )
	.replace( /\{createTime\}/g,results.createTime )
	.replace( /\{company\}/g,results.company )
	.replace( /\{status\}/g,status==1?'<i class="second_col">已处理</i>':'<i class="dangerous_col">未处理</i>')
	.replace( /\{content\}/g,results.content )
	.replace( /\{attach\}/g,html_attach.join("") );
	return html;
	
}

function renderAskMore(results){
	
	var tpl_askMore =  $("#tpl_askMore").html();
	var html = [];
	for( var i=0; i<results.length;i++ ){
		var _html = tpl_askMore
		.replace( /\{text\}/g,results[i].text );
		html.push(_html);
	}
	
	return html;
}

function renderAnswer( results ){
	var tpl_answer = $("#tpl_answer").html();
	var html="";
	html = tpl_answer
	.replace( /\{name\}/g,results.name )
	.replace( /\{time\}/g,results.time )
	.replace( /\{text\}/g,results.text );
	return html;
}

function renderAnswerMore(results){
	var tpl_askMore =  $("#tpl_answerMore").html();
	var html = [];
	//i=1 因为第一条为标准的答案
	for( var i=1; i<results.length;i++ ){
		var _html = tpl_askMore
		.replace( /\{name\}/g,results[i].name )
		.replace( /\{time\}/g,results[i].time )
		.replace( /\{text\}/g,results[i].text );
		html.push(_html);
	}
	return html;
}

function renderProgress(results){
	
	var tpl_progress =  $("#tpl_progress").html();
	var html = [];
	for( var i=0; i<results.length;i++ ){
		var _html = tpl_progress
		.replace( /\{text\}/g,results[i].text )
		.replace( /\{time\}/g,results[i].time );
		
		html.push(_html);
	}
	
	return html;
}


var page_undo = 1,
	page_over = 1;
	page_search = 1;
var undo_flag = true,
	over_flag = true,
	search_flag = true;

//获取未处理列表
function setRequestUndo(obj){
	var parameter = {
		"page":page_undo,
		"status":"0"
	}
	//console.log("setRequestUndo parameter:"+JSON.stringify(parameter));
	var results = getRequestList(parameter);
	//var results = {"list":[]};
	if(results["list"].length<1){
		var html_undo = commonFun.dataEmpty("nodata","暂时没有问题","欢迎您提出宝贵意见");
		$(".page_innerContent "+obj).append(html_undo);
		pullOverUndo( ".tabUndo" );
		return false;
	}
	//获取当前页数		
	var html = renderRequestList(results);
	$(".page_innerContent "+obj).append(html);
	
	var pagecount = results.pagecount;
	//console.log("pagecount:"+pagecount+"page_undo:"+page_undo);
	if(pagecount==page_undo){
		pullOverUndo( ".tabUndo" );
		undo_flag = false;
	}else{
		pullOverMore( ".tabUndo" );
		page_undo++;
		undo_flag = true;
	}
	
}
//获取已处理列表
function setRequestOver(obj){
	var parameter = {
		"page":page_over,
		"status":"1"
	}
	var results = getRequestList(parameter);
	if(results["list"].length<1){
		var html_over = commonFun.dataEmpty("nodata","暂时没有问题","我们会积极的帮您解决问题，感谢您的宝贵时间");
		$(".page_innerContent "+obj).append(html_over);
		pullOverUndo( ".tabOver" );
		return false;
	}
	var html = renderRequestList(results);
	$(".page_innerContent "+obj).append(html);
	var pagecount = results.pagecount;
	
	if(pagecount==page_over){
		pullOverUndo( ".tabOver" );
		over_flag = false;
	}else{
		pullOverMore( ".tabOver" );
		page_over++;
		over_flag = true;
	}	
}

//获取搜索列表
function setRequestSearch(obj,title,status){
	var parameter = {
		"title":title,
		"page":page_search,
		"status":status
	};
	//console.log("setRequestSearch parameter:"+JSON.stringify(parameter));
	var results = getRequestList(parameter);
	
	if(results["list"].length<1){
		var html_search = commonFun.dataEmpty("nodata","没有搜索结果","没有找到相关的问题");
		$(".page_innerContent "+obj).append(html_search);
		pullOverUndo( ".tabSearch" );
		return false;
	}
	var html = renderRequestList(results);
	$(".page_innerContent "+obj).append(html);
	var pagecount = results.pagecount;
	console.log("pagecount:"+pagecount+"page_search:"+page_search);
	if(pagecount==page_search){
		pullOverUndo( ".tabSearch" );
		search_flag = false;
	}else{
		pullOverMore( ".tabSearch" );
		page_search++;
		search_flag = true;
	}
}

//加载详细页面
function setRequestInfo(id){
	//获取页面数据
	var results = getRequestInfo(id);
	//渲染页面问题model	
	var data_model = results.model,
		data_answer = results.answer,
		data_progress = results.progress,
		data_append = results.append;
		
	var html_model = renderModel(data_model);
	$("#J_model").html(html_model);
	//console.log(data_progress);
	if(data_progress.length>0){
		var html_progerss = renderProgress(data_progress);
		$(".page_innerContent #J_progress").append(html_progerss.join(""));
		$(".page_innerContent #J_progress").css("display","block");
	}else{
		$(".page_innerContent #J_progress").css("display","none");
	}
	
	if(data_answer.length>0){
		var html_answer = renderAnswer(data_answer[0]);
		$(".page_innerContent #J_answer").append(html_answer);		
		$(".page_innerContent #J_answer").css("display","block");
		if(data_answer.length>1){
			var html_more = renderAnswerMore(data_answer);
			$(".page_innerContent #J_answerMore").append(html_more);
		}
	}else{
		$(".page_innerContent #J_answer").css("display","none");
	}
	console.log(data_append.length);
	if(data_append.length>0){
		var html_append = renderAskMore(data_append);
		$(".page_innerContent #J_askMore").append(html_append);
		$(".page_innerContent #J_askMore").css("display","block");
	}else{
		$(".page_innerContent #J_askMore").css("display","none");
	}
	
}

//设置显示
function pullOverMore( obj ){
	$(obj +" .resultEnd").css("display","block");
	$(obj +" .resultEnd_nodata").css("display","none");
}
//设置正在加载 失效
function pullOverUndo( obj ){
	$(obj +" .resultEnd").css("display","none");
	$(obj +" .resultEnd_nodata").css("display","block");
}



/*
 * @ downLoadFile
 * 参数：fName 文件名
 * 		fSize  文件大小 字节数
 * 		fUrl  文件路径，此处已拼接成http://ip地址/XXX 这类
 * OnDownloadCb(datas) 此函数必须包含，不需处理
 */
function downLoadFile(fName,fSize,fUrl){

	var timestamp=new Date().getTime();
	var size = fSize; //必须传字节数
	var parameter = {"fileName":fName,
		"fileID":timestamp,
		"taskID":timestamp+1,
		"size":size,
		"path":fUrl,
		"isAutoDownload":0,
		"isAutoPreView":0		
	};
	//alert( JSON.stringify(parameter));
	NativeInteractive.download(parameter);
	
}

function OnDownloadCb(datas){
	var status = datas.result.status,
		params = datas.result.params;
	
	//这里做一个演示，把数据转成字符串在页面弹出
	var str_para = JSON.stringify(params);
	
	//alert("download回调函数OnDownloadCb:"+str_para);
}

//上传

function chooseSheetPhoto(){
	var transferid = parseInt(new Date().getTime()/1000);
	NativeInteractive.chooseSheetPhoto({"webAppTransferID":transferid});
}
function OnChoosePhotoCb(datas){
	var status = datas.result.status,
		params = datas.result.params;
	var webAppTransferID = parseInt(new Date().getTime()/1000);
		if(status==0){
			//alert("OnChoosePhotoCb"+JSON.stringify(datas));
			var str_para = JSON.stringify(params);			
			var setting = {
				"uploadUrl":sessionStorage.getItem("SERVER_IP")+"/media_file/",
				"fileID":params.fileID,
				"fileName":params.fileName,
				"taskID":webAppTransferID,
				"nativePath":params.nativePath
			}
			
			NativeInteractive.uploadGivenFile(setting);
			$.showLoading("正在上传中");
		}
		
	
}
function OnUploadGivenFileCb(datas){
	var status = datas.result.status,
		params = datas.result.params;
	
	if(params){
		
		var transferStatus = params.transferStatus;
		if(transferStatus=="Success"){
			$.hideLoading();
			var results = [{"name":params.fileName,"size":params.size,"path":params.uploadPath}];
			var html = renderAttach(results);
			$("#J_attachList").append(html);
			//var str_para = JSON.stringify(params);
			//alert("OnUploadGivenFileCb 图片已上传:"+str_para);
		}
	}
}







