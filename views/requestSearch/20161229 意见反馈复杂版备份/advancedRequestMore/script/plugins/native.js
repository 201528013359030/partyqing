;(function(){
var Global_id = 0;
var Global_bridge;
var os = 0;
var API = {
	"os": "",
	init: function() {
		if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
			os = 1;
			window.onerror = function(err) {
				console.log("window.onerror: " + err)
			};
			this.connectWebViewJavascriptBridge(function(bridge) {
				Global_bridge = bridge;
				bridge.init(function(message, responseCallback) {});
				bridge.registerHandler("SendToJs", function(data, responseCallback) {
					API.SendToJs(data);
					if (responseCallback) {
						responseCallback(data)
					}
				});
				bridge.registerHandler("JsCallback", function(data, responseCallback) {
					API.JsCallback(data);
					if (responseCallback) {
						responseCallback(data)
					}
				})
			})
		} else {
			if (/(Android)/i.test(navigator.userAgent)) {
				os = 2
			} else {
				os = 3
			}
		}
		
	},
	connectWebViewJavascriptBridge: function(callback) {
		if (window.WebViewJavascriptBridge) {
			callback(WebViewJavascriptBridge)
		} else {
			document.addEventListener("WebViewJavascriptBridgeReady", function() {
				callback(WebViewJavascriptBridge)
			}, false)
		}
	},
	send_tonative: function(param, callback) {
		
		var json = {
			"request": {
				"id": Global_id,
				"name": param.name,
				"callback": param.callback || null,
				"params": param.params || null
			}
		};
		if (os == 2) {
			window.JavaScriptInterface.sendToNative(JSON.stringify(json))
		}
		if (os == 1) {
			Global_bridge.callHandler("SendToNative", JSON.stringify(json), function(data) {
				if (callback) {
					callback(json)
				}
			})
		}
		if (os == 3) {
			window.HandleEvent("SendToNative", JSON.stringify(json))
		}
		Global_id++
	},
	SendToJs: function(data) {
		var datas = JSON.parse(data);
		var callback = datas.request.callback;
		eval(callback + "(datas)");
	},
	JsCallback: function(data) {
		if(data){
			var datas = JSON.parse(data);
			var callback = datas.request.callback;
			eval(callback + "(datas)");
		}
	}
};
	window["API"] = API;
})();
/*
 * 初始化 api.init 方法
 */
API.init();

/*
 * NativeInteractive 调用方法
 */
