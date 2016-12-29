<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta id="viewport" name="viewport"
	content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title>党费助手</title>

<?php use yii\helpers\Html;?>
<script ">
function submit(){
x=document.getElementsByName("man");
document.write("<p>来自 intro 段落的文本：" + x.innerHTML + "</p>");
}
</script>

<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>


<style type="text/css">
html,body{
	margin:0;
	padding:0;
	width:100%;
	overflow-x:hidden;
}
.party-title{
	background:#eeeeee;
	font-family:"微软雅黑";
	font-size:20px;
	color:#303030;
	margin:0;
	padding:0;
	padding:10px 0 10px 10px;
	margin-bottom:15px;
}
.party-title2{
	background:#eeeeee;
	font-family:"微软雅黑";
	font-size:20px;
	color:#303030;
	margin:0;
	padding:0;
	padding:10px 0 10px 10px;
	margin:15px 0;
}
.typelabel, .incomelabel {
	font-family:"微软雅黑";
	font-size:15px;
	display: inline-block;
	vertical-align: top;
	padding: 3px 12px;
	margin-right: 10px;
	color: #0e0e0e;
	border:dashed 1px #a1a1a1;
	margin:6px 6px;
	border-radius:20px;
}
.typelabel.curr, .incomelabel.curr {
	background: #ce2123;
	font-family:"微软雅黑";
	font-size:15px;
	display: inline-block;
	vertical-align: top;
	padding: 3px 12px;
	margin-right: 10px;
	color: #fff;
	border:solid 1px #FC4D46;
	margin:6px 6px;
	border-radius:20px;
}
.income-box{
	width:100%;
	overflow:hidden;
	padding:10px 20px;
}
.income-left{
	float:left;
	font-family:"微软雅黑";
	font-size:15px;
	color:#0e0e0e;
	width:120px;
}
.income-right{
	float:left;
	width:50%;
	border-bottom:solid 1px #0a0a0a;
}
.income-right input{
	width:50%;
	border:none;
	padding:0;
	margin:0;
	outline:none;
	font-family:"微软雅黑";
	font-size:15px;
	text-align:right;
}
.income-right2{
	font-family:"微软雅黑";
	font-size:15px;
	color:#999999;
}
.income-pay-calculate{
	display:block;
	width:92%;
	height:46px;
	font-family:"微软雅黑";
	font-size:20px;
	background:#b3b3b3;
	color:#707070;
	border:none;
	padding:0;
	margin:auto;
	border-radius:6px;
	margin-bottom:10px;
}

.type-content{
	padding:0 10px;
	font-family:"微软雅黑";
	font-size:14px;
	line-height:19px;
	color:#202020;
	display:none;
}
.choose-MY{
	padding:0 10px;
	font-family:"微软雅黑";
	font-size:14px;
	line-height:19px;
	color:#202020;
	display:none;
}
.pay-box{
	display:none;
}
</style>
</head>
<body>
<p class="party-title">党员类型</p>
<input type="radio" value="0" name="partymembertype" class="type" id="partymember0" checked="false" style="display:none" />
<label for="man" class="typelabel" id="typelabel0" onclick="setAttribute0();" > <span>在职党员</span> </label>
<input type="radio" value="1" name="partymembertype" class="type" id="partymember1" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel1" onclick="setAttribute1()"> <span>离退休干部、职工中党员</span> </label>
<input type="radio" value="2" name="partymembertype" class="type" id="partymember2" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel2" onclick="setAttribute2()"> <span>农民党员</span> </label>
<input type="radio" value="3" name="partymembertype" class="type" id="partymember3" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel3" onclick="setAttribute3()"> <span>学生党员</span> </label>
<input type="radio" value="4" name="partymembertype" class="type" id="partymember4" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel4" onclick="setAttribute4()"> <span>下岗失业党员</span> </label>
<input type="radio" value="5" name="partymembertype" class="type" id="partymember5" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel5" onclick="setAttribute5()"> <span>依靠抚恤或救济生活党员</span> </label>
<input type="radio" value="6" name="partymembertype" class="type" id="partymember6" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel6" onclick="setAttribute6()"> <span>领取当地最低生活保障的党员</span> </label>
<div class="incomestylee-choose">
	<p class="party-title2">收入方式</p>
	<input type="radio" value="0" name="incomestyle" class="incomestyle" id="incomebymonth" checked="false" style="display:none" />
	<label for="incomebymonth" class="incomelabel" id="incomelabel0" onclick="setAttribute7()">
		<span>按月 (税后)</span>
	</label>
	<input type="radio" value="1" name="incomestyle" class="incomestyle" id="incomebyyear" checked="false" style="display:none"/>
	<label for="incomebyyear" class="incomelabel" id="incomelabel1" onclick="setAttribute8()">
		<span>按年 (税后)</span>
	</label>
