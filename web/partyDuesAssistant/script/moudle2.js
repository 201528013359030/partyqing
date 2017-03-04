var SERVER_IP = sessionStorage.getItem("SERVER_IP"), //获取url?后面的参数serverIp --fyq
	NATIVE_UID = sessionStorage.getItem("NATIVE_UID");//获取url后面的参数uid --fyq
	NATIVE_PLANID =sessionStorage.getItem("NATIVE_PLANID");
	NATIVE_AUTH_TOKEN = sessionStorage.getItem("NATIVE_AUTH_TOKEN");
//	NATIVE_PLANID ='2';

var urlbase = SERVER_IP+"/partyqing/web/index.php"
var limit_home = 15,
	limit_rank = 15; //与服务器规定最多显示多少条，死的
var page_home = 1,
	page_rank = 1; //翻页 第几页
var flag_home = true,
	flag_rank = true; //true  可以继续翻页； false 不能继续翻页
var CURRCOUNT = 0,
	END_CURRCOUNT = 0; //currcount 答题     End_currcount查看错题

var bh = $(window).height();
if(bh<480){
    $('body').addClass('xs-screen');
}

function setPartyDuesIteam(uid,auth_token){
	
	var info = {
			"uid":uid,
			"auth_token":auth_token
	}
	info = JSON.stringify(info);//将参数字符串化 --fyq;
//	alert(info);
	var arr = {
//		"url":SERVER_IP+"/question/web/index.php?r=test/list&uid="+NATIVE_UID+"&p="+page
		"url":urlbase+"?r=admin/partydues/duescount",
		"arr":{"info":info},
		"type":"post"
	};
	//获取数据
	var getList = commonFunction.getJsonResult(arr);//返回值为数组 --fyq
	if( /error/.test(getList) ){
//		alert("22"+getList);
		$.toast("有异常，请返回重试", "cancel");
		console.log("获取专题getList报错："+getList);
		return false;
	}
	var date, //日期
		year, //年份
		month, //月份
		ytime; //拼接年月串
	
	console.log("type: "+typeof getList+" content: "+JSON.stringify(getList));
	
	if(getList['prtyFee'] == "-1"){
		$("#party-dues-assistant-noData-id").attr({"style":"display:block"});
	}else{
		  date = new Date(getList['time']);
		  year = date.getYear()+1900;
//		  month = ("0"+date.getMonth()+1).substr(-2);
		  month = date.getMonth()+1;
		  ytime = year+"年"+month+"月";
		  
		$("#party-dues-assistant-data-id").attr({"style":"display:block"})
		$("#party-dues-assistant-time-id").html(ytime);
		$("#party-dues-assistant-money-span-id").html(getList['prtyFee'])
	}
}

/*
 * 获取党费缴纳历史记录
 */
