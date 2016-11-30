<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\modules\admin\models\AuthToken;
use app\modules\admin\models\IctWebService;
use Rest;
use Client;
class JiaoyuzhuantilistController extends Controller
{
	public $layout  = false;
    public function actionIndex()
    {
        //$auth = new AuthToken();    
        //$auth->authTokenSession();
       // echo $uid;
    	$id=\Yii::$app->request->get('id');
    	$uid=\yii::$app->request->get('uid');
        \Yii::$app->session['user.uid']=$uid;
        //$uid =\Yii::$app->session['user.uid'];
        $connection = Yii::$app->db;
        $connection->open();
        $eid=explode('@',$uid);
        $sq0="SELECT officeAddress FROM memberlist WHERE guid='".$uid."'";
        $command = $connection->createCommand($sq0);
        $info = $command->queryOne();
        if($info['officeAddress']){
        	$guid=explode(',',$info['officeAddress']);
        	$orgid=$guid[0];
        }
        //echo $orgid;
        $condition="select * from djjiaoyu_zhuanti where top=1 and (orgid='' or orgid='".$orgid."') and eid='".$eid[1]."' order by time desc limit 3";
        $result = $connection->createCommand($condition);
        $listtop= $result->queryAll();
        $counttop=count($listtop);
        if(empty($listtop)){
        	$listtop[0]['pic']="../web/img/banner1.png";
        	
        	$arr=getimagesize($listtop[0]['pic']);
        	//$arr[0] //宽度$arr[1] //高度
        	if($arr[0]/$arr[1]>1.789){$listtop[0]['pic2']="1";}else{$listtop[0]['pic2']="2";}
        
        	$listtop[0]['id']="";
        }else{
           for($i=0;$i<$counttop;$i++){
        	$UAvator=$listtop[$i]['pic'];
        	     
        	$arr=getimagesize($UAvator);
        	//$arr[0] //宽度$arr[1] //高度
        	if($arr[0]/$arr[1]>1.789){$listtop[$i]['pic2']="1";}else{$listtop[$i]['pic2']="2";} 
        	
            }
        }
      	$condition="select * from djjiaoyu_zhuanti where top=0 and (orgid='' or orgid='".$orgid."') and eid='".$eid[1]."' order by time desc limit 6";
    	$result = $connection->createCommand($condition);
    	$list= $result->queryAll();
    	$count=count($list);
    	for($i=0;$i<$count;$i++){
    		$UAvator=$list[$i]['pic'];
    		if($UAvator){}else{
    			$list[$i]['pic']="../web/img/pic2.png";
    		} 
    		
    		$arr=getimagesize($UAvator);
    		//$arr[0] //宽度$arr[1] //高度
    		if($arr[0]/$arr[1]>1.789){$list[$i]['pic2']="1";}else{$list[$i]['pic2']="2";}
    	
    		$a=$list[$i]['abstract'];
    		if(strstr($a,"divvideocontent")){
    			$list[$i]['video']="1";
    		}else{
    			$list[$i]['video']="0";
    		}  		 
    		$list[$i]['time']=date("Y-m-d",strtotime($list[$i]['time']));
    	}
    	\Yii::$app->session['public_count']=$count;
    	return $this->render('index',array('list'=>$list,'listtop'=>$listtop,'count'=>$count,'counttop'=>$counttop));
    }
    public function actionSearch(){
    
       	$searchtitle=\yii::$app->request->get('searchtitle');   	   
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	$uid =\Yii::$app->session['user.uid'];
    	$eid=explode('@',$uid);
    	$sq0="SELECT officeAddress FROM memberlist WHERE guid='".$uid."'";
    	$command = $connection->createCommand($sq0);
    	$info = $command->queryOne();
    	if($info['officeAddress']){
    		$guid=explode(',',$info['officeAddress']);
    		$orgid=$guid[0];
    	}
    	$sq0="select * from djjiaoyu_zhuanti where top=0 and (title like '%".$searchtitle."%') and (orgid='' or orgid='".$orgid."') and eid='".$eid[1]."'ORDER BY time desc LIMIT 15";    	
    	$command = $connection->createCommand($sq0);
    	$state = $command->queryAll();
    	$count=count($state);
    	for($i=0;$i<$count;$i++){
    		$UAvator=$state[$i]['pic'];
    		if($UAvator){}else{
    			$state[$i]['pic']="../web/img/pic2.png";
    		}
    	
    		$arr=getimagesize($UAvator);
    		if($arr[0]/$arr[1]>1.789){$state[$i]['pic2']="1";}else{$state[$i]['pic2']="2";}
    		
    		$state[$i]['time']=date("Y-m-d",strtotime($state[$i]['time']));
    	}
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
    	$uid =\Yii::$app->session['user.uid'];
    	$eid=explode('@',$uid);
    	$sq0="SELECT officeAddress FROM memberlist WHERE guid='".$uid."'";
    	$command = $connection->createCommand($sq0);
    	$info = $command->queryOne();
    	if($info['officeAddress']){
    		$guid=explode(',',$info['officeAddress']);
    		$orgid=$guid[0];
    	}
    	$public_count=\Yii::$app->session['public_count'];    	 
    	if(strlen($searchcontent)>0){
    		$search_count=\Yii::$app->session['search_count'];
    		$sq0="select * from djjiaoyu_zhuanti where top=0 and (orgid='' or orgid='".$orgid."') and eid='".$eid[1]."' and title like ('%".$searchcontent."%' or keywords like '%".$searchcontent."%') ORDER BY time desc LIMIT ".$search_count.",15";   
    		$search_count=$search_count+15;
    		\Yii::$app->session['search_count']=$search_count;
    		 
    	}else{
    		$public_count=\Yii::$app->session['public_count'];
    		$sq0="select * from djjiaoyu_zhuanti where top=0 and (orgid='' or orgid='".$orgid."') and eid='".$eid[1]."' ORDER BY time desc LIMIT ".$public_count.",15";   
    		$public_count=$public_count+15;
    		\Yii::$app->session['public_count']=$public_count;
    	}    
    	
    	$command = $connection->createCommand($sq0);
    	$news = $command->queryAll();
    	//echo json_encode($news);
    	//exit();
    	\Yii::$app->session['searchcontent']=$searchcontent;
    	$count=count($news);
    	for($i=0;$i<$count;$i++){
    		$UAvator=$news[$i]['pic'];
    		if($UAvator){}else{
    			$news[$i]['pic']="../web/img/pic2.png";
    		}
    
    		$arr=getimagesize($UAvator);
    		if($arr[0]/$arr[1]>1.789){$news[$i]['pic2']="1";}else{$news[$i]['pic2']="2";}    
    	
    		$news[$i]['time']=date("Y-m-d",strtotime($news[$i]['time']));
    	}    	
    	echo json_encode($news);
    	exit();
    }
}
