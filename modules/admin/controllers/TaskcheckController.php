<?php
namespace app\modules\admin\controllers;
use Yii;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;


class TaskcheckController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout  = false;
//    public $layout  = 'announce';
//    public $layout  = 'layout';    
    public function actionIndex()
    {    
    	//$auth = new AuthToken();
    	//$auth->authTokenSession();
    	
    	$uid=\yii::$app->request->get('uid'); 
    	\Yii::$app->session['user.uid']=$uid;
    	$s=\yii::$app->request->get('s');
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	//echo $uid;
    	if($s==1){//未审核
    		$sq0="SELECT * FROM task_submit s,djresponsitask t WHERE s.taskstate=1 AND s.taskNo=t.taskNo AND s.approverId='".$uid."' ORDER BY t.starttime desc LIMIT 3";    		
    	//$sql="SELECT * FROM djtask_list l,djtask_content c WHERE l.taskstate=1 AND l.approverId='".$uid."' AND l.taskNo=c.taskNo  AND l.year=c.year ORDER BY c.starttime desc LIMIT 15";
    	}else{//已审核
    		$sq0="SELECT * FROM task_submit s,djresponsitask t WHERE (s.taskstate=2 OR s.taskstate=3) AND s.taskNo=t.taskNo AND s.approverId='".$uid."' ORDER BY t.starttime desc LIMIT 20";    		
    	//$sql="SELECT * FROM djtask_list l,djtask_content c WHERE (l.taskstate=2 OR l.taskstate=3) AND l.approverId='".$uid."' AND l.taskNo=c.taskNo AND l.year=c.year ORDER BY c.starttime desc LIMIT 15";    		 
    	}
    	$command = $connection->createCommand($sq0);
    	$task = $command->queryAll();
    	//print_r($task);
    	$count=count($task);
    	if($count>0){
    	$data=array();
    	$eid=explode('@',$uid);
    	require_once(dirname(__FILE__)."/config.php");
    	$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
    	for($i=0;$i<$count;$i++){
    		$data["id_list[$i]"]=$task[$i]['reporterId'];
    	}	
    	$data["api_key"]=$api_key;
    	$data["auth_token"]="$token";
    	$data["attr_list[0]"]="true";
    	$data["eid"]=$eid[1];    	
    	$pc= $elggclient->post('/rest/json/?method=ldap.web.get.node.info',$data);
    	//print_r($pc);   	
    	//$name=$pc['result'][0]['data']['membername'][0];
    	  for($i=0;$i<$count;$i++){
    	  	if(isset($pc['result'][$i]['data']['membername'][0])){
    		   $task[$i]['name']=$pc['result'][$i]['data']['membername'][0];
    	   }else{
    	   	   $task[$i]['name']="";
    	   }
    	  }
    	}
    	\Yii::$app->session['public_count']=$count;
   
        return $this->render('index',[
        		'list' => $task,        
        		'count' => $count,
        		'uid' => $uid,
        		's' => $s,
        ]);
    }
    public function actionGetdata(){
    	 
    	//$uid ="22@22";
    	$uid=\Yii::$app->session['user.uid'];   
    	$s=\yii::$app->request->get('s');
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	$public_count=\Yii::$app->session['public_count'];
    	if($s==1){//未完成
    		$sq0="SELECT * FROM task_submit s,djresponsitask t WHERE s.taskstate=1 AND s.taskNo=t.taskNo AND s.approverId='".$uid."' ORDER BY t.starttime desc LIMIT ".$public_count.",15";    		 
    		//$sql="SELECT * FROM djtask_list l,djtask_content c WHERE l.taskstate=1 AND l.approverId='".$uid."' AND l.taskNo=c.taskNo  AND l.year=c.year ORDER BY c.starttime desc LIMIT ".$public_count.",15";
        }else{//已完成
        	$sq0="SELECT * FROM task_submit s,djresponsitask t WHERE (s.taskstate=2 OR s.taskstate=3) AND s.taskNo=t.taskNo AND s.approverId='".$uid."' ORDER BY t.starttime desc  LIMIT ".$public_count.",15";        	 
        	//$sql="SELECT * FROM djtask_list l,djtask_content c WHERE (l.taskstate=2 OR l.taskstate=3) AND l.approverId='".$uid."' AND l.taskNo=c.taskNo AND l.year=c.year ORDER BY c.starttime desc LIMIT ".$public_count.",15";
    	}
    	$public_count=$public_count+15;
    	\Yii::$app->session['public_count']=$public_count;   	   
    	$command = $connection->createCommand($sq0);
    	$task = $command->queryAll();    	
    	//print_r($course);
    	//file_put_contents("D:\\wt1.txt","sum:".$sql."\n", FILE_APPEND);
    	$count=count($task); 
    	if($count>0){
    		$data=array();
    		$eid=explode('@',$uid);
    		require_once(dirname(__FILE__)."/config.php");
    		$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
    		for($i=0;$i<$count;$i++){
    			$data["id_list[$i]"]=$task[$i]['reporterId'];
    		}
    		$data["api_key"]=$api_key;
    		$data["auth_token"]="$token";
    		$data["attr_list[0]"]="true";
    		$data["eid"]=$eid[1];
    		$pc= $elggclient->post('/rest/json/?method=ldap.web.get.node.info',$data);
    		//print_r($pc);
    		//$name=$pc['result'][0]['data']['membername'][0];
    		for($i=0;$i<$count;$i++){
    			if(isset($pc['result'][$i]['data']['membername'][0])){
    				$task[$i]['name']=$pc['result'][$i]['data']['membername'][0];
    			}else{
    				$task[$i]['name']="";
    			}
    		}
    	}  	
    	echo json_encode($task);
    	exit();
    }
    public function actionCheck(){
    	$checkall=\yii::$app->request->get('check'); 
    	//$uid ="7@3";
    	$uid=\Yii::$app->session['user.uid'];
    	$eid=explode('@',$uid);
    	$connection = Yii::$app->db;
    	$connection->open();
    	$checkall = explode(',',$checkall);   	 
    	$now=date('Y-m-d H:i:s',time());
    	require_once(dirname(__FILE__)."/config.php");
    	
    	$data9=array();
    	for($index=0;$index<count($checkall);$index++){
    		$sq0="UPDATE task_submit SET taskstate=2,approvertime='".$now."' WHERE taskId='".$checkall[$index]."'";
            $command = $connection->createCommand($sq0);
            $command->execute();
            $sq2="INSERT INTO  task_procedure(taskId,uid,comment,approvertime) VALUES('$checkall[$index]','$uid','2','$now')";
            $command = $connection->createCommand($sq2);
            $command->execute();
            $sq0="SELECT reporterId FROM task_submit WHERE taskId='".$checkall[$index]."'";
            $command = $connection->createCommand($sq0);
            $info = $command->queryAll();
            $data9["uids[$index]"]=$info[0]['reporterId'];
          // file_put_contents("D:/wt.txt"," =======rrrrrr=========" .$checkall[$index]."\n", FILE_APPEND);   
    	}   	    	  	    	    
       // $data9["uids[0]"]="$uids";    
        $data9["id"]="4";
        $data9["api_key"]=$api_key;
        $data9["eid"]="$eid[1]";
        $data9["title"]="审批通知";
        $data9["url"]="/partyqing/web/index.php?r=admin/mytask/index&s=1&uid=";
        $data9["auth_token"]="$token";
        //$pc= $elggclient->post('/rest/json/?method=lapp.notice',$data9);
                
    	return $this->redirect(['taskcheck/index',"s"=>1,"uid"=>$uid]);
    	//file_put_contents("D:\\wt1.txt","sum:".$sql."\n", FILE_APPEND);
    	exit();
    }
    public function actionCheckno(){
    	 
    	$checkall=\yii::$app->request->get('checkno');
    	//$uid ="7@3";
    	$uid=\Yii::$app->session['user.uid'];    	
    	$connection = Yii::$app->db;
    	$connection->open();
    	$checkall = explode(',',$checkall);
    	$now=date('Y-m-d H:i:s',time());
    	require_once(dirname(__FILE__)."/config.php");
    	$count=count($checkall);
    	file_put_contents("/usr/local/www/nginx/html/partyqing/wt.txt","sumssssssssssssss:".$count."\n", FILE_APPEND);
    	
    	$data9=array();
    	for($index=0;$index<$count;$index++){
    		$sq0="UPDATE task_submit SET taskstate=3,approvertime='".$now."' WHERE taskId='".$checkall[$index]."'";
            $command = $connection->createCommand($sq0);
            $command->execute(); 
            $sq2="INSERT INTO  task_procedure(taskId,uid,comment,approvertime) VALUES('$checkall[$index]','$uid','3','$now')";
            $command = $connection->createCommand($sq2);
            $command->execute();
            file_put_contents("/usr/local/www/nginx/html/partyqing/wt.txt","sum:".$sq2."\n", FILE_APPEND);
            $sq0="SELECT reporterId FROM task_submit WHERE taskId='".$checkall[$index]."'";
            $command = $connection->createCommand($sq0);
            $info = $command->queryAll();
            $data9["uids[$index]"]=$info[0]['reporterId'];
    	}
    	$eid=explode('@',$uid);
    	// $data9["uids[0]"]="$uids";
    	$data9["id"]="4";
    	$data9["api_key"]=$api_key;
    	$data9["eid"]="$eid[1]";
    	$data9["title"]="审批通知";
    	$data9["url"]="/partyqing/web/index.php?r=admin/mytask/index&s=1&uid=";
    	$data9["auth_token"]="$token";
    	$pc= $elggclient->post('/rest/json/?method=lapp.notice',$data9);
    	return $this->redirect(['taskcheck/index',"s"=>1,"uid"=>$uid]);
    	//file_put_contents("D:\\wt1.txt","sum:".$sql."\n", FILE_APPEND);
    	exit();
    	 
    }
}
