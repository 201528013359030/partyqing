<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\modules\admin\models\AuthToken;
use app\modules\admin\models\IctWebService;
use Rest;
use Client;
class JiaoyuController extends Controller
{
	public $layout  = false;
    public function actionIndex()
    {
        //$auth = new AuthToken();    
        //$auth->authTokenSession();
    	$id=\Yii::$app->request->get('id');        
        $uid=\Yii::$app->session['user.uid'];
        //$uid="7@3";
        //\Yii::$app->session['user.uid']=$uid;
        $connection = Yii::$app->db;
        $connection->open();
        //echo $id;
      	$condition="select * from djjiaoyu where id='".$id."'";
    	$result = $connection->createCommand($condition);
    	$inte = $result->queryOne();    	    	
    	//print_r($inte['content']);
    	
    	$inte['content']=str_replace('http://123.57.39.181/djsys/upload/image','https://123.57.39.181/djsys/upload/image', $inte['content']);
    	//var_dump($inte['content']);
    	$sq0="UPDATE djjiaoyu SET readd=readd+1 WHERE id='".$id."'";
    	$command = $connection->createCommand($sq0);
    	$command->execute();
    	
    	$sql1="select * from djjiaoyu_reader where uid='".$uid."' and studyinfo_id = '".$id."'";
    	$result1 = $connection->createCommand($sql1);
        $ret = $result1->queryOne();
        //print_r($ret);
        $sql2="UPDATE djjiaoyu_reader SET relation = 'read' where uid='".$uid."' and studyinfo_id = '".$id."'";
        $command = $connection->createCommand($sql2);
        $command->execute();
    	return $this->render('index',
    			array('content'=>$inte,
    	              'id'=>$id,
    			       'contents'=>$ret));
    }
    public function actionTime()
    {

    	$id=\Yii::$app->request->get('id');
    	$countid=\Yii::$app->request->get('countid');
    	$uid =\Yii::$app->session['user.uid'];
    	
    	$connection = Yii::$app->db;
    	$connection->open();
    	$now=date('Y-m-d H:i:s',time());
    	
    	$condition="select specialid from djjiaoyu where id='".$id."'";
    	$result = $connection->createCommand($condition);
    	$list= $result->queryOne();
    	$specialid=$list["specialid"];
    	if($countid!=""){    	
    		$sq0="UPDATE djjiaoyu_count SET end='".$now."' where id='".$countid."'";
    		$command = $connection->createCommand($sq0);
    		$command->execute();
    	}else{    	
    	$sq2="INSERT INTO  djjiaoyu_count(uid,dongtaiid,start,specialid) VALUES('$uid','$id','$now','$specialid')";
    	$command = $connection->createCommand($sq2);
    	$command->execute();
    	
    	$condition="select id from djjiaoyu_count where dongtaiid='".$id."' and uid='".$uid."' and start='".$now."'";
    	$result = $connection->createCommand($condition);
    	$countid0 = $result->queryOne();
    	$countid=$countid0['id'];
    	}
    	echo $countid;
    	//echo json_encode($countid);
    	exit();
    }
    public function actionSave(){
        $contents = \Yii::$app->request->get('contents');
        $id=\Yii::$app->request->get('id');
        $uid =\Yii::$app->session['user.uid'];
        $connection = Yii::$app->db;
        $connection->open();
        $sql0="select confirm_content from djjiaoyu_reader where uid='".$uid."' and studyinfo_id = '".$id."'";
        $result = $connection->createCommand($sql0);
        $result1 = $result->queryOne();
        $conf = '1';       
        if($result1==NULL){
           $sql1="INSERT INTO djjiaoyu_reader (confirm_content, uid, studyinfo_id, confirm) VALUES('$contents','$uid', '$id', '$conf')"; 
           $command = $connection->createCommand($sql1);
           $command->execute();
          
        }else{
            $sql2="UPDATE djjiaoyu_reader SET confirm_content = '".$contents."',confirm = '".$conf."' where uid='".$uid."' and studyinfo_id = '".$id."'";
            $command = $connection->createCommand($sql2);
            $command->execute();
            //echo json_encode($sql2);
            //exit;
            }            
        echo 1;
        exit;
    }
    
  
}
