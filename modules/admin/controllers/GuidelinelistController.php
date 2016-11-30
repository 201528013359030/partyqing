<?php
namespace app\modules\admin\controllers;
use Yii;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;


class GuidelinelistController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout  = false;
//    public $layout  = 'announce';
//    public $layout  = 'layout';

    
    public function actionIndex()
    {    
    	//$auth = new AuthToken();
    	//$auth->authTokenSession();
    	$id=\yii::$app->request->get('id');  

    	$uid=\Yii::$app->session['user.uid'];
    	$eid=explode('@',$uid);
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	$sq2="SELECT * FROM djguideline_category WHERE No='".$id."' and eid='".$eid[1]."'";
    	$command = $connection->createCommand($sq2);
    	$name = $command->queryOne();
    	$sq0="SELECT * FROM djguideline_detail WHERE guidelineid=".$id." ORDER BY createtime desc LIMIT 15";
    	$command = $connection->createCommand($sq0);
    	$state = $command->queryAll();
    	$count=count($state);
    	\Yii::$app->session['public_count']=$count;
        return $this->render('index',[
        		'list' => $state,
        		'count' =>$count,
        		'id' => $id,
        		'name' => $name['name'],
        ]);
    }
    public function actionSearch(){
    
       	$searchtitle=\yii::$app->request->get('searchtitle');
       	$id=\yii::$app->request->get('id');
    	\Yii::$app->session['public_count']=15;
    	$uid=\Yii::$app->session['user.uid'];
    	$eid=explode('@',$uid);
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
       	 
    	$sq0="SELECT * FROM djguideline_detail WHERE guidelineid=".$id." AND (title like '%".$searchtitle."%' or keywords like '%".$searchtitle."%') ORDER BY createtime desc LIMIT 15";    	 
    	//$sq0="SELECT * FROM guideline_detail WHERE guidelineid=".$id." AND (keywords like '%".$searchtitle."%') ORDER BY createtime desc LIMIT 5";
    	 
    	//$sq0="SELECT * FROM business_state WHERE state like '%".$searchtitle."%' LIMIT 5";
    	$command = $connection->createCommand($sq0);
    	$state = $command->queryAll();
    	$count=count($state);
    	
    	\Yii::$app->session['search_count']=$count;
    	//file_put_contents("log.log","num:". $sq2."\n", FILE_APPEND);
 
    	echo json_encode($state);
    	exit();
    }
    public function actionGetdata(){
    	 
    	//$uid =\Yii::$app->session['user.uid'];
    	//\Yii::$app->session['public_count']="5";
    	$searchcontent=\yii::$app->request->get('searchcontent');  
    	$id=\yii::$app->request->get('id');
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	$uid=\Yii::$app->session['user.uid'];
    	$eid=explode('@',$uid);
    	$public_count=\Yii::$app->session['public_count'];
    	 
    	if(strlen($searchcontent)>0){
    		$search_count=\Yii::$app->session['search_count'];
    		$sq0="SELECT * FROM djguideline_detail WHERE guidelineid=".$id." AND title like ('%".$searchcontent."%' or keywords like '%".$searchcontent."%') ORDER BY createtime desc LIMIT ".$search_count.",15";    		 
    		$search_count=$search_count+15;
    		\Yii::$app->session['search_count']=$search_count;
    		 
    	}else{
    		$public_count=\Yii::$app->session['public_count'];
    		$sq0="SELECT * FROM djguideline_detail WHERE guidelineid=".$id." ORDER BY createtime desc LIMIT ".$public_count.",15";     		 
    		$public_count=$public_count+15;
    		\Yii::$app->session['public_count']=$public_count;
    	}
    
    	$command = $connection->createCommand($sq0);
    	$news = $command->queryAll();
    	//print_r($course);
    	//file_put_contents("D:\\wt1.txt","sum:".$sql."\n", FILE_APPEND);
    	\Yii::$app->session['searchcontent']=$searchcontent;
    	$count=count($news);
    	 
    	echo json_encode($news);
    	exit();
    }
}