</div>
<p class="party-title2">需缴党费计算</p>
<div class="income-box">
	<label for="income" class="income-title" id="incomelabel">
		<div class="income-left">
			<span>收入金额 (税后)</span>
		</div>
		<div class="income-right">
			<input type="text" value="0.00" name="income" class="income" id="income" onfocus="document.getElementById('income').value = null;"  onkeyup="clearNoNum(this);">
			<span class="income-right2">元/人民币</span>
		</div>
	</label>
</div>
<div class="income-box pay-box">
	<div class="income-left">
		<label for="income" class="income-title" id="paylabel">
			<span>每月需缴党费为</span>
		</label>
	</div>
	<div class="income-right">
		<input type="text" value="0.00" name="pay" class="pay" id="pay" readonly="readonly">
		<span class="income-right2">元/人民币</span>
	</div>
</div>

<p class="type-content">
党员交纳党费的比例为：<br/>
每月工资收入(税后)在3000元以下(含3000元)者，交纳月工资收入的0.5%;<br/>
3000元以上至5000元(含 5000元)者，交纳1%;<br/>
5000元以上至10000元(含10000元)者，交纳1.5%;<br/>
10000元以上者，交纳2%。
</p>
<p class="type-content">
离退休干部、职工中的党员，每月以实际领取的离退休费总额或养老金总额为计算基数，5000元以下(含5000元)的按0.5%交纳党费，5000元以上的按1%交纳党费。。
</p>
<p class="type-content">
农民党员每月交纳党费0.2元-1元。
</p>
<p class="type-content">
学生党员每月交纳党费0.2元。
</p>
<p class="type-content">
下岗失业的党员每月交纳党费0.2元。
</p>
<p class="type-content">
依靠抚恤或救济生活的党员每月交纳党费0.2元。
</p>
<p class="type-content">
领取当地最低生活保障金的党员每月交纳党费0.2元。
</p>
<p class="choose-MY">
实行年薪制人员中的党员，每月以当月实际领取的薪酬收入为计算基数，参照第一条、第二条规定交纳党费
</p>
<br/>
<button class="income-pay-calculate" id="income-pay-calculate">计算</button>
<script type="text/javascript">
var tY = 0;
var iMY = 0;
$('.typelabel').click(function(){
	var t = $(this).index('.typelabel');
	$('.type-content').css('display','none');
	$('.type-content').eq(t).css('display','block');
	tY = t;
	if(tY>1){
		$('.incomestylee-choose').hide();
		$('.income-box').eq(0).hide();
		$('.income-pay-calculate').hide();
		}
	else{
		$('.incomestylee-choose').show();
		$('.income-box').eq(0).show();
		$('.income-pay-calculate').show();
		}
	})
$('.incomelabel').click(function(){
	iMY = $(this).index('.incomelabel');
	if(iMY==1){
		$('.choose-MY').css('display','block');
		}
	else{
		$('.choose-MY').css('display','none');
		}
	})
$('.income').keyup(function(){
	$('.income-pay-calculate').css('color','white').css('background','#ce2123')
	})
$('.income-pay-calculate').click(function(){
	$('.pay-box').css('display','block');
	var i = document.getElementById('income').value;
	var p =0;
	if(tY==0){
		if(i<3001){
			p = i*0.005;
			}
		else if(i>3000 & i<5001 ){
			p = i*0.01;
			}
		else if(i>5000 & i<10001){
			p = i*0.015;
			}
		else if(i>10000){
			p = i*0.02;
			}
		}
	else if(tY==1){
		if(i<5001){
			p = 0.005*i;
			}
		else{
			p = 0.01*i;
			}
		}
	p=Math.ceil(p*10);
	p=p*1.0/10;
	document.getElementById('pay').value = p;
	})



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





</script>
</body>
</html>
