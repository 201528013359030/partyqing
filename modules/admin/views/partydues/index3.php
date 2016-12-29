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



<?=Html::cssFile('@web/css/announcemy.css')?>
<?=Html::cssFile('@web/css/bootstrapmy.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>

<style type="text/css">
.typelabel,.incomelabel{
    display: inline-block;
    vertical-align: top;
    padding: 6px 8px;
    margin-right: 10px;
    color: #434343;
}

.typelabel.curr,.incomelabel.curr {
    background: #FC4D46;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    -webkit-border-radius: 4px;
}
</style>

</head>
<body>

<p>党员类型</p>
<input type="radio" value="0" name="partymembertype" class="type" id="partymember0" checked="false" style="display:none" />
<label for="man" class="typelabel" id="typelabel0" onclick="setAttribute0()" >
<span>党员</span>
</label>
<input type="radio" value="1" name="partymembertype" class="type" id="partymember1" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel1" onclick="setAttribute1()">
<span>离退休干部、职工中党员</span>
</label>

<input type="radio" value="2" name="partymembertype" class="type" id="partymember2" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel2" onclick="setAttribute2()">
<span>农民党员</span>
</label>

<input type="radio" value="3" name="partymembertype" class="type" id="partymember3" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel3" onclick="setAttribute3()">
<span>学生党员</span>
</label>

<input type="radio" value="4" name="partymembertype" class="type" id="partymember4" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel4" onclick="setAttribute4()">
<span>下岗失业党员</span>
</label>

<input type="radio" value="5" name="partymembertype" class="type" id="partymember5" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel5" onclick="setAttribute5()">
<span>依靠抚恤或救济生活党员</span>
</label>

<input type="radio" value="6" name="partymembertype" class="type" id="partymember6" checked="false" style="display:none"/>
<label for="man2" class="typelabel" id="typelabel6" onclick="setAttribute6()">
<span>领取当地最低生活保障的党员</span>
</label>
<p>收入方式</p>
<input type="radio" value="0" name="incomestyle" class="incomestyle" id="incomebymonth" checked="false" style="display:none" />
<label for="incomebymonth" class="incomelabel" id="incomelabel0" onclick="setAttribute7()" >
<span>按月（税后）</span>
</label>
<input type="radio" value="1" name="incomestyle" class="incomestyle" id="incomebyyear" checked="false" style="display:none"/>
<label for="incomebyyear" class="incomelabel" id="incomelabel1" onclick="setAttribute8()">
<span>按年（税后）</span>
</label>
<p>收入金额</p>
<label for="income" class="incomelabel" id="incomelabel" ">
<span>收入金额（税后）</span>
</label>
<input type="text" value="0" name="income" class="income" id="income" />

<label for="income" class="incomelabel" id="paylabel" ">
<span>每月需缴党费为</span>
</label>
<input type="text" value="" name="pay" class="pay" id="pay" />


<br/>
<button  onclick="submit()" >计算</button>

<script ">
function submit(){

var typeRadio=document.getElementsByName("partymembertype");
var incomeRadio=document.getElementsByName("incomestyle");
var incomeInput=document.getElementById("income");
var type;
var incomeStyle,income;
var pay,payInput;
income=incomeInput.value;


type=$('.type').val();
// console.log(typeRadio.getAttribute("value"));

// for(var i=0;i<typeRadio.length;i++)
// {
// // 	alert(New.item(i).checked);
// // alert(typeRadio.item(i).checked+""+i);
//   if(typeRadio.item(i).checked){

// 	  type=typeRadio.item(i).getAttribute("value");
// break;
// }else{
// continue;
// }
// }

alert(type);

if(!type){
	alert("请选择党员类型！！");
	return 0;
	}

incomestyle=$('.incomestyle').val();

// for(var i=0;i<incomeRadio.length;i++)
// {
// // 	alert(New.item(i).checked);
// // alert(incomeRadio.item(i).checked+""+i);
//   if(incomeRadio.item(i).checked){

// 	  incomestyle=incomeRadio.item(i).getAttribute("value");
// break;
// }else{
// continue;
// }
// }

alert(incomestyle);

if(!incomestyle){
alert("请选择收入方式！！");
return 0;
}

if(!income){
alert("请输入工资金额！！");
return 0 ;
}
// alert(type);
// if(type=="否")
// {
//   alert("商品必须为新品！");
//   return false;
// }

switch(type){
case 0:
	if(incomestyle=0){
		//收入方式按月
		if(income<=3000){
			pay=income*0.005;

		}else if(income<=5000){
			pay=income*0.01;
		}else if (income<=1000){
			pay=income*0.015;
		}else {
			pay=income*0.02;
		}
	}else{

		//收入方式按年
		}
	break;
case 1:
	if(income<=5000){
		pay=income*0.005;
	}else {
		pay=income*0.01;;
	}
	break;
case 2:
	pay='农民党员每月交纳党费0.2元-1元。';
	income=incomeInput.value;
	incomeInput.value='';
	incomeInput.value=income+'元';
	payInput=document.getElementById("pay");
	payInput.value='';
	payInput.value=pay;
	return 0;
	break;
default:
	pay=0.9;
}

income=incomeInput.value.split("元")[0];
incomeInput.value='';
incomeInput.value=income+'元';
payInput=document.getElementById("pay");
// pay=Math.ceil(pay*10);//保留一位小数，向上取整
payInput.value='';
payInput.value=pay+'元';

}
</script>

<script type="text/javascript">
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

</script>
</body>
</html>
