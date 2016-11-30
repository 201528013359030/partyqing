<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\modules\admin\models\AuthToken;
use app\modules\admin\models\IctWebService;
use Rest;
use Client;
class TaskdetailedController extends Controller
{
	public $layout  = false;
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
        //$auth = new AuthToken();   
        //$auth->authTokenSession();
    	$check=\Yii::$app->request->get('check');
    	$id=\Yii::$app->request->get('id');
        $uid =\Yii::$app->session['user.uid'];
        $a=\Yii::$app->request->get('a');
        $connection = Yii::$app->db;
        $connection->open();  //初始化数据库
        header("Content-type:text/html;charset=utf-8");
        $sq0="SELECT * FROM djtask_list l,djtask_content c where l.taskId='".$id."' AND l.taskNo=c.taskNo AND l.year=c.year";
        $command = $connection->createCommand($sq0);
        $integralArr = $command->queryOne();
  // print_r($integralArr);
    	$attach=$integralArr["taskfiles"];
    	$attachList=json_decode($attach,true);
        $attachCount=count($attachList);
      /*  	var_dump($attachList);
       	exit(); */
        if(file_exists("/var/lib/mosquitto/tls")){
        	$tls = "https://";
        }else{
        	$tls = "http://";
        }
        //$tls = "http://";
        $ws = new IctWebService();
        $offline_ip = $ws->getAdminToken();
        if(is_array($attachList)){
            for($i=0;$i<count($attachList);$i++){
                if(!isset($attachList[$i]['path'])){
                }
                $tmpUrl = explode("media_file/",$attachList[$i]['path']);
                $attachList[$i]['path'] = $tls.$offline_ip['result']['offline_ip']."/media_file/".$tmpUrl[1];
                $attachList[$i]['url'] = $attachList[$i]['path'];
                $attachList[$i]['path'] = base64_encode($attachList[$i]['path']);
            }
        }
$uid =$integralArr['reporterId'];
$eid=explode('@',$uid);
$uid1=explode(',',$integralArr['approverId']);
require_once(dirname(__FILE__)."/config.php");
$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
$data=array();
$data["api_key"]=$api_key;
$data["auth_token"]="$token";
$data["attr_list[0]"]="true";
$data["eid"]=$eid[1];
$data["id_list[0]"]=$uid;
//$data["id_list[1]"]="27@3";
if(empty($uid1[0])){}else{
$data["id_list[1]"]=$uid1[0];
}
$pc= $elggclient->post('/rest/json/?method=ldap.web.get.node.info',$data);
//print_r($pc);
$name=$pc['result'][0]['data']['membername'][0];
if(isset($pc['result'][0]['data']['imgurl'][0])){$imgurl=$url.$pc['result'][0]['data']['imgurl'][0];}else{
	$imgurl="../web/img/temp/avatar.png";
}
if(empty($uid1[0])){$name1="";}else{
$name1=$pc['result'][1]['data']['membername'][0];
}
$integralArr['name1']=$name1;
$integralArr['name']=$name;
$imgurl = str_replace("http","https", $imgurl);
$integralArr['avator']=$imgurl;
if($imgurl==""){$imgurl="../web/img/temp/avatar.png";}