function getPartyDuesHistory(uid,auth_token,page){
	var info = {
			"uid":uid,
			"auth_token":auth_token,
			"page":page
	}
	info = JSON.stringify(info);//将参数字符串化 --fyq;
//	alert(info);
	var arr = {
//		"url":SERVER_IP+"/question/web/index.php?r=test/list&uid="+NATIVE_UID+"&p="+page
		"url":urlbase+"?r=admin/partydues/record",
		"arr":{"info":info},
		"type":"post"
	};
	//获取数据
	var getList = commonFunction.getJsonResult(arr);//返回值为数组 --fyq
	if( /error/.test(getList) ){
//		alert("22"+getList);
		$.toast("有异常，请返回重试", "cancel");
		console.log("获取专题getList报错："+getList);
		return false;
	}
	
	console.log("type: "+typeof getList+" content: "+JSON.stringify(getList));
	
	
	
	//生成页面
	var tpl_list = $("#gray-box-iteam").html();
	var html = [];
	var display = " ";
	var weeks = ["周日","周一","周二","周三","周四","周五","周六"] ;
	
	
	 var year  //年份
	 var month ; //月份
	 var day ; //一月中的第几天
	 var week ; //周几
	 var ytime ;
	 var mtime ;
	for( var i=0; i<getList.length; i++ ){
		
		  date = new Date(getList[i]['time']);//生成时间戳
		  year = date.getYear()+1900; //提取年份
		  month = ("0"+(date.getMonth()+1)).substr(-2); //提取月份
		  day =("0"+date.getDate()).substr(-2); //提取某天唯一月中的第几天
		  week = weeks[date.getDay()]; //提取某天为周几
		  ytime = year+"年"+month+"月";
		  mtime = month+"-"+day;
		  console.log(getList[i]['time']+" "+"date："+date+" "+(year)+" "+(month)+" "+day+" "+week+" "+ytime+" "+mtime);
		  
		var html_iteam = tpl_list
			.replace( /\{ytime\}/g,ytime )
			.replace( /\{week\}/g,week )
			.replace( /\{mtime\}/g,mtime )
			.replace( /\{prtyfee\}/g,"-"+getList[i].prtyFee )
			.replace( /\{branch\}/g,getList[i].branch )
			.replace( /\{getMoney\}/g,getList[i].getMoney );
		
//		alert(html_iteam);
		
		html.push(html_iteam); //push()	向数组的末尾添加一个或更多元素，并返回新的长度。 --fyq
	}
	
	//append()	向匹配元素集合中的每个元素结尾插入由参数指定的内容。 --fyq
	//join()	把数组的所有元素放入一个字符串。元素通过指定的分隔符进行分隔。 --fyq
	$("#party-dues-h-listGroup").append( html.join('') ); 
	
	//$(selector).html(content) html() 方法返回或设置被选元素的内容 (inner HTML)。	如果该方法未设置参数，则返回被选元素的当前内容。
	//当使用该方法返回一个值时，它会返回第一个匹配元素的内容。当使用该方法设置一个值时，它会覆盖所有匹配元素的内容
	
	//判断显示是否可以继续加载下一页
	//先算一下一共有几页
	var totalpage = Math.ceil(getList.length/limit_home);
	//如果数据小于limit 则不能继续翻页 下拉加载
	if( getList.length<limit_home||getList.length==1||totalpage==page_home ){
		$(".resultEnd").hide();
		$(".resultEnd_nodata").show();
		flag_home = false;
	}else{
		flag_home = true;
		page_home++;
	}
	
}

function removeRedBackGround(){
	var iteamLabel = document.getElementsByClassName("typelabel curr");
	var typeInput = document.getElementsByClassName("type");
	var i=0;
	var len = iteamLabel.length;
for(;i<len;i++){
	iteamLabel[i].setAttribute("class","typelabel");
}
var j=0;
var len2 = typeInput.length;
for(;j<len2;j++){
	typeInput[j].setAttribute("checked","false");
}
}

function removeRedBackGround2(){
	var iteamLabel = document.getElementsByClassName("incomelabel curr");
	var typeInput = document.getElementsByClassName("incomestyle");
	var i=0;
	var len = iteamLabel.length;
for(;i<len;i++){
	iteamLabel[i].setAttribute("class","incomelabel");
}
var j=0;
var len2 = typeInput.length;
for(;j<len2;j++){
	typeInput[j].setAttribute("checked","false");
}
}

function setAttribute0(){

	var allLabel = document.getElementById("typelabel0");
	// alert(allLabel.attributes["class"].value);
	if(allLabel.attributes["class"].value=="typelabel"){
		removeRedBackGround();
		allLabel.setAttribute("class","typelabel curr");
		var man1 = document.getElementById("partymember0").setAttribute("checked","true");
	}
	else if(allLabel.attributes["class"].value=="typelabel curr"){
		allLabel.setAttribute("class","typelabel");
		var man1 = document.getElementById("partymember0").setAttribute("checked","false");
	}
	}

function setAttribute1(){

var allLabel = document.getElementById("typelabel1");
// alert(allLabel.attributes["class"].value);
if(allLabel.attributes["class"].value=="typelabel"){
	removeRedBackGround();
	allLabel.setAttribute("class","typelabel curr");
	var man1 = document.getElementById("partymember1").setAttribute("checked","true");
}
else if(allLabel.attributes["class"].value=="typelabel curr"){
	allLabel.setAttribute("class","typelabel");
	var man1 = document.getElementById("partymember1").setAttribute("checked","false");
}
}


