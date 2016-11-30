<?php
namespace app\modules\admin\controllers;
use Yii;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;


class TriptiplistController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout  = false;
//    public $layout  = 'announce';
//    public $layout  = 'layout';

    
    public function actionIndex()
    {    
    	//$auth = new AuthToken();
    	//$auth->authTokenSession();
    	$stateid=\yii::$app->request->get('stateid'); 
    	
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	$sq0="SELECT * FROM djbusiness_state WHERE id=".$stateid;
    	$command = $connection->createCommand($sq0);
    	$name = $command->queryOne();
    	
    	$sq0="SELECT * FROM djbusiness_list WHERE state=".$stateid;
    	$command = $connection->createCommand($sq0);
    	$state = $command->queryAll();
    	$count=count($state);   	
    	for($i=0;$i<$count;$i++){   	
    		$gradeid=$state[$i]['gradeid'];
    		$sq3="SELECT * FROM djbusiness_grade WHERE gradeid='".$gradeid."'";
    		$command = $connection->createCommand($sq3);
    		$grade = $command->queryAll();
    		if(isset($grade[0]['grade'])){
    			$state[$i]['gradename']=$grade[0]['grade'];
    		}else{
    			$state[$i]['gradename']="";
    		}
    	}
    	
        return $this->render('index',[
        		'list' => $state,
        		'count' =>$count,
        		'name' => $name['statename'],
        ]);
    }
}
