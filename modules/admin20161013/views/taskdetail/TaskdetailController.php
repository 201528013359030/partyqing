<?php
namespace app\modules\admin\controllers;
use Yii;
use app\modules\admin\models\AnnounceForm;
use app\models\Enterpris;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;
use app\models\Curl;
use Rest;
use Client;
class TaskdetailController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
//    public $layout  = 'main';
    public $layout  = false;
//    public $layout  = 'layout';

    public function actionCreate()
    {	 
        if(isset($_FILES["upload_file"])){                                        
            if($_FILES["upload_file"]["name"]){
                if(((int)$_FILES["upload_file"]["size"]/1024)>200*1024){
                    echo "<script language='javascript'>";                                     
                    echo 'upload_file_end(0,"上传失败","错误！文件不可大于200MB。");';
                    echo "</script>";                                                          
                    exit;
                }
                $path = "upload/".time();

                $return = move_uploaded_file($_FILES["upload_file"]["tmp_name"],$path);
                $fileclient =  new Curl();
                $file = $fileclient->post("http://127.0.0.1/offline_media/offline_upload.php?group=0", array("upload"=>"@".$_FILES["upload_file"]["tmp_name"].time()));
                $filePath = json_decode($file,true);
                $fileinfo[0]['name'] = $_FILES["upload_file"]["name"];
                $fileinfo[0]['path'] = $filePath["result"]["url"];
                $fileinfo[0]['size'] = $_FILES["upload_file"]["size"];
                echo "<script language='javascript'>";                                  
              //  echo " alert('"."文件上传成功!"."');";            
                echo 'parent.upload_file_end(1,"上传成功","",'.json_encode($fileinfo).');';
                echo "</script>";                                                          
            }
            exit;
        }  
    	$model = new AnnounceForm();
    	$model->receiver='公司全体员工';
        return $this->render('create', [
                'model' => $model,
            ]);
    }

    public function actionSaveB()
    {   
        $announceForm =new AnnounceForm();
        //print_r(Yii::$app->request->post('AnnounceForm'));
        if(!$announceForm->save(Yii::$app->request->post('AnnounceForm'))){
            print_r('error');
            exit;
        }
        return $this->render('create', [
                'model' => $announceForm,
            ]);
    }

    public function actionIndex()
    {  
    	
       // Yii::app()->user->setFlash('success','操作成功');
    	
        if(isset($_FILES["upload_file"])){                                        
            if($_FILES["upload_file"]["name"]){
                if(((int)$_FILES["upload_file"]["size"]/1024)>200*1024){
                    echo "<script language='javascript'>";                                     
                    echo 'upload_file_end(0,"上传失败","错误！文件不可大于200MB。");';
                    echo "</script>";                                                          
                    exit;
                }
                $path = "upload/".time();

         //       $return = move_uploaded_file($_FILES["upload_file"]["tmp_name"],$path);
                $fileclient =  new Curl();

                $file = $fileclient->post("http://127.0.0.1/offline_media/offline_upload.php?group=0", array("upload"=>"@".$_FILES["upload_file"]["tmp_name"]));
                $filePath = json_decode($file,true);
                $fileinfo['name'] = $_FILES["upload_file"]["name"];
                $fileinfo['path'] = $filePath["result"]["url"];
                $fileinfo['size'] = $_FILES["upload_file"]["size"];
                $taskID = Yii::$app->request->post('taskID');
                echo "<script language='javascript'>";                                  
          //      echo " alert('"."$fileclient"."');";            
                echo 'parent.upload_file_end(1,"上传成功","",'.json_encode($fileinfo).",$taskID".');';
                echo "</script>";                                                          
            }
            exit;
        }        
        $model = new AnnounceForm();                     
        $sendSucceed = 0;
        if(Yii::$app->request->get('send') == "succeed"){
        	$sendSucceed = 1;
        }      
        $id=\yii::$app->request->get('id');
        $uid ="22@22";
        //$uid=\Yii::$app->session['user.uid'];
        $connection = Yii::$app->db;
        $connection->open();  //初始化数据库
        header("Content-type:text/html;charset=utf-8");      
        $sq0="SELECT * FROM djtask_list l,djtask_content c,djtask_procedure p WHERE l.taskId='".$id."' AND l.reporterId='".$uid."' AND l.taskNo=c.taskNo AND P.taskId=l.taskId AND l.year=c.year";
        $command = $connection->createCommand($sq0);
        $info = $command->queryAll();
        return $this->render('index', [
                'info'=>$info[0], 'taskId' => $id,'model' => $model,'sendSucceed'=>$sendSucceed,
            ]);
    }
    public function actionSave()
    {   
        $ictWS = new IctWebService();
        $announceForm =new AnnounceForm();
        if(Yii::$app->request->post('AnnounceForm')['receiverId'] == 0){
            $announceForm->memberTree = $ictWS->getICTContacts();
        }
        file_put_contents("wt.txt", date("D M d H:i:s Y") . "WT0 " . json_encode(Yii::$app->request->post('AnnounceForm')) ."\n", FILE_APPEND);
        
        //$q=$announceForm->saveQ(Yii::$app->request->post('AnnounceForm'));
        if(!$announceForm->save(Yii::$app->request->post('AnnounceForm'))){
            print_r('error');
            exit;
        }
     // file_put_contents("wt.txt", date("D M d H:i:s Y") . "WT1 " . json_encode(Yii::$app->request->get('main')) ."\n", FILE_APPEND);
         
        return $this->render('finish',['gid'=>Yii::$app->request->post('AnnounceForm')['group'],'main'=>Yii::$app->request->get('main')]);
        return $this->redirect(['announce/index',"send"=>"succeed","gid"=>Yii::$app->request->post('AnnounceForm')['group']]);
        $model = new AnnounceForm();
        $model->receiver='公司全体员工';
        return $this->render('index', [
                'model' => $model,
            ]);
    }
    public function actionContacts(){
        $ictWS = new IctWebService();
        $contacts= $ictWS->getICTContacts();
        $tree = $ictWS->createTreeData($contacts['result']['0']['data']);
        $tree['isExpand'] = true;
        $return['status'] = 1;
        $return['tree'] = ["data"=>[$tree],'ajaxType'=>"get"];
        echo json_encode($return);
        exit;
        
    }
    public function actionContacts3(){
    	require_once(dirname(__FILE__)."/config.php");
    	$uid=Yii::$app->session['user.uid'];
    	//$uid="27430@66640";
    	$connection = Yii::$app->db2;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	$eid0=explode('@',$uid);
    	$eid=$eid0[1];
    	$sq0="SELECT classid FROM lcmemdata WHERE muid='".$uid."'";
    	$command = $connection->createCommand($sq0);
    	$class = $command->queryAll();
    	$classid=$class[0]['classid'];
    	$sq1="SELECT name FROM lcorganidata WHERE oid='".$classid."'"; 
    	$command = $connection->createCommand($sq1);
    	$classname0 = $command->queryAll();
    	$classname=$classname0[0]['name'];
    	$sq5="SELECT id FROM lcchildren WHERE classid='".$classid."' AND eid=".$eid;
    	$command = $connection->createCommand($sq5);
    	$childids = $command->queryAll();
    	$count2=count($childids);
    	$k=0;
    	for($i=0;$i<$count2;$i++){
    		$childid=$childids[$i]['id'];
    		$sq2="SELECT muid FROM lcmemdata WHERE childid='".$childid."' AND eid=".$eid;
    		$command = $connection->createCommand($sq2);
    			$uids0 = $command->queryAll();
			for($j=0;$j<count($uids0);$j++){
				$uids[$k]=$uids0[$j]['muid'];
				$k++;
			}
    	}    	 
    	$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
    	$token=\Yii::$app->session['user.token'];
    	$data=array();
    	for($i=0;$i<count($uids);$i++){
    		$data["query_ids[$i]"]  = $uids[$i];
    	}
    	$data["api_key"]=$api_key;
    	$data["auth_token"]="$token";
    	$data["user_id"]="$uid";
    	//$data["query_id"]="$uid";
    	$pc= $elggclient->post('/rest/json/?method=ldap.client.get.user.info',$data);
    	 
    	$tree['text'] = $classname;
    	$tree['isExpand'] = true;
    	$count=count($uids);
    	for($i=0;$i<$count;$i++){
    		$tree['children'][$i]['text'] = $pc['result'][$i]['data']['membername'][0];
    		$tree['children'][$i]['id'] = $uids[$i];
    		$tree['children'][$i]['isExpand'] = false;
    		if(isset($pc['result'][$i]['data']['imgurl'][0])){}else{$pc['result'][$i]['data']['imgurl'][0]="";}
    		$tree['children'][$i]['photo'] = $pc['result'][$i]['data']['imgurl'][0];
    		$tree['children'][$i]['icon'] = "images/icons/memeber.gif";
    		$tree['children'][$i]['mobile'] = $pc['result'][$i]['data']['mobile'][0];
    	}
    
    	$return['status'] = 1;
    	$return['tree'] = ["data"=>[$tree],'ajaxType'=>"get"];
    
    	echo json_encode($return);
    	exit;
    }
    public function actionContactss(){
    	require_once(dirname(__FILE__)."/config.php");
    	$uid=Yii::$app->session['user.uid'];
    	//$uid="27430@66640";
    	$connection = Yii::$app->db2;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	$eid0=explode('@',$uid);
    	$eid=$eid0[1];
    	
    	$sq0="SELECT ename FROM enterprise where uid='".$eid."'";
    	$command = $connection->createCommand($sq0);
    	$school = $command->queryAll();    	
    	$schoolname=$school[0]['ename'];  
    	$sq5='SELECT muid FROM lcmemdata WHERE mtype=4 AND eid='.$eid;
    	$command = $connection->createCommand($sq5);
    	$uids = $command->queryAll();
    	$api_key = "36116967d1ab95321b89df8223929b14207b72b1";   
    	$token=\Yii::$app->session['user.token'];
    	$data=array();
    	for($i=0;$i<count($uids);$i++){
    		$data["query_ids[$i]"]  = $uids[$i]['muid'];
    	}
    	$data["api_key"]=$api_key;
    	$data["auth_token"]="$token";
    	$data["user_id"]="$uid";
    	//$data["query_id"]="$uid";
    	$pc= $elggclient->post('/rest/json/?method=ldap.client.get.user.info',$data);
    	
    	$tree['text'] = $schoolname;
		$tree['isExpand'] = true;
		$count=count($uids);
		for($i=0;$i<$count;$i++){
				$tree['children'][$i]['text'] = $pc['result'][$i]['data']['membername'][0];
		        $tree['children'][$i]['id'] = $uids[$i]['muid'];
		        $tree['children'][$i]['isExpand'] = false;
		        if(isset($pc['result'][$i]['data']['imgurl'][0])){}else{$pc['result'][$i]['data']['imgurl'][0]="";}
		        $tree['children'][$i]['photo'] = $pc['result'][$i]['data']['imgurl'][0];
		        $tree['children'][$i]['icon'] = "images/icons/memeber.gif";
		        $tree['children'][$i]['mobile'] = $pc['result'][$i]['data']['mobile'][0];			 
		}
	
		$return['status'] = 1;
		$return['tree'] = ["data"=>[$tree],'ajaxType'=>"get"];
	
    	echo json_encode($return);
    	//echo json_encode($eid);
    	exit;    
    }
}
