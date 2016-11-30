<?php
namespace app\modules\admin\controllers;
use Yii;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;

class TaskinsteadController extends \yii\web\Controller
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
    	    
        //echo $orgid;
        $eid=explode('@',$uid);
        $eid=$eid[1];
     
    	if($s==1){//未完成
    	$sql="SELECT * FROM task_submit s,djresponsitask t WHERE (s.taskstate=0 OR s.taskstate=1 OR s.taskstate=3 OR editflag=1) AND s.assignuid='".$uid."' and s.assign=1 and s.taskNo=t.taskNo order by starttime asc LIMIT 15";
    	}else{//已完成s=2
    	$sql="SELECT * FROM task_submit s,djresponsitask t WHERE (s.taskstate=2)  AND editflag=0 AND s.assignuid='".$uid."' and s.assign=1 and s.taskNo=t.taskNo order by starttime asc LIMIT 15";
    	//$sql="SELECT * FROM djtask_list l,djtask_content c WHERE (l.taskstate=2 or l.approverId) AND l.reporterId='".$uid."' AND l.taskNo=c.taskNo AND l.year=c.year ORDER BY c.starttime desc LIMIT 3";    		 
    	}
    	$command = $connection->createCommand($sql);
    	$task = $command->queryAll();    
    	//print_r($task);
    	$count=count($task);
    	for($i=0;$i<$count;$i++){
    		//echo $task[$i]['reporterId'];    		
    		$sql="SELECT name FROM memberlist WHERE guid='".$task[$i]['reporterId']."'";
    		$command = $connection->createCommand($sql);
    		$name0 = $command->queryOne();
    		$task[$i]['name']=$name0['name'];
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
    	$eid=explode('@',$uid);
    	$eid=$eid[1];
    	$public_count=\Yii::$app->session['public_count'];
    	if($s==1){//未完成
    		$sql="SELECT * FROM task_submit s,djresponsitask t WHERE (s.taskstate=0 OR s.taskstate=1 OR s.taskstate=3 OR editflag=1) AND s.assignuid='".$uid."' and s.assign=1 and s.taskNo=t.taskNo order by starttime asc LIMIT ".$public_count.",15";     		 
        }else{//已完成
        	$sql="SELECT * FROM task_submit s,djresponsitask t WHERE (s.taskstate=2) AND editflag=0 AND s.assignuid='".$uid."' and s.assign=1 and s.taskNo=t.taskNo order by starttime asc LIMIT ".$public_count.",15";        	 
    	}
    	$public_count=$public_count+15;
    	\Yii::$app->session['public_count']=$public_count;   	   
    	$command = $connection->createCommand($sql);
    	$news = $command->queryAll();
    	//file_put_contents("D:\\wt1.txt","sum:".$sql."\n", FILE_APPEND);
    	$count=count($news);   	
    	for($i=0;$i<$count;$i++){
    		//echo $task[$i]['reporterId'];
    		$sql="SELECT name FROM memberlist WHERE guid='".$news[$i]['reporterId']."'";
    		$command = $connection->createCommand($sql);
    		$name0 = $command->queryOne();
    		$news[$i]['name']=$name0['name'];
    	}
    	echo json_encode($news);
    	exit();
    }
}
