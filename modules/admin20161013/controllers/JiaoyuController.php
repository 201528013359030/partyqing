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
       // $auth->authTokenSession();
    	$id=\Yii::$app->request->get('id');
  //$uid="22@33";
        $uid=\Yii::$app->session['user.uid'];
        $connection = Yii::$app->db;
        $connection->open();
      	$condition="select * from djjiaoyu where id='".$id."'";
    	$result = $connection->createCommand($condition);
    	$inte = $result->queryOne();    	    	
    	
    	$sq0="UPDATE djjiaoyu SET readd=readd+1 WHERE id='".$id."'";
    	$command = $connection->createCommand($sq0);
    	$command->execute();

    	return $this->render('index',
    			array('content'=>$inte,
    	              'id'=>$id));
    }
    public function actionTime()
    {

    	$id=\Yii::$app->request->get('id');
    	$countid=\Yii::$app->request->get('countid');
    	$uid =\Yii::$app->session['user.uid'];
    	
    	$connection = Yii::$app->db;
    	$connection->open();
    	$now=date('Y-m-d H:i:s',time());
    	if($countid!=""){    	
    		$sq0="UPDATE djjiaoyu_count SET end='".$now."' where id='".$countid."'";
    		$command = $connection->createCommand($sq0);
    		$command->execute();
    	}else{    	
    	$sq2="INSERT INTO  djjiaoyu_count(uid,dongtaiid,start) VALUES('$uid','$id','$now')";
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
}