       $sq3="SELECT * FROM djtask_procedure where taskId='".$id."' ORDER BY approvertime ASC";
       $command = $connection->createCommand($sq3);
       $list = $command->queryAll();
      // print_r($list);
    	return $this->render('index',array('list'=>$list,'content'=>$integralArr,'attachList'=>$attachList,
    	   'a'=>$a,'attach_count'=>$attachCount,'check'=>$check,'id'=>$id,'uid'=>$uid,'offline_ip'=>$offline_ip['result']['offline_ip']));
    }
 public function actionCheck(){
 	    header("Content-type:text/html;charset=utf-8");
    	$comment=\yii::$app->request->post('comment');
    	$id=\yii::$app->request->post('taskid');
    //	$uid ="7@3";
    	$uid=\Yii::$app->session['user.uid'];
    	$connection = Yii::$app->db;
    	$connection->open();
    	$now=date('Y-m-d H:i:s',time());
    	require_once(dirname(__FILE__)."/config.php");
    	$data9=array();
    		$sq0="UPDATE djtask_list SET taskstate=2,approvertime='".$now."' WHERE taskId='".$id."'";
            $command = $connection->createCommand($sq0);
            $command->execute(); 
            $sq2="INSERT INTO  djtask_procedure(taskId,uid,comment,approvertime,commentcontent) VALUES('$id','$uid','2','$now','$comment')";
            $command = $connection->createCommand($sq2);
            $command->execute();
            
            $sq0="SELECT reporterId FROM djtask_list WHERE taskId='".$id."'";
            $command = $connection->createCommand($sq0);
            $info = $command->queryAll();
            $data9["uids[0]"]=$info[0]['reporterId'];
            $eid=explode('@',$uid);
            // $data9["uids[0]"]="$uids";
            $data9["id"]="4";
            $data9["api_key"]=$api_key;
            $data9["eid"]="$eid[1]";
            $data9["title"]="审批通知";
            $data9["url"]="/partyqing/web/index.php?r=admin/mytask/index&s=1&uid=";
            $data9["auth_token"]="$token";
            $pc= $elggclient->post('/rest/json/?method=lapp.notice',$data9);
    	return $this->redirect(['taskdetailed/index',"a"=>1,"id"=>$id]);
    	//file_put_contents("D:\\wt1.txt","sum:".$sql."\n", FILE_APPEND);
    	exit();
    }
    public function actionCheckno(){   	 
    	$comment=\yii::$app->request->post('comment');
    	$id=\yii::$app->request->post('taskid');
    	//$uid ="7@3";
    	$uid=\Yii::$app->session['user.uid'];
    	$connection = Yii::$app->db;
    	$connection->open();
    	$now=date('Y-m-d H:i:s',time());
    	require_once(dirname(__FILE__)."/config.php");
    	$data9=array();
    		$sq0="UPDATE djtask_list SET taskstate=3,approvertime='".$now."' WHERE taskId='".$id."'";
            $command = $connection->createCommand($sq0);
            $command->execute(); 
            $sq2="INSERT INTO  djtask_procedure(taskId,uid,comment,approvertime,commentcontent) VALUES('$id','$uid','3','$now','$comment')";
            $command = $connection->createCommand($sq2);
            $command->execute();
            $sq0="SELECT reporterId FROM djtask_list WHERE taskId='".$id."'";
            $command = $connection->createCommand($sq0);
            $info = $command->queryAll();
            $data9["uids[0]"]=$info[0]['reporterId'];
            $eid=explode('@',$uid);
            // $data9["uids[0]"]="$uids";
            $data9["id"]="4";
            $data9["api_key"]=$api_key;
            $data9["eid"]="$eid[1]";
            $data9["title"]="审批通知";
            $data9["url"]="/partyqing/web/index.php?r=admin/mytask/index&s=1&uid=";
            $data9["auth_token"]="$token";
            $pc= $elggclient->post('/rest/json/?method=lapp.notice',$data9);
    		return $this->redirect(['taskdetailed/index',"a"=>1,"id"=>$id]);
    	//file_put_contents("D:\\wt1.txt","sum:".$sql."\n", FILE_APPEND);
    	exit();
    	 
    }
    public function actionDownload(){
    	$fileurl=\yii::$app->request->get('file');
    	$filename=\yii::$app->request->get('name');
     //   $fileinfo = get_headers($fileurl, 1); 
        //$fileurl = "http://127.0.0.1".base64_decode($fileurl);
        $fileurl = base64_decode($fileurl);
        $tmpUrl = explode("media_file/",$fileurl);
        $fileurl = "http://"."127.0.0.1"."/media_file/".$tmpUrl[1];
        $fileinfo = get_headers($fileurl, 1);
        ob_end_clean(); //函数ob_end_clean 会清除缓冲区的内容，并将缓冲区关闭，但不会输出内容。
        header("Content-Type: application/force-download;"); //告诉浏览器强制下载
        header("Content-Transfer-Encoding: chunked"); 
        header("Content-Disposition: attachment; filename=$filename");   //attachment表明不在页面输出打开，直接下载
        header("Content-Length: ". $fileinfo['Content-Length']);
        header("Expires: 0"); 
        header("Cache-control: private"); 
        header("Pragma: no-cache"); //不缓存页面
        $filesize = readfile($fileurl);

    }

}
