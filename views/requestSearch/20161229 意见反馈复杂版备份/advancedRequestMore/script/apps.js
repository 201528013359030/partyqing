var commonTxt = {
	"nodata":"暂无数据",
	"nodata_sub":"暂时没有相应的信息",
	"noweb":"网络连接失败",
	"noweb_sub":"网络链接失败，请价差您的网络设置！"
}

var noweb = {};
noweb.partial = "../html/temp/noweb.html";
noweb.init = function(){
    console.log('网址不存在');
}

var notfound = {};
notfound.partial = "../html/temp/404.html";
notfound.init = function(){
    console.log('网址不存在');
}

var home= {};
home.partial = "../html/temp/home.html";
home.init = function(){
	//初始化当前页码为1
	page_undo = 1;
	page_over = 1;
	undo_flag = true;
	over_flag = true;
	setRequestUndo("#J_requestUndo");
	setRequestOver("#J_requestOver");
	miniSPA.render("home");
	//生成页面，参数为插入标签	
	commonFun.load_page("#page_innerContent"); //loading加载
	
	$("#search_input").on("focus",function(){
		window.location.replace("#search");
	});
	
	if($("#page_innerContent")[0]) {
	
		//var flag_home = true; //是否继续加载
		
		$("#tab1,#tab2").pullToRefresh().on("pull-to-refresh", function() {
		    var self = this;		    
		    setTimeout(function() {
		      	window.location.reload();
		        $(self).pullToRefreshDone(); // 重置下拉刷新
		    }, 2000);   //模拟延迟
	    });
	    
	    $("#tab1,#tab2").infinite().on("infinite", function() {
			var self = this;
				var cls = $(self).attr("class");
				var isUndo = /tabUndo/.test(cls);
			var flag = "";
			
			if(isUndo){flag = undo_flag;
			}else{flag = over_flag;}
			
			if(flag){
				
			    if(self.loading) return;
			    self.loading = true;
			    setTimeout(function() {			    	
			    	//此处处理加载更多内容
			    	if(isUndo){
			    		setRequestUndo("#J_requestUndo");
			    	}else{
			    		setRequestOver("#J_requestOver");
			    	}
			        
			        self.loading = false;
			    }, 2000);   //模拟延迟
		    }
		    
	    });
	} 
	var userInfo = getUserinfo();
	if(userInfo.type==3){
		$("#J_addBtn").css("display","block");
	}
}

var form= {};
form.partial = "../html/temp/form.html";
form.init = function(){
	miniSPA.render("form");
	//获取用户基本信息
	var userInfo = getUserinfo();

	$("#contact").val(userInfo.mobile);
	$("#userName").val(userInfo.username);
	$("#companyName").val(userInfo.company);
	
	commonFun.load_page("#page_innerContent"); //loading加载
	
	$("#J_uploadAttach").on("click",function(){		
		chooseSheetPhoto();
	});
	$(document).on("click",".J_delAttach",function(){
		var obj = this;
		$.confirm("您确定要删除文件吗?", "确认删除?", function() {
			$.toast("文件已经删除!");
			$(obj).remove();
		}, function() {
			//取消操作
		});
	});
	
	$("#J_requestUpdate").on("click",function(){
		var title = $("#title").val();
		var content = $("#content").val();
		var contact = $("#contact").val();
		//新增基本信息
		var senderName = $("#userName").val();
		var company = $("#companyName").val();
		
		var files = [];
		var attachs = $("#J_attachList .J_delAttach");
		if(attachs.length>0){
			for(var i=0;i<attachs.length;i++){
				var _file = {};
				_file["name"]=attachs.eq(i).attr("data-name");
				_file["size"]=attachs.eq(i).attr("data-size");
				_file["path"]=attachs.eq(i).attr("data-path");
				//files[i]=_file;
				files.push(_file);
			}
		}
		
		if(!title){
			$.toast("标题不能为空","cancel");
			return false;
		}
		if(title.length<4||title.length>31){
			$.toast("标题至少4个字，最多30字","cancel");
			return false;
		}
		if(!content){
			$.toast("详细说明不能为空","cancel");
			return false;
		}
		if(!contact){
			$.toast("联系方式不能为空","cancel");
			return false;
		}
		
		var reg_phone = /^1\d{10}$/;
		if( !reg_phone.test(contact) ){
			$.toast("手机格式不正确","cancel");
			return false;
		}
		
//		var reg_tel = /^0\d{2,3}-?\d{7,8}$/;
//		var reg_email =/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/ ;
//		if( !reg_phone.test(contact)&&!reg_email.test(contact)&&!reg_tel.test(contact)){
//			$.toast("请输入正确的联系方式","cancel");
//			return false;
//		}
		$("#J_requestUpdate").attr("disabled","true");
		var parameter = {"title":title,"content":content,"contact":contact,"senderName":senderName,"company":company,"file":files};
		var isupdate = updateRequest(parameter);
		if(isupdate.succeed==1){
			$.toast("已经提交成功!");
			window.location.replace("#home");
		}else{
			$.toast("提交失败，请重试!");
			$("#J_requestUpdate").attr("disabled","false");
		}
	});
	
}

