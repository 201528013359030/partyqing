<?php
namespace app\modules\admin\controllers;
use yii;
use yii\web\Controller;
use Rest;
use Client;
use app\modules\admin\models\AnnounceForm;
use app\modules\admin\models\AuthToken;
use app\modules\admin\models\IctWebService;
class TaskdetailController0 extends Controller
{
	public $layout  = false;
    public function actionIndex()
    {
    	if(isset($_FILES["upload_file"])){
    		file_put_contents("D://wt1.txt","sql:"."ok1"."\n", FILE_APPEND);
    		if($_FILES["upload_file"]["name"]){
    			if(((int)$_FILES["upload_file"]["size"]/1024)<200*1024){
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
    	$id=\yii::$app->request->get('id');
    	$uid ="22@22";
    	//$uid=\Yii::$app->session['user.uid'];
    	$connection = Yii::$app->db;
    	$connection->open();  //初始化数据库
    	header("Content-type:text/html;charset=utf-8");
    	/**************end********************/

    	$sq0="SELECT * FROM djtask_list l,djtask_content c,djtask_procedure p WHERE l.taskId='".$id."' AND l.reporterId='".$uid."' AND l.taskNo=c.taskNo AND P.taskId=l.taskId AND l.year=c.year";    	 
    	$command = $connection->createCommand($sq0);
    	$info = $command->queryAll();
    	$model = new AnnounceForm();
    	$model->group = 0;
    	$sendSucceed = 0;
    	//print_r($info);
    	//file_put_contents("D://wt1.txt","sql:"."ok66"."\n", FILE_APPEND);
        return $this->render('index',[
        		'info'=>$info[0], 
        		'model' => $model,
        		'sendSucceed'=>$sendSucceed,
        
        ]);
    }
    public function actionSave()
    {
    	file_put_contents("D://wt1.txt","sql:"."ok"."\n", FILE_APPEND);
    	
    /*	if(isset($_FILES["upload_file"])){
    		file_put_contents("D://wt1.txt","sql:"."ok1"."\n", FILE_APPEND);
    		if($_FILES["upload_file"]["name"]){
    			if(((int)$_FILES["upload_file"]["size"]/1024)<200*1024){
    				echo "<script language='javascript'>";
    				echo 'upload_file_end(0,"上传失败","错误！文件不可大于200MB。");';
    				echo "</script>";
    				exit;
    			}
    		/*	$path = "upload/".time();
    		
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
    			*/
    	/*	}
    		exit;
    		
    	}*/
    	
    }
}