;(function(){
	
	var NativeInteractive = {
		
		init:function(){
			new this();
		},
		/**
		 * 登出
		 * 
		 * */
		logout:function(){
			var op_logout = {
				 "name": "Logout"
			};
			API.send_tonative(op_logout);
		},
		/**
		 * 关闭webview *  
		 * */
		closeWebView:function(){
			var op_closeWebView = {
				"name":"CloseWebView"
			};
			API.send_tonative(op_closeWebView);
		},
		/**
		 * 发送mqtt消息
		 * tid 为用户uid
		 * type为格式
		 * content为发送的内容
		 * */
		sendMqttMsg:function(parameter){
			var op_sendMqttMsg = {
				"name":"SendMqttMsg",
				"params": {
				   "tid": parameter.tid,
				   "type": parameter.type,
				   "content": parameter.content||"",
				   "receiverType":parameter.receiverType||"IM"
				}
			};
			API.send_tonative(op_sendMqttMsg);
		},
		/**
		 * 选择联系人
		 */
		selectContacts:function(parameter){
			var op_selectContacts = {
				"name":"SelectContacts",
				"callback": parameter.callback||"OnSelectContactsCb",
				"params": {
				   "maxCount": parameter.maxCount,
				   "tag":parameter.tag||""
				}
			};
			API.send_tonative(op_selectContacts);
		},
		/**
		 * 查找联系人
		 */
		searchContacts:function(parameter){
			var op_searchContacts = {
				"name":"SearchContacts",
				"callback": parameter.callback||"OnSearchContactsCb",
				"params": {
				   "maxCount": parameter.maxCount,
				   "searchString":parameter.searchString,
				   "matchType":parameter.matchType || "All",
				   "tag":parameter.tag||""
				}
			};
			API.send_tonative(op_searchContacts);
		},
		/**
		 * 扫描二维码 条形码等
		 * */
		scanQRCode:function(){
			var scan = {
				"name":"ScanQRCode"
			};
			API.send_tonative(scan);
		},
		/**
		 * 获取版本号信息 
		 */
		getAppVersion:function(){			
			var op_getAppVersion = {
				"name" : "GetAppVersion",
				"callback" : "OnSGetAppVersionCb"				
			};
			API.send_tonative(op_getAppVersion);
		},
		/**
		 * 获取位置信息 
		 */
		getLocationInfo:function(){			
			var op_getLocationInfo = {
				"name" : "GetLocationInfo",
				"callback" : "OnGetLocationInfoCb"				
			};
			API.send_tonative(op_getLocationInfo);
		},
		
		/**
		 * 获取网络状态
		 */
		getNetStatus:function(){			
			var op_getNetStatus = {
				"name" : "GetNetStatus",
				"callback" : "OnGetNetStatusCb"				
			};
			API.send_tonative(op_getNetStatus);
		},
		/**
		 * 获取设备信息
		 */
		getDeviceInfo:function(){			
			var op_getDeviceInfo = {
				"name" : "GetDeviceInfo",
				"callback" : "OnGetDeviceInfoCb"				
			};
			API.send_tonative(op_getDeviceInfo);
		},
		/**
		 * 获取本地语言信息
		 */
		getLocalLanguage:function(){			
			var op_getLocalLanguage = {
				"name" : "GetLocalLanguage",
				"callback" : "OnGetLocalLanguageCb"				
			};
			API.send_tonative(op_getLocalLanguage);
		},
		/**
		 * 请求本地系统时间
		 */
		requestLocalDate:function(){
			var op_requestLocalDate ={
				"name": "RequestLocalDate", 
		        "callback": "OnRequestLocalDateCb"
			};
			API.send_tonative(op_requestLocalDate);
		},
		/**
		 * 播放系统音效
		 * 调用该接口，客户端侧播放系统音效
		 */
		playSystemSound:function(parameter){
			var op_playSystemSound ={
				"name": "PlaySystemSound", 
		        "callback": parameter.callback||"OnPlaySystemSoundCb",
		        "params": {
					"soundName": parameter.soundName
		        }
			};
			API.send_tonative(op_playSystemSound);
		},
		/**
		 * 获取手机通讯录联系人
		 * 调用该接口，返回手机通讯录中所有联系人信息
		 */
		requestLocalContacts:function(parameter){
			var parameter= parameter;
			if(typeof(parameter) == "undefined"){
				parameter = {};
			}
			var op_requestLocalContacts ={
				"name": "RequestLocalContacts", 
		        "callback": parameter.callback||"OnRequestLocalContactsCb",
		        
			};
			API.send_tonative(op_requestLocalContacts);
		},
		/**
		 * 查找本地联系人
		 * 调用该接口时，传入要检索的字符串，返回检索的结果
		 */
		searchLocalContacts:function(parameter){
			var op_searchLocalContacts ={
				"name": "SearchLocalContacts", 
		        "callback": parameter.callback||"OnSearchLocalContactsCb",
		        "params": {
					"maxCount": parameter.maxCount,
					"searchString" : parameter.searchString
		        }
			};
			API.send_tonative(op_searchLocalContacts);
		},
		/*
		 * 添加本地联系人
		 * 调用该接口时，将联系人信息存入手机通讯录
		 */
		addLocalContact:function(contactInfo){
			var op_addLocalContact ={
				"name": "AddLocalContact", 
		        "callback": "OnAddLocalContactCb",
		        "params": {
					"contactInfo": contactInfo
		        }
			};
			API.send_tonative(op_addLocalContact);
		},
		/**
		 * 下载接口* 
		 * */
		download:function(parameter){
			var op_download = {
				"name": "Download", 
		        "callback": parameter.callback, 
		        "params": {
		            "fileName":parameter.fileName, 
		            "fileID": parameter.fileID, 
		            "taskID": parameter.taskID, 
		            "size": parameter.size,
					"path": parameter.path,
					"isAutoDownload": parameter.isAutoDownload,
					"isAutoPreView": parameter.isAutoPreView,
					"uploader":parameter.uploader||"",
					"uploadTime":parameter.uploadTime||""
		        }
			};
			API.send_tonative(op_download);
		},
		/**
		 * 上传文件* 
		 * */
		upload:function(parameter){
			var op_upload = {
				"name": "Upload", 
		        "callback": parameter.callback||"OnUploadCb", 
		        "params": {
		            "uploadUrl":parameter.uploadUrl, 
		            "webAppTransferID": parameter.webAppTransferID, 
		            "taskID": parameter.taskID,
		            "suffix":parameter.suffix||""
		        }
			};
			API.send_tonative(op_upload);			
		},
		/*
		 * 弹出提示信息
		 */
		toast:function(parameter){
			var op_toast ={
				"name": "Toast", 
		        "callback": parameter.callback||"OnToastCb",
		        "params":{
		        	"message":parameter.message,
		        	"duration":parameter.duration||1.0,
		        	"position":parameter.position||"CENTER"
		        }
			};
			API.send_tonative(op_toast);
		},
		/*
		 * 弹出提示信息
		 */
		alerts:function(parameter){
			var op_alerts ={
				"name": "Alert", 
		        "callback": parameter.callback||"OnAlertCb",
		        "params":{
		        	"title":parameter.title,
					"message":parameter.message,
					"defaultButton":parameter.defaultButton||"取消",
					"otherButton":parameter.otherButton||"确定"
		        }
			};
			API.send_tonative(op_alerts);
		},
		/**
		 * 选择图片
		 * 选择表示上拉菜单/弹出框选择
		 */
		chooseSheetPhoto:function(parameter){
			var op_photo = {
				"name": "ChoosePhoto", 
		        "callback": parameter.callback||"OnChoosePhotoCb", 
		        "params": {
		            "webAppTransferID": parameter.webAppTransferID, 
					"chooseType": parameter.chooseType||"ChooseFromActionSheet",
					"editType":parameter.editType||0,
					"photoRatio":parameter.photoRatio||1,
					"limitWidth":parameter.limitWidth||"",
					"limitHeight":parameter.limitHeight||"",
					"compressionQuality":parameter.compressionQuality||1.0,
					"limitSize":parameter.limitSize||""
		        }
			};
			API.send_tonative(op_photo);
		},
		/**
		 * 上传指定文件
		 */
		uploadGivenFile:function(parameter){
			//alert(JSON.stringify(parameter));
			var op_uploadGivenFile = {
				"name": "UploadGivenFile", 
		        "callback": parameter.callback||"OnUploadGivenFileCb", 
		        "params": {
		            "uploadUrl": parameter.uploadUrl||"https://183.234.48.161:443/media_file/", 
		            "fileID": parameter.fileID,
		            "fileName":parameter.fileName||"",
		            "taskID": parameter.taskID, 
		            "nativePath": parameter.nativePath,
		            "suffix":parameter.suffix||""
		        }
			};
			//alert(JSON.stringify(op_uploadGivenFile));
			API.send_tonative(op_uploadGivenFile);
		},
		/*
		 * 录制音频
		 */
		recordAudio:function(parameter){
			
			var op_recordAudio = {
				"name":"RecordAudio",
				"callback":parameter.callback||"OnRecordAudioCb", 
		        "params": {
		            "webAppTransferID": parameter.webAppTransferID, 
		            "formatType": parameter.formatType || "AMR",
		            "sampleRate": parameter.sampleRate || 8000,
		            "channelCount":parameter.channelCount || 1,
		            "bitsPerSample":parameter.bitsPerSample ||8,
		            "limitSize":parameter.limitSize||1048576,
		            "limitLength":parameter.limitLength||600
		        }
			};
			API.send_tonative(op_recordAudio);
		},
		/*
		 * 录制视频
		 */
		shootVideo:function(parameter){
			var op_shootVideo = {
				"name":"ShootVideo",
				"callback": parameter.callback||"OnShootVideoCb",
				"params":{
					"webAppTransferID": parameter.webAppTransferID, 
					"videoQuality":parameter.videoQuality||"",
					"limitSize":parameter.limitSize||104857600,
					"limitLength":parameter.limitLength||600
				}
			};
			API.send_tonative(op_shootVideo);
		},
		/**
		 * 存储离线数据
		 * 调用该接口，储存轻应用页面中的离线数据
		 */
		appCacheStore:function(parameter){
			
			var op_cacheStore ={
				"name": "AppCacheStore", 
		        "callback": parameter.callback||"OnAppCacheStoreCb", 
		        "params": {
					"appID": parameter.appID || "1",
					"type": parameter.type|| "table", 
					"key": parameter.keys,
					"data": parameter.datas
		        }
			};
			API.send_tonative(op_cacheStore);
		},
		/**
		 * 获取离线数据
		 * 调用该接口，获取轻应用页面缓存过的离线数据
		 */
		appCacheFetch:function(parameter){		
			var op_cacheFetch ={
				"name": "AppCacheFetch", 
		        "callback": parameter.callback||"OnAppCacheFetchCb", 
		        "params": {
					"appID":parameter.appID|| "1",
					"type": parameter.type || "table", 
					"key": parameter.keys
		        }
			};
			API.send_tonative(op_cacheFetch);
		},		
		/**
		 * 删除离线数据
		 * 调用该接口，删除轻应用页面中的指定的离线数据
		 */
		appCacheDelete:function(parameter){
			var op_cacheDelete ={
				"name": "AppCacheDelete", 
		        "callback": parameter.callback||"OnAppCacheDeleteCb", 
		        "params": {
					"appID":parameter.appID ||"1",
					"type": parameter.type|| "table",
					"key": parameter.keys
		        }
			};
			API.send_tonative(op_cacheDelete);
		},
		/**
		 * 清除离线数据
		 * 调用该接口，清除轻应用页面中指定类型的离线数据
		 */
		appCacheClear:function(parameter){
			var parameter= parameter;
			if(typeof(parameter) == "undefined"){
				parameter = {};
			}
			var op_cacheClear ={
				"name": "AppCacheClear", 
		        "callback": parameter.callback||"OnAppCacheClearCb", 
		        "params": {
					"appID":parameter.appID|| "1",
					"type": parameter.type||"table"
		        }
			};			
			API.send_tonative(op_cacheClear);
			
		},
		/** 
		 * 发送短消息 
		 * */
		SMS:function(mobile){
			var op_sms = {
				"name": "SMS", 
		        //"callback": "OnSMSCb", 暂不需要
		        "params": {
					"mobile": mobile
		        }
			};
			API.send_tonative(op_sms);
		},
		/*
		 * 请求用户账号信息
		 */
		requestAccountInfo:function(parameter){
			var op_rai = {
				"name":"RequestAccountInfo",
				"callback":parameter.callback||"OnRequestAccountInfoCb",
				"params":{
					"typeList":parameter.typeList
				}
			};
			API.send_tonative(op_rai);
		},
		/*
		 * 开启运动传感器监听
		 * 调用该接口，客户端侧回调加速度监听结果信息
		 */
		startMotionMonitor:function(parameter){
			var op_startMotionMonitor ={
				"name": "StartMotionMonitor", 
		        "callback": parameter.callback||"OnStartMotionMonitorCb",
		        "params":{
		        	"monitorType":parameter.monitorType,
					"frequent":parameter.frequent,
					"motionType":parameter.motionType,
					"referenceFrame":parameter.referenceFrame
		        }
			};
			API.send_tonative(op_startMotionMonitor);
		},
		/*
		 * 关闭运动传感器监听
		 */
		stopMotionMonitor:function(parameter){
			var parameter= parameter;
			if(typeof(parameter) == "undefined"){
				parameter = {};
			}
			var op_stopMotionMonitor ={
				"name": "StopMotionMonitor", 
		        "callback": parameter.callback||"OnStopMotionMonitorCb"
			};
			API.send_tonative(op_stopMotionMonitor);
		},
		/*
		 * 开启距离传感器监听
		 * 调用该接口，客户端侧回调距离监听结果信息
		 */
		startProximityMonitor:function(parameter){
			var op_startProximityMonitor ={
				"name": "StartProximityMonitor", 
		        "callback": parameter.callback||"OnStartProximityMonitorCb",
		        "params": {
					"monitorType":parameter.monitorType
		        }
			};
			API.send_tonative(op_startProximityMonitor);
		},
		/**
		 * 停止距离传感器监听
		 */
		stopProximityMonitor:function(parameter){
			var parameter= parameter;
			if(typeof(parameter) == "undefined"){
				parameter = {};
			}
			var op_stopProximityMonitor ={
				"name": "StopProximityMonitor", 
		        "callback": parameter.callback||"OnStopProximitySensorCb"
			};
			API.send_tonative(op_stopProximityMonitor);
		},		
		startSystemEventMonitor:function(parameter){
			var op_startSystemEventMonitor ={
				"name": "StartSystemEventMonitor", 
		        "callback": parameter.callback||"OnStartSystemEventMonitorCb",
		        "params": {
					"systemEventType":parameter.systemEventType
		        }
			};
			API.send_tonative(op_startSystemEventMonitor);
		},
		stopSystemEventMonitor:function(parameter){
			var parameter= parameter;
			if(typeof(parameter) == "undefined"){
				parameter = {};
			}
			var op_stopSystemEventMonitor ={
				"name": "StopSystemEventMonitor", 
		        "callback": parameter.callback||"OnStopSystemEventMonitorCb"        
			};
			API.send_tonative(op_stopSystemEventMonitor);
		},
		/**
		 * 修改app内部基本资料  头像 签名 手机号 邮箱 地址 邮编
		 */
		personalInfoChange:function(parameter){
			var op_personalInfoChange = {
				"name":"PersonalInfoChange",
				"callback":parameter.callback||"OnPersonalInfoChangeCb",
				"params":{
					"membername": parameter.membername||"", 
					"signature": parameter.signature||"", 
		            "phoneex": parameter.phoneex||"", 
		            "emailex": parameter.emailex||"", 
		            "addressex": parameter.addressex, 
		            "postcodeex": parameter.postcode||"", 
		            "imgurl": parameter.imgurl||""
				}
			};
			API.send_tonative(op_personalInfoChange);
		}
		
	};
	
	window["NativeInteractive"] = NativeInteractive;
})();