function setAttribute2(){
	var allLabel = document.getElementById("typelabel2");
	// alert(allLabel.attributes["class"].value);
	if(allLabel.attributes["class"].value=="typelabel"){
		removeRedBackGround();
		allLabel.setAttribute("class","typelabel curr");
		var man1 = document.getElementById("partymember2").setAttribute("checked","true");

	}
	else if(allLabel.attributes["class"].value=="typelabel curr"){
		allLabel.setAttribute("class","typelabel");
		var man1 = document.getElementById("partymember2").setAttribute("checked","false");

	}
	}

function setAttribute3(){

	var allLabel = document.getElementById("typelabel3");
	// alert(allLabel.attributes["class"].value);
	if(allLabel.attributes["class"].value=="typelabel"){
		removeRedBackGround();
		allLabel.setAttribute("class","typelabel curr");
		var man1 = document.getElementById("partymember3").setAttribute("checked","true");

	}
	else if(allLabel.attributes["class"].value=="typelabel curr"){
		allLabel.setAttribute("class","typelabel");
		var man1 = document.getElementById("partymember3").setAttribute("checked","false");

	}
	}

function setAttribute4(){

	var allLabel = document.getElementById("typelabel4");
	// alert(allLabel.attributes["class"].value);
	if(allLabel.attributes["class"].value=="typelabel"){
		removeRedBackGround();
		allLabel.setAttribute("class","typelabel curr");
		var man1 = document.getElementById("partymember4").setAttribute("checked","true");

	}
	else if(allLabel.attributes["class"].value=="typelabel curr"){
		allLabel.setAttribute("class","typelabel");
		var man1 = document.getElementById("partymember4").setAttribute("checked","false");

	}
	}

function setAttribute5(){

	var allLabel = document.getElementById("typelabel5");
	// alert(allLabel.attributes["class"].value);
	if(allLabel.attributes["class"].value=="typelabel"){
		removeRedBackGround();
		allLabel.setAttribute("class","typelabel curr");
		var man1 = document.getElementById("partymember5").setAttribute("checked","true");

	}
	else if(allLabel.attributes["class"].value=="typelabel curr"){
		allLabel.setAttribute("class","typelabel");
		var man1 = document.getElementById("partymember5").setAttribute("checked","false");

	}
	}

function setAttribute6(){

	var allLabel = document.getElementById("typelabel6");
	// alert(allLabel.attributes["class"].value);
	if(allLabel.attributes["class"].value=="typelabel"){
		removeRedBackGround();
		allLabel.setAttribute("class","typelabel curr");
		var man1 = document.getElementById("partymember6").setAttribute("checked","true");

	}
	else if(allLabel.attributes["class"].value=="typelabel curr"){
		allLabel.setAttribute("class","typelabel");
		var man1 = document.getElementById("partymember6").setAttribute("checked","false");

	}
	}

function setAttribute7(){

	var allLabel = document.getElementById("incomelabel0");
	// alert(allLabel.attributes["class"].value);
	if(allLabel.attributes["class"].value=="incomelabel"){
		removeRedBackGround2();
		allLabel.setAttribute("class","incomelabel curr");
		var man1 = document.getElementById("incomebymonth").setAttribute("checked","true");

	}
	else if(allLabel.attributes["class"].value=="incomelabel curr"){
		allLabel.setAttribute("class","incomelabel");
		var man1 = document.getElementById("incomebymonth").setAttribute("checked","false");

	}
	}

function setAttribute8(){

	var allLabel = document.getElementById("incomelabel1");
	// alert(allLabel.attributes["class"].value);
	if(allLabel.attributes["class"].value=="incomelabel"){
		removeRedBackGround2();
		allLabel.setAttribute("class","incomelabel curr");
		var man1 = document.getElementById("incomebyyear").setAttribute("checked","true");

	}
	else if(allLabel.attributes["class"].value=="incomelabel curr"){
		allLabel.setAttribute("class","incomelabel");
		var man1 = document.getElementById("incomebyyear").setAttribute("checked","false");

	}
	}
function clearNoNum(obj)
{
//先把非数字的都替换掉，除了数字和.
obj.value = obj.value.replace(/[^\d.]/g,"");
//必须保证第一个为数字而不是.
obj.value = obj.value.replace(/^\./g,"");
//保证只有出现一个.而没有多个.
obj.value = obj.value.replace(/\.{2,}/g,".");
//保证.只出现一次，而不能出现两次以上
obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}