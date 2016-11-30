<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\View;
?>
<style>
<!--
-->
</style>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta content="telephone=no" name="format-detection" />
<title>廉政教育</title>
<?=Html::cssFile('@web/css/announce.css')?>
<?=Html::jsFile('@web/js/iscroll.js')?>
<?=Html::jsFile('@web/js/jquery.js')?>
<?=Html::jsFile('@web/js/jquery-1.11.2.js')?>
<?=Html::jsFile('@web/js/bootstrap.js')?>
<?=Html::jsFile('@web/js/htmlset.js')?>
<style>
.btnBox .btnCheck {
background-color: #30BF78;
width: 36%;
margin-right: 8px;
}
.btnBox .active {
background-color: #f2f2f2;
color: #444;
}
body {
background-color: #fff;
}
.moGrid {
background-color: #ffffff;
}
</style>
</head>
<body>
	
<div id="wrap" class="wrap">
	<div class="moGrid">		
		<div class="header">							                          
			<h1><?=$content['title']?></h1>
			<p class="lead">                
                <span class="fr corFocus">
                    <i class="ficon ic_eye"></i>
                        <?=$content['readd']?>
                </span>
				<span class="fl corDate"><?=$content['time']?></span> <span class="fl corFocus"><?=$content['sender']?></span>
			</p>
		</div>
	</div>
	<div class="moGrid">	
		<div class="content">
			<!-- <p>				
				<img src="images/temp1.jpg">
			</p> -->
			<p>			
			<?=$content['content']?>
			</p>
		</div>
	</div>
	<div class="moGrid" id="attaBox">
	</div>
	<div class="moGrid">
		<div class="btnBox">			
		</div>
	</div>
</div>
<a id="sendSucceed" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#sendModal" style="display:none">
</a>
<input type="hidden" id="attach_count" value=<?//=$attach_count?>></input>

<script type="text/javascript">
var countid="";
var intervalid;
intervalid=clearInterval(intervalid);
function go(){
	//alert(78);
    var url = "index.php?r=admin/jiaoyu/time";
    url = url + "&id=" + <?=$id?>+ "&countid=" + countid;
    $.get(url, null, function callback(data,status){   	   
        //console.log(data);
               if(status=="success"){             	 
                   countid=data;  
               }
    });
}
intervalid=setInterval("go()", 5000);//1000=1s
var cls;
function g( selector ){
	var method = selector.substr(0,1) == '.'?'getElementsByClassName':'getElementById';
	return document[method]( selector.substr(1) );
}	
var isiOS = false;
var isAndroid = false;
var u = navigator.userAgent, app = navigator.appVersion;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
API.init();  
if(isAndroid==true){
	//alert(33);
	setTimeout(function(){
		//获取客户信息
		var op = {
			       "name": "StartSystemEventMonitor",
			       "callback": "OnStartSystemEventMonitorCb",
			       "params": {
			           "systemEventType":"systemCall,screenLock,appBackground"       
			        }
			};
			    //alert(JSON.stringify(op));
			    API.send_tonative(op);
	},200);
}
	//setTimeout(function(){
     function  OnDidFinishLoadCb(data){
    	 var op = {
  		       "name": "StartSystemEventMonitor",
  		       "callback": "OnStartSystemEventMonitorCb",
  		       "params": {
  		           "systemEventType":"systemCall,screenLock,appBackground"       
  		        }
  		};
  		    //alert(JSON.stringify(op));
  		    API.send_tonative(op);
     }
   //},200);

function OnStartSystemEventMonitorCb(param){
	//intervalid=clearInterval(intervalid);
    params = param.result.params; 
    //alert(JSON.stringify(params));
    if(params.systemEventType == 'systemCall'){
    /*	if(params.state=='systemCallStateConnected'||params.state=='systemCallStateIncoming'||params.state=='systemCallStateDialing'){    		
    		intervalid=clearInterval(intervalid);
 	        }else if(params.state=='systemCallStateDisconnected'){
 	        	countid="";
 	        	alert(34);
 	        	intervalid=setInterval("go()", 5000);
  	            }       */
    }else if(params.systemEventType == 'screenLock'){
    /*	if(params.state=='screenLockStateLocked'){  		    		
    		intervalid=clearInterval(intervalid);   		
        	}else if(params.state=='screenLockStateUnlocked'){
        		countid="";
        		alert(11);
        		intervalid=setInterval("go()", 5000);
            }*/
    }else if(params.systemEventType == 'appBackground'){        
    	if(params.state=='appBackgroundStateBackground'){
    		intervalid=clearInterval(intervalid);
        	}else if(params.state=='appBackgroundStateForeground'){
        		countid="";
        		//alert(countid);
        		alert(12);
        		intervalid=setInterval("go()", 5000);
            }
    }
}
</script>
<script>
var xx=document.getElementsByName('divvideocontent');
if(xx.length>0){
for(i=0;i<=xx.length;i++){	
var width = document.getElementsByName('divvideocontent')[i].offsetWidth;	

document.getElementsByName('divvideocontent')[i].style.height=parseInt(width)/4*3+'px';
} 
}
</script>   
</body>
</html>




