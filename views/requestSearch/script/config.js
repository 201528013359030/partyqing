
var commonFun = {
	load_page : function(ele){
		// @ load_page 隐藏页面loading
		$(".pageloading").hide();
		$(ele).css("display","block");
	},
	get_url_param : function(){
		var url = location.search; //获取url中"?"符后的字串
		var theRequest = new Object();
		if (url.indexOf("?") != -1) {
		   var str = url.substr(1);
		   strs = str.split("&");
		   for(var i = 0; i < strs.length; i ++) {
		      theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
			   }
		}
	
		return theRequest;
	},
	get_param : function(name){
		
		/*
		 * @ 函数名    ：get_param(name)
		 * 参数说明：name 为 ？ 后面的参数名
		 * 
		 */
		
		var theRequest = commonFun.get_url_param();
		return theRequest[name];
	},
	parseURL : function(url){
		/*
		 * @ parseURL 解析url 
		 * 返回一个JSON数据 使用变量接一下
		*/
		var a = document.createElement('a'); 
		a.href = url; 
		return { 
			source: url, 
			protocol: a.protocol.replace(':',''), 
			host: a.hostname, 
			port: a.port, 
			query: a.search, 
			params: (function(){ 
				var ret = {}, 
				seg = a.search.replace(/^\?/,'').split('&'), 
				len = seg.length, i = 0, s; 
				for (;i<len;i++) { 
				if (!seg[i]) { continue; } 
				s = seg[i].split('='); 
				ret[s[0]] = s[1]; 
				} 
				return ret; 
			})(), 
			file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1], 
			hash: a.hash.replace('#',''), 
			path: a.pathname.replace(/^([^\/])/,'/$1'), 
			relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1], 
			segments: a.pathname.replace(/^\//,'').split('/') 
		}; 
	},
	getClientType : function(){
		
		/* @ getClientType
		 * 判断当前是什么设备 PC IOS AN
		 * 已经存在sessionStroage  USER_AGENT  里
		 */
		
		var user_agent = "PC";
		if( /(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent) ){
			user_agent = "IOS";
		};
		if( /(Android)/i.test(navigator.userAgent) ){
			user_agent = "AN";
		}
		return user_agent;
	},
	isOnline      : function(){
		//@ 判断是否在线 还是不要用了
		if(navigator.onLine){
			return true;
		}else{
			return false;
		}
	},
	getUnixTime : function(timestamp){
		//@ 把时间戳（秒级）转换成  年月日 时分秒
		var monthNames = [ "1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月" ]; 
		var dayNames= ["周日","周一","周二","周三","周四","周五","周六"];
		var ts = timestamp,
		    type = type;
	    var t,y,m,d,h,i,s,hour,time, today,year, day,weekTime;  
	    t = ts ? new Date(ts*1000) : new Date();  
	    y = t.getFullYear();  
	    m = t.getMonth()+1;  
	    d = t.getDate(); 
	    w = t.getDay();
	    h = t.getHours();  
	    i = t.getMinutes();  
	    s = t.getSeconds();
	    
	    today = new Date();
	    year = today.getFullYear();
	    day = today.getDate();
	    		    
	    time = y+'-'+(m<10?'0'+m:m)+'-'+(d<10?'0'+d:d)+' '+(h<10?'0'+h:h)+':'+(i<10?'0'+i:i);
	   
	    return time; 
	},
	getMB : function(num){
		/*
		 * @ getMB 传入字节 返回 字节活MB
		 * @ param - num 字节数
		 */
		var size = num,
			show_size ="";
		if(size>=1024){
			var k =  (size - size%1024)/1024;
			show_size = k+"MB";
		}else{ 
			show_size = size+"KB";
		}
		return show_size;
	},
	getB : function(num){
		/*
		 * @ getMB 传入字节 返回 字节活MB
		 * @ param - num 字节数
		 */
		var size = num,
			show_size = "";
		if(/KB/.test(size)){
			var n = parseFloat(size);
			show_size = n*1024;			
		}
		if(/MB/.test(size)){
			var n = parseFloat(size);
			show_size = n*1024*1024;			
		}
		if(/GB/.test(size)){
			var n = parseFloat(size);
			show_size = n*1024*1024*1024;			
		}
		
		return String(show_size);
	},
	dataEmpty : function(icon,title,subTitle){
		
		/*@ dataEmpty		 * 
		 * 生成暂无数据与暂无结果页面
		 * *******************
		 *     图片icon
		 * 		title
		 *  s u b T i t l e
		 * ********************
		 * 参数说明：
		 * icon     显示图片  在images文件夹中文件名 nodata无数据 noweb无网络
		 * title    字符串
		 * subTitle 字符串
		 */
		
		var html = '<div class="weui_msg"><div class="weui_icon_area"><img src="../images/'+icon+'.png" class="img-responsed" /></div><div class="weui_text_area"><h2 class="weui_msg_title">'+title+'</h2>'
		+'<p class="weui_msg_desc">'+subTitle+'</p></div></div>';
		return html;
	},
	dataEmptyError : function(icon,title,subTitle){
		
		/*@ dataEmpty		 * 
		 * 生成暂无数据与暂无结果页面
		 * 同上
		 * 多了一个 "重新加载按钮" 调用native刷新方法
		 */
		
		var html = '<div class="weui_msg"><div class="weui_icon_area"><img src="../images/'+icon+'.png" class="img-responsed" /></div><div class="weui_text_area"><h2 class="weui_msg_title">'+title+'</h2>'
		+'<p class="weui_msg_desc">'+subTitle+'</p></div><div class="weui_opr_area"><p class="weui_btn_area"><a href="javascript:;" id="J_refresh" class="weui_btn weui_btn_default">重新加载</a></p></div></div>';
		return html;
	},
	getInputCheck:function(name){
		/* 名称：getInputCheck
		 * 目的，获取多选的值，返回值为字符串逗号分割
		 */		
		var chk_value =[]; 
		$('#page_innerContent input[name="'+name+'"]:checked').each(function(){
		chk_value.push($(this).val()); 
		}); 		
		return chk_value.join(",");
	},
	getInputNotChecked:function(name){
		/* 名称：getInputNotChecked
		 * 目的，获取多选的未选的值，返回值为字符串逗号分割
		 */
		var chk_value =[]; 		
		$('#page_innerContent input[name="'+name+'"]').each(function() {
			var _notcheck = $(this).not("input:checked").val();			
			if( _notcheck ){
				chk_value.push( _notcheck );
			}	       
		});
		
		return chk_value.join(","); //返回字符串逗号隔开
	},
	getJsonResult : function(method,arr){
		
		/**
		 * @ getJsonResult
		 * 获取elgg接口数据
		 * @param {Object} url--接口地址
		 * @param {Object} arr--参数
		 * 返回--elgg接口的返回值
		 */
		
		var value = "";
		var SERVER_IP = sessionStorage.getItem("SERVER_IP");
		var URL =SERVER_IP+ "/advanced/backend/web/index.php?r=question/question-api/api&method="+method;
		var infos = arr;
		//var infos = {"infos":JSON.stringify(arr)};
		$.ajax({		
			url:URL,
			timeout:5000,
			data:infos,
			type:"post",//HTTP请求类型setting.type||"get"
			dataType:'json',  
	        cache : false,  
			async : false,  
			success:function(data){
				//alert("result:"+JSON.stringify(data));
				//服务器返回响应				
				if(data.status==0){
					value= data.result;
				}else{
					//value="error_"+data.result;
					var nolink = commonFun.dataEmptyError("nolink","访问页面出错","请返回重试");
					$("#J_innerContent").html( nolink );
					console.log("获取"+method+"报错："+data.result);
					return false;
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				var nodata = commonFun.dataEmptyError("nodata","请求超时","页面已不存在，请点击按钮");
				$("#J_innerContent").html( nodata );
				
				alert("XMLHttpRequest"+JSON.stringify(XMLHttpRequest));
				return false;
				
			},
			complete:function(XMLHttpRequest,status){
				if(status=="timeout"){
					//NativeInteractive.toast({"message":"很抱歉，请求超时请返回重试"});	
					alert("很抱歉，请求超时请返回重试");
				}
			}
		});
		return value;
	}
};
var PAGE_URL   = window.location.href,
	API_KEY    = "36116967d1ab95321b89df8223929b14207b72b1",
	SERVER_IP  = commonFun.get_param("serverIp"),
	USER_AGENT = commonFun.getClientType(),
	NATIVE_UID = commonFun.get_param("uid"),
	NATIVE_EGUID = commonFun.get_param("eguid"),
	NATIVE_AUTH_TOKEN = commonFun.get_param("auth_token"),
	monthNames = [ "1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月" ],
	dayNames= ["周日","周一","周二","周三","周四","周五","周六"];


