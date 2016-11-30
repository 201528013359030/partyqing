<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
//date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
require_once("Curl.php");
$curl = new Curl();
$url = "http://127.0.0.1/elgg/services/api/rest/json/?method=". "auth.gettoken";
$params['name']="buliping";
$params['password']="123456";
$params['api_key']="36116967d1ab95321b89df8223929b14207b72b1";
$elggAdmin = json_decode($curl->post($url, $params), true);
$auth_token = $elggAdmin['result']['auth_token'];
$api_key = $params['api_key'];

$paramsData['id_list[0]'] = 'root';
$paramsData["attr_list[0]"] = 'wip';
$paramsData['api_key']="36116967d1ab95321b89df8223929b14207b72b1";
$paramsData['auth_token'] = $auth_token;
$url = "http://127.0.0.1/elgg/services/api/rest/json/?method="."ldap.web.get.node.info";
$wip = json_decode($curl->post($url, $paramsData),true);

$CONFIG['imageUrlPrefix'] = 'http://'.$wip['result'][0]['data']['wip'][0];
$CONFIG['imageManagerUrlPrefix'] = 'http://'.$wip['result'][0]['data']['wip'][0];
$action = $_GET['action'];

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /* 上传图片 */
    case 'uploadimage':
    /* 上传涂鸦 */
    case 'uploadscrawl':
    /* 上传视频 */
    case 'uploadvideo':
    /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state'=> 'callback参数不合法'
        ));
    }
} else {
    echo $result;
}
