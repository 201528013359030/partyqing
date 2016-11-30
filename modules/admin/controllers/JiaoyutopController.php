<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\modules\admin\models\AuthToken;
use app\modules\admin\models\IctWebService;
use Rest;
use Client;
class JiaoyutopController extends Controller
{
	public $layout  = false;
    public function actionIndex()
    {
        //$auth = new AuthToken();    
        //$auth->authTokenSession();
        $topic = \Yii::$app->request->get('topic');
    	$id=\Yii::$app->request->get('id');
    	$s=\Yii::$app->request->get('s');
    	//$uid=\yii::$app->request->get('uid');
        //\Yii::$app->session['user.uid']=$uid;
        $uid =\Yii::$app->session['user.uid'];
        $connection = Yii::$app->db;
        $connection->open();
        $eid=explode('@',$uid);
        //print_r($eid);exit;
        require_once(dirname(__FILE__)."/config.php");

        	    $data=array(); 
        		$condition="select uid from djjiaoyu_count where specialid='".$topic."' and uid>0 group by uid";
        		$result = $connection->createCommand($condition);
        		$uidlist= $result->queryAll();
        		//print_r($uidlist);
        		$countuid=count($uidlist);
        		if($countuid>100){$countuid=100;}
        		//echo $countuid;
        		for($j=0;$j<$countuid;$j++){
        			$uids=$uidlist[$j]['uid'];
        			$uid00=explode('@',$uids);
        			//if($uids==""){$countuid=$countuid-1;return;}
        			//if($uid00=="buliping"){$countuid=$countuid-1;return;}
        			/*******头像begin******/
        			$condition="select photo,name from memberlist where guid='".$uids."'";
        			$result = $connection->createCommand($condition);
        			$photo= $result->queryOne();
        			       			
        			$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
        			$data0=array();
        			$data0["api_key"]=$api_key;
        			$data0["auth_token"]="$token";
        			$data0["attr_list[0]"]="true";
        			$data0["eid"]=$eid[1];
        			$data0["id_list[0]"]=$uids;
        			$pc= $elggclient->post('/rest/json/?method=ldap.web.get.node.info',$data0);
        			//print_r($pc);exit;
        			if(isset($pc['result'][0]['data']['imgurl'][0])){
        				$data[$j]['photo']=$url.$pc['result'][0]['data']['imgurl'][0];
        			}else{
        				$data[$j]['photo']="../web/img/temp/nopic.png";
        			}
        			if($photo['name']){
        				$data[$j]['name']=$photo['name'];
        			}else{
        				$data[$j]['name']="未知";
        			}
        			/*******头像end******/
        			$condition="select sum((UNIX_TIMESTAMP(end) - UNIX_TIMESTAMP(start))/60) as difhour from djjiaoyu_count where end>0 and specialid='".$topic."' and uid='".$uids."'";
        			//小时$condition="select sum((UNIX_TIMESTAMP(end) - UNIX_TIMESTAMP(start))/(60*60)) as difhour from djjiaoyu_count where end>0 and dongtaiid='".$jiaoyuid."' and uid='".$uids."'";
        			 
        			$result = $connection->createCommand($condition);
        			$timeall= $result->queryOne();
        			$data[$j]['uid']=$uids;
        			if(isset($data[$j]['time'])){
        				$data[$j]['time']=$data[$j]['time']+$timeall['difhour'];        			
        			}else{
        				$data[$j]['time']=$timeall['difhour'];
        			}       	        					
        		}
        		//print_r($uidlist);
        
        	$countda=count($data);
        	for($i=0;$i<$countda;$i++){        		        				
        		$data[$i]['time']=round($data[$i]['time'],2);       	
        	}
        	/*******sort-begin********/
        	if($countda>0){
        	$sort = array(
        			'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
        			'field'     => 'time',       //排序字段
        	);
        	$arrSort = array();
        	foreach($data AS $uniqid => $row){
        		foreach($row AS $key=>$value){
        			$arrSort[$key][$uniqid] = $value;
        		}
        	}
        	if($sort['direction']){
        		array_multisort($arrSort[$sort['field']], constant($sort['direction']), $data);
        	}        
        	}	
        	//var_dump($data);
        	/*******sort-end********/
  //print_r($data[7]);

    	return $this->render('index',array('data'=>$data));
    }

}
