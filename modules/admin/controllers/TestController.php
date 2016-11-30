<?php
namespace app\modules\admin\controllers;
use yii;
use yii\web\Controller;
use app\modules\admin\models\AnnounceForm;
use app\models\Enterpris;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;
use app\models\Curl;
use Rest;
use Client;
class TestController extends Controller
{
	public $layout  = false;
	public function actionIndex()
	{
		require_once(dirname(__FILE__)."/config.php");
		$connection = Yii::$app->db;
		$connection->open();  //初始化数据库
		//$data['attach']  = str_replace("\u","\\\u", $qq);
		//$a=str_replace("\\","\\\\",$qq);
		
		header("Content-type:text/html;charset=utf-8");
		$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
		//$authtoken="aca3afc1ed292d2744553641c3e86a18";
		//file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======fffff=========" . $eid."/n".$authtoken."/n".$noticeid."\n", FILE_APPEND);
		//file_put_contents("/usr/local/www/nginx/html/partyqing/wt.txt", date("D M d H:i:s Y") . " ========tttt========" . json_encode($data9) ."\n", FILE_APPEND);
		$uids[0]="6@17";
		$uids[1]="8@17";
		$uid="8@17";
		$eid=explode('@',$uid);
		require_once(dirname(__FILE__)."/config.php");
	    $data=array();
        $data["api_key"]=$api_key;
        $data["auth_token"]="$token";
        $data["attr_list[0]"]="true";
        $data["eid"]="$eid[1]";
        $data["id_list[0]"]="6@17";
        $data["id_list[1]"]="8@17";
        $pc= $elggclient->post('/rest/json/?method=ldap.web.get.node.info',$data);
        //$mobile=$pc['result'][1]['data']['mobile'][0];
        //print_r($mobile);exit;

        for($i=0;$i<count($uids);$i++){
        	$data0["id_list[$i]"]=$uids[$i];
        }
        $data0["api_key"]=$api_key;
        $data0["auth_token"]="$token";
        $data0["attr_list[0]"]="true";
        $data0["eid"]="$eid[1]";
        //$data["id_list[0]"]=$uid;
        $pc= $elggclient->post('/rest/json/?method=ldap.web.get.node.info',$data0);
        // file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======22222=========" .json_encode($pc)."\n", FILE_APPEND);
        //$mobile=$pc['result'][0]['data']['mobile'][0];
        for($i=0;$i<count($uids);$i++){
        	$mobile=$pc['result'][$i]['data']['mobile'][0];
        	$data9=array();
        	$data9["api_key"]=$api_key;
        	$data9["phone_number"]="$mobile";
        	$data9["message"]="短信内容";
        	$data9["auth_token"]="$token";
        	$pc= $elggclient->post('/rest/json/?method=send.short.message',$data9);
        	file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======123444=========" .json_encode($mobile)."\n", FILE_APPEND);
        }
        
		$uid ="67@12";				
	    $_SERVER['HTTP_HOST'];		 	
		require_once(dirname(__FILE__)."/config.php");
		$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
		$data=array();
		$data["api_key"]=$api_key;
		$data["auth_token"]="$token";
		$data["attr_list[0]"]="true";
    	$data["eid"]="3";
    	$data["id_list[0]"]="35@3";
    	//$data["id_list[1]"]="6@3";    	
		//$pc= $elggclient->post('/rest/json/?method=ldap.web.search',$data);
		//print_r($pc);	
		$ictWS = new IctWebService();
		//$contacts= $ictWS->getICTContacts();
		require_once(dirname(__FILE__)."/config.php");
		$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
		$data=array();
		$data["api_key"]=$api_key;
		$data["auth_token"]="$token";
		$data["attr_list[0]"]="true";
		$data["eid"]="3";
		$data["id_list[0]"]="29@3";
		$data["id_list[1]"]="6@3";
		//$data["id_list[0]"]="null";
		//$data["id_list[0]"]="null";
		//$pc= $elggclient->post('/rest/json/?method=ldap.web.search',$data);
		//$tree['children'][0]= $ictWS->createTreeData($pc['result']['0']['data']);
		//$tree['children'][1]= $ictWS->createTreeData($pc['result']['1']['data']);
		//print_r($tree);
	//	print_r($pc['result']);echo 88888888888;	
	//	print_r($pc['result']);
		$pp='["\/webservice\/getheadimage.php?uid=25@4&eid=4&r=62ae74c6655002fb5e879459b84b353b"]';
		//$photo[] = json_decode(trim($pp,' '),true);
		$photo= trim($pp,'[]');
		//print_r($photo);exit;		
		echo strpos("You love php, I love php too!","php");	
		$data['receiverId']="22,666";
		$user = explode(",",$data['receiverId']);
		$user[] = "99";
		//print_r($user);		
		$sql="select SUBSTRING_INDEX('www@com', '@', -1)";//check是关键字
		//$sql="select * from noticeinfo where type=0";
		$result = $connection->createCommand($sql);
		$in = $result->queryAll();
		//print_r($in);

	}
}
