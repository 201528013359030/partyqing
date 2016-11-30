<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\modules\admin\models\AuthToken;
use app\modules\admin\models\IctWebService;
use Rest;
use Client;
class DongtaiController extends Controller
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
        
      	$condition="select * from djdongtai where id='".$id."'";
    	$result = $connection->createCommand($condition);
    	$inte = $result->queryOne();    	    	
    	$inte['content']=str_replace('src="http://182.92.96.36','src="https://182.92.96.36', $inte['content']);
    	
    	$sq0="UPDATE djdongtai SET readd=readd+1 WHERE id='".$id."'";
    	$command = $connection->createCommand($sq0);
    	$command->execute();

    	return $this->render('index',
    			array('content'=>$inte,
    	              'id'=>$id));
    }
}
