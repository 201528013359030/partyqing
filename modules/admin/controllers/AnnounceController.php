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
class AnnounceController extends \yii\web\Controller
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
        $auth = new AuthToken();
        $auth->authTokenSession();
        $model = new AnnounceForm();
        $groupId = Yii::$app->request->get('gid');
        if($groupId == null){
            return $this->redirect(['notice/index',
                                    "uid"=>Yii::$app->request->get('uid'),
                                    "id"=>Yii::$app->request->get('id'),
                                    "eguid"=>Yii::$app->request->get('eguid'),
                                    "nid"=>Yii::$app->request->get('nid'),
                                    "auth_token"=>Yii::$app->request->get('auth_token')
                                    ]);
        }
        if($groupId){
            $ictWS = new IctWebService();
            if(!$ictWS->groupCheck(Yii::$app->request->get('uid'),$groupId)){
                return $this->redirect(['notice/index',
                    "uid"=>Yii::$app->request->get('uid'),
                    "id"=>Yii::$app->request->get('id'),
                    "eguid"=>Yii::$app->request->get('eguid'),
                    "nid"=>Yii::$app->request->get('nid'),
                    "auth_token"=>Yii::$app->request->get('auth_token')
                    ]);
            }
            $group= $ictWS->getGroupInfo($groupId);
            $model->receiver=implode(",",$group['member']['name']);
            $model->receiverId=implode(",",$group['member']['uid']);
            $model->group = $groupId;
        }else{
            if(Yii::$app->request->get('main') != 1){
                return $this->redirect(['main/create',
                    "uid"=>Yii::$app->request->get('uid'),
                    "id"=>Yii::$app->request->get('id'),
                    "eguid"=>Yii::$app->request->get('eguid'),
                    "nid"=>Yii::$app->request->get('nid'),
                    "auth_token"=>Yii::$app->request->get('auth_token')
                    ]);
            }
            $model->receiver="选择接收人";
            $model->receiverId=0;
            $model->group = 0;
        }
        $sendSucceed = 0;
        if(Yii::$app->request->get('send') == "succeed"){
            $sendSucceed = 1;
            //echo "<script language='javascript'>";                                  
            //echo "alert('"."发送成功!"."');";            
            //echo 'document.getElementById("sendSucceed").click();';            
            //echo "</script>";                                                          
        }
      //  $offline_ip = $ictWS->getAdminToken(); 
        
       // print_r($offline_ip);
        return $this->render('index', [
                'model' => $model,'sendSucceed'=>$sendSucceed,"main"=>Yii::$app->request->get('main')
            ]);
    }
    public function actionSave()
    {   
        $ictWS = new IctWebService();
        $announceForm =new AnnounceForm();
        if(Yii::$app->request->post('AnnounceForm')['receiverId'] == 0){
            $announceForm->memberTree = $ictWS->getICTContacts();
        }
        file_put_contents("log.log", date("D M d H:i:s Y") . " " . json_encode(Yii::$app->request->post('AnnounceForm')) ."\n", FILE_APPEND);
        if(!$announceForm->save(Yii::$app->request->post('AnnounceForm'))){
            print_r('error');
            exit;
        }
        
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
        //___LICHUN___start        
        //$contacts= $ictWS->getICTContacts();
        $contacts= $ictWS->getICTContactsDiff();
        //___LICHUN___end
        
        $tree = $ictWS->createTreeData($contacts['result']['0']['data']);
        $tree['isExpand'] = true;
        $return['status'] = 1;
        $return['tree'] = ["data"=>[$tree],'ajaxType'=>"get"];
        echo json_encode($return);
        exit;        
    }   
    public function actionContacts0(){  //PHONE
    	$ictWS = new IctWebService();
    	
    	require_once(dirname(__FILE__)."/config.php");
    	
        $connection = Yii::$app->db2;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	$uid=\Yii::$app->session['user.uid'];
    	//$uid="7@3";
    	//echo $uid;exit;
    	$eid=explode('@',$uid);
    	$data=array();
    	$sq0="SELECT officeAddress FROM memberlist WHERE guid='".$uid."'";
    	$command = $connection->createCommand($sq0);
    	$info = $command->queryOne();
    
    		$sq0="SELECT oid FROM memberlist WHERE guid='".$uid."'";
    		$command = $connection->createCommand($sq0);
    		$info = $command->queryOne();
    		$oid=$info['oid'];
    		$sq0="SELECT level,parentID FROM organization WHERE oid='".$oid."'";
    		$command = $connection->createCommand($sq0);
    		$g = $command->queryOne();
    		if($g['level']==3){
    			$oid=$g['parentID'];
    		}
    		$sq0="SELECT uid FROM organization WHERE oid='".$oid."'";
    		$command = $connection->createCommand($sq0);
    		$g = $command->queryOne();
    		$data["id_list[0]"]=$g['uid'];    	
    	   	 
    	$api_key = "36116967d1ab95321b89df8223929b14207b72b1";
    	$data["api_key"]=$api_key;
    	$data["auth_token"]="$token";
    	$data["attr_list[0]"]="true";
    	$data["eid"]="$eid[1]";
    	$pc= $elggclient->post('/rest/json/?method=ldap.web.search',$data);    
    		$tree = $ictWS->createTreeData($pc['result'][0]['data']);   
    	$tree['isExpand'] = true;
    	$return['status'] = 1;
    	$return['tree'] = ["data"=>[$tree],'ajaxType'=>"get"];
    	echo json_encode($return);
    	exit;
    
    }


}
