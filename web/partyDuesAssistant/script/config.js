var commonTiptext = {
	"nodata":"暂无数据",
	"nodata_sub":"暂时没有相应的信息",
	"noweb":"网络连接失败",
	"noweb_sub":"网络链接失败，请价差您的网络设置！",
	"exam_info":"答题结束后，必须点击交卷按钮才能保留成绩",
	"exam_finish_one":"恭喜您获得[学霸] 亮闪闪称号！",
	"confirm_restar_title":"是否确认重新开始",
	"confirm_restar_con":"重新开始将删除上次未完成的答题记录",
	"confirm_finish_half_title":"是否确认交卷",
	"confirm_finish_half_con":"没有答完，注意交卷后不能继续答题",
	"questionflag":["","判断题","单项选择题","多项选择题"],
	"score1":"哇哦，一看您就是资深老党员啦！",
	"score2":"还不错哦！您已经跨入优秀党员的行列啦！",
	"score3":"您离优秀党员只有一步之遥啦！",
	"score4":"真可惜，只差那么一点点您就合格了！",
	"score5":"同志仍需努力，争当合格党员！",
}
var commonFunction = {
	load_page : function(ele){
		$(".pageloading").hide();
		$(ele).css("display","block");//display 属性规定元素应该生成的框的类型。block 此元素将显示为块级元素，此元素前后会带有换行符。 --fyq
	},
	get_url_param : function(){
		var url = location.search; //获取url中"?"符后的字串 search 属性是一个可读可写的字符串，可设置或返回当前 URL 的查询部分（问号 ? 之后的部分,包括'?'）。
		var theRequest = new Object();
		if (url.indexOf("?") != -1) {
		   var str = url.substr(1); // substr() 的参数指定的是子串的开始位置和长度，因此它可以替代 substring() 和 slice() 来使用 --fyq
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
		
		var theRequest = commonFunction.get_url_param();
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
		 * 判断当前是什么设备
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
		//@ 判断是否在线
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
			show_size = k+"m";
		}else{ 
			show_size = size+"kb";
		}
		return show_size;
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
	getJsonResult : function(setting){
		
		/**
		 * @ getJsonResult
		 * 获取elgg接口数据
		 * @param {Object} url--接口地址
		 * @param {Object} arr--参数
		 * 返回--elgg接口的返回值
		 */
		
		var value = "";
//		alert(JSON.stringify(setting));
		//var infos = {"info":JSON.stringify(arr)};
		$.ajax({		
			url:setting.url,
			timeout:5000,
			data:setting.arr,
			type:setting.type||"get",//HTTP请求类型
			dataType:'json',  
	        cache : false,  
			async : false,  
			success:function(data){
				console.log("result:" +JSON.stringify(data));
				data=data.result;
				//服务器返回响应	
//				alert("33");
				if(data.c==0){		
					value= data.d;
					
				}else{
					value="error_"+data.m+"_"+data.c;					
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				var nodata = commonFunction.dataEmpty("nodata","请求超时","页面已不存在，请返回刷新");
				$("#J_innerContent").html( nodata );
				
				console.log("XMLHttpRequest"+JSON.stringify(XMLHttpRequest));
				return false;
				//alert("XMLHttpRequest:"+JSON.stringify(XMLHttpRequest));
			},
			complete:function(XMLHttpRequest,status){
				if(status=="timeout"){
					//NativeInteractive.toast({"message":"很抱歉，请求超时请返回重试"});	
					alert("很抱歉，请求超时请返回重试");
				}
			}
		});
//		alert("231");
		return value;
	},
};
var PAGE_URL   = window.location.href,  //href 属性是一个可读可写的字符串，可设置或返回当前显示的文档的完整 URL。 --fyq
	API_KEY    = "36116967d1ab95321b89df8223929b14207b72b1",
	SERVER_IP  = commonFunction.get_param("serverIp"),
	USER_AGENT = commonFunction.getClientType(),
	NATIVE_UID = commonFunction.get_param("uid"),
	NATIVE_EGUID = commonFunction.get_param("eguid"),
	NATIVE_AUTH_TOKEN = commonFunction.get_param("auth_token"),
	monthNames = [ "1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月" ],
	dayNames= ["周日","周一","周二","周三","周四","周五","周六"];

	NATIVE_PLANID = commonFunction.get_param("planid");// 将参数 planid 放到session中--fyq
	sessionStorage.setItem("NATIVE_PLANID",NATIVE_PLANID);

console.log("USER_AGENT:"+USER_AGENT);
sessionStorage.setItem("API_KEY",API_KEY);
sessionStorage.setItem("USER_AGENT",USER_AGENT);
sessionStorage.setItem("SERVER_IP",SERVER_IP);	
sessionStorage.setItem("NATIVE_UID",NATIVE_UID);
sessionStorage.setItem("NATIVE_EGUID",NATIVE_EGUID);
sessionStorage.setItem("NATIVE_AUTH_TOKEN",NATIVE_AUTH_TOKEN);

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


















