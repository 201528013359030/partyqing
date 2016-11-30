<?php
 use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?=Html::cssFile('@web/css/bootstrap.min.css')?>
  <?=Html::cssFile('@web/css/login.css')?>
  <?=Html::cssFile('@web/css/freshman.css')?>
 <?=Html::jsFile('@web/js/jquery.js')?>
 <?=Html::jsFile('@web/js/htmlset.js')?>
    <title>
        公告
    </title>
    <style>
        body {
        }
    </style>

</head>

<body>
    <div class="container" style="padding-top: 15%;">
        <div class="stateBox ">
            <p class="title">    
                <i class="ficon ic_ok"></i>
                <span>发送成功</span>
            </p>
        </div>
        <div class="from-group">
                <!-- Button -->
                <div class="col-sm-12">
                    <div id="UidBtnPos">
                        <!--input type="button" class="btn btn-lg btn-block btn-default checkUidBtn" value="确定" onclick="closeWebview();"-->
                        <input type="button"  class="btn btn-lg btn-block btn-default checkUidBtn" onclick="closeWebview();" value='确定'>
                    </div>
                </div>
        </div>
    </div>

</body>
<script type="text/javascript">
API.init();
function closeWebview(){
    var u = navigator.userAgent, app = navigator.appVersion;
    isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
    isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    if(isAndroid || isiOS){
        var op = {
            "name":"CloseWebView"
        };
        API.send_tonative(op);
    }
    window.location.href = "index.php?r=admin/announce/index&gid=0";
}
</script>
</html>
