<?php
namespace app\modules\admin\models;
use Yii;
use yii\base\Model;
use app\models\Tasklist;
use app\modules\admin\models\IctWebService;
/**
 * LoginForm is the model behind the login form.
 */
class AnnounceForm extends Model
{
	public $content;
	public $attach;
	public $enterprisId;
	public $time;
	public $receiver;
	public $receiverId;
	public $fileId;
	public $fileName;
	public $photo;
	public $memberTree;
	public $enterprisIP;
	public $group;
    public $memberList=[];
    public $memberUids=[];
	function __construct(){
	}
	public function save($data){
        $ws = new IctWebService();
        $receiverType = Yii::$app->request->post('receiverType');
        if(YII_ICT){
            $receiverType = 4;
        }
        if($receiverType == 1){//全部老师           
        }elseif($receiverType == 3){//全部师生
		    $data['receiverId'] = 0; 
        }
		$announce = new Tasklist();
		$attach = "";
		for($i=1;$i<11;$i++){
			if(isset($data["attach$i"])){
                if($data["attach$i"]){
				    $attach[] = json_decode($data["attach$i"],true);
                }
			}
		}
		$data['attach'] = json_encode($attach);
        $data['content'] = str_replace(PHP_EOL, "</br>", $data['content']);
        $data['content'] = str_replace(' ', "&nbsp;", $data['content']);      
        $data['content'] = '<p>'.$data['content'].'</p>';
        $connection = Yii::$app->db;
        $connection->open();  //初始化数据库
        header("Content-type:text/html;charset=utf-8");  
        $now=date('Y-m-d H:i:s',time());
        $sq0="UPDATE djtask_list SET approverId='".$data['receiverId']."',reporttime='".$now."',taskcontent='".($data['content'])."',taskfiles='".(($data['attach']))."',taskstate=1 WHERE taskId='".$data['taskId']."'";
        $command = $connection->createCommand($sq0);
        $command->execute();   
        $sq0="INSERT INTO  djtask_procedure(taskId,uid,comment,approvertime) VALUES('$data[taskId]','$data[receiverId]','1',$now')";
        
        $command = $connection->createCommand($sq0);
        $command->execute();
        /************发通知begin**************/
 /*       $uid=\Yii::$app->session['user.uid'];
        $eid=explode('@',$uid);
        $sq2="SELECT id FROM lappinfo WHERE eid='".$eid."' AND name='任务清单'";
        $command = $connection2->createCommand($sq2);
        $notice = $command->queryAll();
        $noticeid=$notice[0]['id'];
        $api_key = "36116967d1ab95321b89df8223929b14207b72b1";
        $authtoken=\Yii::$app->session['user.token'];
        //file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======fffff=========" . $eid."/n".$authtoken."/n".$noticeid."\n", FILE_APPEND);
        $data9=array();     
        $data9["uids[0]"]=$data['receiverId'];    
        $data9["id"]=$noticeid;
        $data9["api_key"]=$api_key;
        $data9["eid"]="$eid";
        $data9["title"]="通知审批";
        $data9["url"]="/partyqing/web/index.php?r=admin/talkdetail/index&id=".$announce->announce_id;
        $data9["auth_token"]="$authtoken";
        //$pc= $elggclient->post('/rest/json/?method=lapp.notice',$data9)
        $enterprisip = $_SERVER['HTTP_HOST'];
        $curl = new Curl();
        $ictIp = $enterprisip;
        $url0 = "http://".$ictIp."/elgg/services/api/rest/json/?method=";
        $url = $url0."lapp.notice";
        //file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " ========tttt========" . json_encode($data9) ."\n", FILE_APPEND);
        $groupInfo = json_decode($curl->post($url, $data9),true);
   */     /************发通知end**************/
		//$enterpris = Enterpris::findOne(['enterpris_id'=>$announce->enterpris_id]);
       

		return 1;
	}
	public function attributeLabels()
    {
        return [
            'type' => '公告类型',           
        ];
    }

    public function addUnreadMember($oData){ 
        if(count($oData['member'])>0){
            foreach($oData['member'] as $m){
                if(!isset($m['uid'][0])){
                    continue;
                }
	            unset($member);
                if(in_array($m['uid'][0],$this->memberUids)){
                    continue;
                }
                $this->memberUids[] = $m['uid'][0];
				$member = new Noticereader();
				$member->uid = $m['uid'][0];
				$member->name = $m['membername'][0];
				$member->relation = 'unread';
		        $member->confirm = "no";
				$member->announce_id = $this->announceId;
				$member->photo =(isset($m['imgurl'][0])?$m['imgurl'][0]:'');
				$member->time = time();
                if(YII_TEST){
                    $member->time = 1441441710;
                }
			//	$member->save();
				file_put_contents("log.log", date("D M d H:i:s Y") . " " . json_encode($member->save()) ."\n", FILE_APPEND);
            }     
        }    
        if(count($oData['child'])>0){
            foreach($oData['child'] as $c){ 
            	$this->addUnreadMember($c);   
            }    
        }    
    }
    public function getMemberPhoto($uids){
        $ws = new IctWebService();
        $userinfo = $ws->getNodeInfo($uids); 
        foreach($userinfo['result'] as $u){
            $return[] =(isset($u['data']['imgurl'][0])?$u['data']['imgurl'][0]:null);
        }
        return $return;
    }

}
