<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\modules\admin\models\AuthToken;
use app\modules\admin\models\IctWebService;
use Rest;
use Client;
class JiaoyulistController extends Controller
{
	public $layout  = false;
    public function actionIndex()
    {
        //$auth = new AuthToken();    
        //$auth->authTokenSession();
        $zhuantiid = \Yii::$app->request->get('zhuantiid');
    	$id=\Yii::$app->request->get('id');
    	$s=\Yii::$app->request->get('s');
    	//$uid=\yii::$app->request->get('uid');
        //\Yii::$app->session['user.uid']=$uid;
        $uid =\Yii::$app->session['user.uid'];
        $connection = Yii::$app->db;
        $connection->open();
        if($s==2){//我的课程
        	$condition="select * from djjiaoyu,djjiaoyu_reader where djjiaoyu.top=1 and djjiaoyu.content_flag = '0' and djjiaoyu.specialid = '".$zhuantiid."'  and djjiaoyu.id = djjiaoyu_reader.studyinfo_id and djjiaoyu_reader.uid = '".$uid."' order by time desc limit 3";
        	$result = $connection->createCommand($condition);
        	$listtop= $result->queryAll();
        	$counttop=count($listtop);
        	if(empty($listtop)){
        		$listtop[0]['pic']="../web/img/banner1.png";
        		$listtop[0]['id']="";
        	}      
        }else{
        	$condition="select * from djjiaoyu where top=1 and content_flag = '1' and specialid = '".$zhuantiid."' order by time desc limit 3";
        	$result = $connection->createCommand($condition);
        	$listtop= $result->queryAll();
        	$counttop=count($listtop);
        	if(empty($listtop)){
        		$listtop[0]['pic']="../web/img/banner1.png";
        		$listtop[0]['id']="";
        	}     
        	$s=1;
        }
    	if($s==2){//我的课程
    	$condition="select * from djjiaoyu_reader,djjiaoyu where  djjiaoyu.content_flag = '1' and djjiaoyu.specialid = '".$zhuantiid."'  and djjiaoyu.id = djjiaoyu_reader.studyinfo_id  and djjiaoyu_reader.uid = '".$uid."' order by djjiaoyu.time desc limit 5";
    	$result = $connection->createCommand($condition);
    	$list= $result->queryAll();
    	$count=count($list);
    	//echo $count;
    	for($i=0;$i<$count;$i++){
    	    $UAvator=$list[$i]['pic'];
    	    if($UAvator){}else{
    	        $list[$i]['pic']="../web/img/pic2.png";
    	    }
    	    $a=$list[$i]['content'];
    	    if(strstr($a,"divvideocontent")){
    	        $list[$i]['video']="1";
    	    }else{
    	        $list[$i]['video']="0";
    	    }
    	    $list[$i]['time']=date("Y-m-d",strtotime($list[$i]['time']));
    	}
    	}else{
    		$condition="select * from djjiaoyu where  content_flag = '0' and specialid = '".$zhuantiid."' order by time desc limit 5";
    		$result = $connection->createCommand($condition);
    		$list= $result->queryAll();
    		$count=count($list);
    		for($i=0;$i<$count;$i++){
    			$UAvator=$list[$i]['pic'];
    			if($UAvator){}else{
    				$list[$i]['pic']="../web/img/pic2.png";
    			}
    			$a=$list[$i]['content'];
    			if(strstr($a,"divvideocontent")){
    				$list[$i]['video']="1";
    			}else{
    				$list[$i]['video']="0";
    			}
    			$list[$i]['time']=date("Y-m-d",strtotime($list[$i]['time']));
    		}
    	}
    	//print_r($list);
    	\Yii::$app->session['public_count']=$count;
    	return $this->render('index',array('zhuantiid'=>$zhuantiid,'s'=>$s,'list'=>$list,'listtop'=>$listtop,'count'=>$count,'counttop'=>$counttop));
    }
    public function actionSearch(){
    
       	$searchtitle=\yii::$app->request->get('searchtitle');  
       	$zhuantiid=\yii::$app->request->get('zhuantiid');
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
       	 
    	$s=\Yii::$app->request->get('s');    	
    	$uid =\Yii::$app->session['user.uid'];

    	if($s==2){//我的课程
    	$sq0="select * from djjiaoyu_reader,djjiaoyu where djjiaoyu.top=0 and djjiaoyu.content_flag = '1' and djjiaoyu.specialid = '".$zhuantiid."'  and djjiaoyu.id = djjiaoyu_reader.studyinfo_id  and djjiaoyu_reader.uid = '".$uid."' and (title like '%".$searchtitle."%' or keywords like '%".$searchtitle."%') order by djjiaoyu.time desc limit 5";
    	}else{
    	$sq0="select * from djjiaoyu where top=0 and content_flag = '0' and specialid = '".$zhuantiid."' and (title like '%".$searchtitle."%' or keywords like '%".$searchtitle."%') order by time desc limit 5";
    	}
        $command = $connection->createCommand($sq0);
    	$state = $command->queryAll();
    	$count=count($state);
    	
    	for($i=0;$i<$count;$i++){
    		$UAvator=$state[$i]['pic'];
    		if($UAvator){}else{
    			$state[$i]['pic']="../web/img/pic2.png";
    		}
    		$a=$state[$i]['content'];
    		if(strstr($a,"divvideocontent")){
    			$state[$i]['video']="1";
    		}else{
    			$state[$i]['video']="0";
    		}
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
    	$zhuantiid=\yii::$app->request->get('zhuantiid');
    	$s=\Yii::$app->request->get('s');
    	$uid =\Yii::$app->session['user.uid'];
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库

    	$public_count=\Yii::$app->session['public_count'];    	 
    	if(strlen($searchcontent)>0){
    		$search_count=\Yii::$app->session['search_count'];
    		if($s==2){//我的课程
    			$sq0="select * from djjiaoyu,djjiaoyu_reader where djjiaoyu.top=0 and djjiaoyu.content_flag = '1' and djjiaoyu.specialid = '".$zhuantiid."'  and djjiaoyu.id = djjiaoyu_reader.studyinfo_id  and djjiaoyu_reader.uid = '".$uid."' and (title like '%".$searchtitle."%' or keywords like '%".$searchtitle."%') order by djjiaoyu.time desc  LIMIT ".$search_count.",15";   
    		}else{
    			$sq0="select * from djjiaoyu where top=0 and content_flag = '0' and specialid = '".$zhuantiid."' and (title like '%".$searchtitle."%' or keywords like '%".$searchtitle."%') order by time desc  LIMIT ".$search_count.",15";   
    		}
    		$search_count=$search_count+15;
    		\Yii::$app->session['search_count']=$search_count;
    		 
    	}else{
    		
    		$public_count=\Yii::$app->session['public_count'];
    		if($s==2){//我的课程
    			$sq0="select * from djjiaoyu,djjiaoyu_reader where djjiaoyu.top=0 and djjiaoyu.content_flag = '1' and djjiaoyu.specialid = '".$zhuantiid."'  and djjiaoyu.id = djjiaoyu_reader.studyinfo_id  and djjiaoyu_reader.uid = '".$uid."' order by djjiaoyu.time desc LIMIT ".$public_count.",15";  
    		}else{
    			$sq0="select * from djjiaoyu where top=0 and content_flag = '0' and specialid = '".$zhuantiid."'  order by time desc LIMIT ".$public_count.",15";  
    		}
    		$public_count=$public_count+15;
    		\Yii::$app->session['public_count']=$public_count;
    	}   
    	//file_put_contents("D:\\wt1.txt","sum:".$sq0."\n", FILE_APPEND);
    	$command = $connection->createCommand($sq0);
    	$news = $command->queryAll();
    	//file_put_contents("D:\\wt1.txt","sum:".json_encode($news)."\n", FILE_APPEND);
    	\Yii::$app->session['searchcontent']=$searchcontent;
    	$count=count($news);
    	for($i=0;$i<$count;$i++){
    		$UAvator=$news[$i]['pic'];
    		if($UAvator){}else{
    			$news[$i]['pic']="../web/img/pic2.png";
    		}
    		$a=$news[$i]['content'];
    		if(strstr($a,"divvideocontent")){
    			$news[$i]['video']="1";
    		}else{
    			$news[$i]['video']="0";
    		}
    		$news[$i]['time']=date("Y-m-d",strtotime($news[$i]['time']));
    	}
    	echo json_encode($news);
    	exit();
    }
}
