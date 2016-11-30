<?php
namespace app\modules\admin\controllers;
use Yii;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;

class MytaskController extends \yii\web\Controller
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
    	//\Yii::$app->session['user.uid']=$uid;
    	//echo $uid;
    	$s=\yii::$app->request->get('s');
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	
    	$sq0="SELECT officeAddress FROM memberlist WHERE guid='".$uid."'";
        $command = $connection->createCommand($sq0);
        $info = $command->queryOne();
        $orgid="";
        if($info['officeAddress']){
        	$gg=explode(',',$info['officeAddress']);
            $orgid=$gg[0];
        }
        if($info['officeAddress']){}else{
        	echo "未获取到组织架构信息";
        	return $this->render('index0',[       	
        			]);
            exit;}
        //echo $orgid;
        $eid=explode('@',$uid);
        $eid=$eid[1];
    	$sq0="SELECT t.taskNo,t.content,t.starttime,t.endtime,t.year FROM memberlist m,djresponsirole r,djresponsitask t WHERE m.guid='".$uid."' and find_in_set(r.roleid,m.business) and r.responsiid=t.parentid and t.eid='".$eid."' and((t.flag=0) or(t.flag=1 and t.orgid='".$orgid."') or(t.flag=2 and t.uid='".$uid."'))";
    	//$sq0="SELECT m.* FROM memberlist m,djresponsirole r WHERE m.guid='".$uid."' and find_in_set(r.roleid,m.business)";    	 
    	$command = $connection->createCommand($sq0);
    	$info = $command->queryAll();
    	//print_r($info);
    	$count=count($info);
    	//echo $count;
    	for($i=0;$i<$count;$i++){
    		$sq0="SELECT taskstate,assign,editflag FROM task_submit WHERE taskNo='".$info[$i]['taskNo']."' and reporterId='".$uid."'";
    		$command = $connection->createCommand($sq0);
    		$g = $command->queryOne();
    		//print_r($g);
    		//echo $i;
    		$taskNo=$info[$i]['taskNo'];
    		$year=$info[$i]['year'];
    		if($g){
    		}else{    	
    			$sq2="INSERT INTO  task_submit(taskNo,reporterId,year) VALUES('$taskNo','$uid','$year')";
    			$command = $connection->createCommand($sq2);
    			$command->execute();
    		}
    		//echo $i;
    	}
    	//echo $uid;
    	if($s==1){//未完成
    	$sql="SELECT * FROM task_submit s,djresponsitask t,memberlist m,djresponsirole r WHERE m.guid='".$uid."' and find_in_set(r.roleid,m.business) and r.responsiid=t.parentid and (s.taskstate=0 OR s.taskstate=1 OR s.taskstate=3 OR s.editflag=1) AND s.reporterId='".$uid."' and s.taskNo=t.taskNo order by t.starttime asc LIMIT 6";    	 
    	}else{//已完成s=2
    	$sql="SELECT * FROM task_submit s,djresponsitask t WHERE (s.taskstate=2) AND (s.editflag=0 OR s.editflag=2) AND s.reporterId='".$uid."' and s.taskNo=t.taskNo order by t.starttime asc LIMIT 5";
    	//$sql="SELECT * FROM djtask_list l,djtask_content c WHERE (l.taskstate=2 or l.approverId) AND l.reporterId='".$uid."' AND l.taskNo=c.taskNo AND l.year=c.year ORDER BY c.starttime desc LIMIT 3";    		 
    	}
   	
    	$command = $connection->createCommand($sql);
    	$task = $command->queryAll();
    
    	//print_r($task);
    	$count=count($task);
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
    	$sq0="SELECT officeAddress FROM memberlist WHERE guid='".$uid."'";
    	$command = $connection->createCommand($sq0);
    	$info = $command->queryOne();
    	if($info['officeAddress']){
    		$gg=explode(',',$info['officeAddress']);
    		$orgid=$gg[0];
    	}
    	//echo $orgid;
    	$eid=explode('@',$uid);
    	$eid=$eid[1];

    	$public_count=\Yii::$app->session['public_count'];
    	if($s==1){//未完成
    		$sql="SELECT * FROM task_submit s,djresponsitask t,memberlist m,djresponsirole r WHERE m.guid='".$uid."' and find_in_set(r.roleid,m.business) and r.responsiid=t.parentid and (s.taskstate=0 OR s.taskstate=1 OR s.taskstate=3 OR s.editflag=1) AND s.reporterId='".$uid."' and s.taskNo=t.taskNo order by t.starttime asc LIMIT ".$public_count.",15";     		
    	 }else{//已完成
        	$sql="SELECT * FROM task_submit s,djresponsitask t WHERE (s.taskstate=2) AND editflag=0 AND s.reporterId='".$uid."' and s.taskNo=t.taskNo order by starttime asc LIMIT ".$public_count.",15";        	 
        	//$sql="SELECT * FROM djtask_list l,djtask_content c WHERE l.taskstate=2 AND l.reporterId='".$uid."' AND l.taskNo=c.taskNo AND l.year=c.year ORDER BY c.starttime desc LIMIT ".$public_count.",15";
    	}
    	$public_count=$public_count+15;
    	\Yii::$app->session['public_count']=$public_count;   	   
    	$command = $connection->createCommand($sql);
    	$news = $command->queryAll();
    	file_put_contents("/usr/local/www/nginx/html/partyqing/wt.txt","sum:".$sql."\n", FILE_APPEND);
    	$count=count($news);   	
    	echo json_encode($news);
    	exit();
    }
}