console.log("USER_AGENT:"+USER_AGENT);
sessionStorage.setItem("API_KEY",API_KEY);
sessionStorage.setItem("USER_AGENT",USER_AGENT);
sessionStorage.setItem("SERVER_IP",SERVER_IP);	
sessionStorage.setItem("NATIVE_UID",NATIVE_UID);
sessionStorage.setItem("NATIVE_EGUID",NATIVE_EGUID);
sessionStorage.setItem("NATIVE_AUTH_TOKEN",NATIVE_AUTH_TOKEN);

//判断页面宽度-高度进行控制
var bh = $(window).height();
if(bh<481){
	//iphone4 
    $('body').addClass('xs-screen');
}else if(481<bh<737){
	//大于4 - 6 plus
    $('body').addClass('md-screen');
}else{
	$('body').addClass('lg-screen');
}


//调用重新刷新加载页面接口
$(document).on("click","#J_refresh",function(){
	NativeInteractive.refresh();
});

function OnRefreshCb(){	
}

/**
 * @param OnSGetAppVersionCb datas
 * 获取版本号
 */
//function OnDidFinishLoadCb(datas){
//	NativeInteractive.getAppVersion();
//}
//if(USER_AGENT!="IOS"){
//	NativeInteractive.getAppVersion();
//}
//
//function OnSGetAppVersionCb(datas){
//	var params = datas.result.params,
//		systemName = params.systemName,
//		version = params.version,
//		versionCode = "";
//	if(systemName=="AN"){
//		versionCode = params.versionCode;
//		sessionStorage.setItem("VERSION_CODE",versionCode);
//	}
//	
//	sessionStorage.setItem("VERSION",version);
//	//sessionStorage.setItem("VERSION_CODE",versionCode);
//}


















