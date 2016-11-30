<?php
namespace app\modules\admin\controllers;
use Yii;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;


class GuidelineController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout  = false;
//    public $layout  = 'announce';
//    public $layout  = 'layout';    
    public function actionIndex()
    {    
    	$auth = new AuthToken();
    	$auth->authTokenSession();
    	//$childuid=\yii::$app->request->get('cid');  //孩子
    	
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	$uid=\yii::$app->request->get('uid');
    	$eid=explode('@',$uid);
    	\Yii::$app->session['user.uid']=$uid;
    	header("Content-type:text/html;charset=utf-8");
    	$sq0="SELECT * FROM djguideline_category where eid='".$eid[1]."'";
    	$command = $connection->createCommand($sq0);
    	$state = $command->queryAll();
    	$count=count($state);
    	for($i=2;$i<$count;$i++){
    		if(($i-2)%3==0){
    		$state[$i]['icon']="../web/img/zysx2.png";
    		}if(($i-3)%3==0){
    		$state[$i]['icon']="../web/img/zysx3.png";
    		}if(($i-4)%3==0){
    		$state[$i]['icon']="../web/img/zysx3.png";
    		}    		
    	}
    	
        return $this->render('index',[
        		'list' => $state,        
        		//'pic' => $path,
        ]);
    }

}