var content= {};
content.partial = "../html/temp/content.html";
content.init = function(){
	var isAdmin = 0; //1 是管理员  0是用户
	var id = content.parame;
	//var	isAdmin = content.parameCon;
	var userInfo = getUserinfo();
	if(userInfo.type==3){
		isAdmin = 0;
	}else{
		isAdmin = 1;
	}
	
	setRequestInfo(id);
	
	if(isAdmin){
		$("#adminOp").css("display","block");
		$("#customOp").css("display","none");
	}else{
		$("#adminOp").css("display","none");
		$("#customOp").css("display","block");
	}
	
	miniSPA.render("content");
	commonFun.load_page("#page_innerContent"); //loading加载
	
	$(".J_btnUpdate").on("click",function(){
		var obj = this;
		var type = $(obj).attr("data-name");
		var name = "";
		if(type=="append"){
			name = "提交追问";
		}else if(type=="progress"){
			name = "提交进度";
		}else{
			name = "提交解答";
		}
		
		$("#J_btn").attr("data-name",type);
		$("#J_btn").html(name);
		$("#requestForm").css("display","block");
		
	});
	$("#J_btnCancel").on("click",function(){
		$("#requestForm").css("display","none");
	});
	
	$("#J_btn").on("click",function(){
		var type = $(this).attr("data-name");
		var texts = $("#J_textarea").val();
		if(!texts){
			$.toast("内容不能为空","cancel");
			return false;
		}
		var name = "";
		if(type=="append"){
			var isSucceed = updateAppend(id,texts);
			if(isSucceed.succeed){
				$.toast("提交追问成功");
				window.location.reload();
			}else{
				$.toast("提交失败","cancel");
			}
		}else if(type=="progress"){
			var isSucceed = updateAnswerProgress(id,texts);
			if(isSucceed.succeed){
				$.toast("提交进度成功");
				window.location.reload();
			}else{
				$.toast("提交失败","cancel");
			}
		}else{
			var isSucceed = updateAnswer(id,texts);
			if(isSucceed.succeed){
				$.toast("提交解答成功");
				window.location.reload();
			}else{
				$.toast("提交失败","cancel");
			}
		}
		
	});
	
	$(".page_innerContent").on("click",".attchIteam",function(){
		var obj = this;
		var fName = $(obj).attr("data-name"),
			fSize = $(obj).attr("data-size") ,
			fUrl =  $(obj).attr("data-path");
		downLoadFile(fName,fSize,fUrl);
	});
	
}

var search= {};
search.partial = "../html/temp/search.html";
search.init = function(){
	page_search=1;
	search_flag=true;
	miniSPA.render("search");
	pullOverUndo( ".tabSearch" );
	commonFun.load_page("#page_innerContent"); //loading加载
	$("#search_input").focus();
	$(document).on("click", ".weui_search_cancel", function(e){
		window.location.replace("#home");
	});
	
	if($("#page_innerContent")[0]) {
			
		$("#tab1").pullToRefresh().on("pull-to-refresh", function() {
		    var self = this;		    
		    setTimeout(function() {
		      	window.location.reload();
		        $(self).pullToRefreshDone(); // 重置下拉刷新
		    }, 2000);   //模拟延迟
	    });
	    
	    $("#tab1").infinite().on("infinite", function() {
	    	
			console.log("infiniteScroll.html search_flag："+search_flag+"-page_search:"+page_search);
			
			if(search_flag){
				
				var title = $("#search_input").val();
				var status = $("#J_searchType").attr("data-status");
				
				var self = this;
			    if(self.loading) return;
			    self.loading = true;
			    setTimeout(function() {
			    	//此处处理加载更多内容
			    	setRequestSearch("#J_requestSearch",title,status);
			        
			        self.loading = false;
			    }, 2000);   //模拟延迟
			}	    
	  }); 
	}
	
	$("#search_input").on("input",function(){		
		$("#J_requestSearch").html("");
		var obj = this;
		//setTimeout(function(){
			
			var title = $(obj).val();
			var status = $("#J_searchType").attr("data-status");
			console.log("title:"+title+"-status:"+status);
			//alert(title);
			if(title){
				setRequestSearch("#J_requestSearch",title,status);
			}else{
				$.toast("请输入关键字","text");
				pullOverUndo( ".tabSearch" );
			}
		
		//},1000);
		
	});
	
	$(".dropMenuIteam").on("click",function(){
    	var obj = this;
    	var value = $(obj).html();
    	var status = $(obj).attr("data-status");
    	$("#J_searchType").html(value);
    	$("#J_searchType").attr("data-status",status);
    	$("#search_input").val("");
    });
	
}









