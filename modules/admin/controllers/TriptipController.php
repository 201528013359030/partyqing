<?php
namespace app\modules\admin\controllers;
use Yii;  //全局Yii类，不在任何命名空间
use app\modules\admin\models\IctWebService; //命名空间app\modules\admin\models\中的IctWebService类
use app\modules\admin\models\AuthToken;

class TriptipController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout  = false;
//    public $layout  = 'announce';
//    public $layout  = 'layout';
    public function actionIndex()
    {
    	$auth = new AuthToken();
//     	$auth->authTokenSession();
    	$uid=\yii::$app->request->get('uid');
    	$auth_token=\yii::$app->request->get('auth_token');
    	$eid=explode('@',$uid);
    	//echo $uid;
    	//echo $auth_token;
    	//file_put_contents("/usr/local/www/nginx/html/partyqing/wt.txt","num:".$uid."num:".$auth_token."\n", FILE_APPEND);
    	\Yii::$app->session['user.uid']=$uid;

    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	$sq0="SELECT * FROM djbusiness_state where eid='".$eid[1]."'";
    	$command = $connection->createCommand($sq0);
    	$state = $command->queryAll();
    	$count=count($state);
    	\Yii::$app->session['public_count']=$count;

    	$sq0="SELECT * FROM djbusiness_grade where eid='".$eid[1]."'"."order by showorder asc" ; //调整排序功能
    	$command = $connection->createCommand($sq0);
    	$grade = $command->queryAll();
    	//\Yii::$app->session['user.gradeid']=$grade[0]['gradeid'];

    	$sq0="SELECT stateid,statename FROM djbusiness_count c,djbusiness_state s where c.uid='".$uid."' and c.stateid=s.id order by c.count desc limit 4";
    	$command = $connection->createCommand($sq0);
    	$listtop = $command->queryAll();

        return $this->render('index',[
        		'list' => $state,
        		'count' =>$count,
        		'listtop' => $listtop,
        		'grade' => $grade,
        ]);
    }
    public function actionGrade(){
    	$gradeid=\yii::$app->request->get('gradeid');
        \Yii::$app->session['user.gradeid']=$gradeid;

    }
    public function actionSearch(){

       	$searchtitle=\yii::$app->request->get('searchtitle');
    	\Yii::$app->session['public_count']=25;

    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	$uid=\Yii::$app->session['user.uid'];
    	$eid=explode('@',$uid);


    	$sq0="SELECT * FROM djbusiness_state WHERE statename like '%".$searchtitle."%' and eid='".$eid[1]."'";
    	$command = $connection->createCommand($sq0);
    	$state = $command->queryAll();
    	$count=count($state);

    	\Yii::$app->session['search_count']=$count;
    	//file_put_contents("log.log","num:". $sq2."\n", FILE_APPEND);

    	echo json_encode($state); //$state 转换为json 格式为[{key:value,key:value},{},...]。
    	exit();
    }
    public function actionGetdata(){
    	$uid=\Yii::$app->session['user.uid'];
    	$eid=explode('@',$uid);
    	//$uid =\Yii::$app->session['user.uid'];
    	//\Yii::$app->session['public_count']="5";
    	$searchcontent=\yii::$app->request->get('searchcontent');
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库

    	$public_count=\Yii::$app->session['public_count'];

    	if(strlen($searchcontent)>0){
    		$search_count=\Yii::$app->session['search_count'];
    		$sq0="SELECT * FROM djbusiness_state WHERE eid='".$eid[1]."' and statename like '%".$searchcontent."%' LIMIT ".$search_count.",25";
    		$search_count=$search_count+25;
    		\Yii::$app->session['search_count']=$search_count;

    	}else{
    		$public_count=\Yii::$app->session['public_count'];
    		$sq0="SELECT * FROM djbusiness_state where eid='".$eid[1]."' LIMIT ".$public_count.",25";
    		$public_count=$public_count+25;
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
