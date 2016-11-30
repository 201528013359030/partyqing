<?php
namespace app\modules\admin\controllers;
use yii;
use yii\web\Controller;
use Rest;
use Client;
use app\modules\admin\models\AuthToken;
use app\modules\admin\models\IctWebService;
class GuidelinedetailController extends Controller
{
	public $layout  = false;
    public function actionIndex()
    {
    	$id=\yii::$app->request->get('id');
        $auth = new AuthToken();
    	$auth->authTokenSession();    	 
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	/**************end********************/
     
    	$sq0="SELECT * FROM djguideline_detail WHERE No=".$id;
    	$command = $connection->createCommand($sq0);
    	$info = $command->queryAll();

    	//print_r($info);
        return $this->render('index',[
        		'info'=>$info[0], 
        
        ]);
    }
  
}
