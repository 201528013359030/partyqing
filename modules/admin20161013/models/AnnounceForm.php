<?php
namespace app\modules\admin\models;
use Yii;
use yii\base\Model;
use app\models\Curl;
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
		//$content = iconv("GBK", "UTF-8", $content);		
		$data['attach'] = json_encode($attach);
		file_put_contents("/usr/local/www/nginx/html/partyqing/wt.txt", date("D M d H:i:s Y") . " =======676767=========" . json_encode($attach)."\n", FILE_APPEND);		    
		$qq=$data['attach'] ;
		//$data['attach']  = str_replace("\u","\\\u", $qq);
		$data['attach']  = str_replace("\\","\\\\", $qq);
        $data['content'] = str_replace(PHP_EOL, "</br>", $data['content']);
        $data['content'] = str_replace(' ', "&nbsp;", $data['content']);      
        //$data['content'] = '<p>'.$data['content'].'</p>';
        $connection = Yii::$app->db;
        $connection->open();  //初始化数据库
        header("Content-type:text/html;charset=gbk");  
        $now=date('Y-m-d H:i:s',time());
        $receiverId0=explode(',',$data['receiverId']);
        if($receiverId0[0]==""){
        $sq0="UPDATE djtask_list SET reporttime='".$now."',taskcontent='".($data['content'])."',taskfiles='".(($data['attach']))."',taskstate=2 WHERE taskId='".$data['taskId']."'";       	 
        }else{
        $sq0="UPDATE djtask_list SET approverId='".$receiverId0[0]."',reporttime='".$now."',taskcontent='".($data['content'])."',taskfiles='".(($data['attach']))."',taskstate=1 WHERE taskId='".$data['taskId']."'";
        }
        file_put_contents("/usr/local/www/nginx/html/partyqing/wt.txt", date("D M d H:i:s Y") . " =======676767=========" .$sq0."\n", FILE_APPEND);
        
        $command = $connection->createCommand($sq0);
        $command->execute();   
        $sq2="INSERT INTO  djtask_procedure(taskId,uid,comment,approvertime) VALUES('$data[taskId]','$receiverId0[0]','1','$now')";      
        $command = $connection->createCommand($sq2);
        $command->execute();
        /************发通知begin**************/
        require_once(dirname(__FILE__)."/config.php");
        $uid=\Yii::$app->session['user.uid'];
        $eid=explode('@',$uid);   
        $api_key = "36116967d1ab95321b89df8223929b14207b72b1";
        $authtoken=\Yii::$app->session['user.token'];
        //file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======fffff=========" . $eid."/n".$authtoken."/n".$noticeid."\n", FILE_APPEND);
        $data9=array();     
        $data9["uids[0]"]="$receiverId0[0]";    
        $data9["id"]="4";
        $data9["api_key"]=$api_key;
        $data9["eid"]="$eid[1]";
        $data9["title"]="审批通知";
        $data9["url"]="/partyqing/web/index.php?r=admin/taskcheck/index&s=1&uid=";
        $data9["auth_token"]="$token";
        $pc= $elggclient->post('/rest/json/?method=lapp.notice',$data9);
        //file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======fffff=========" . $eid."/n".$authtoken."/n".$noticeid."\n", FILE_APPEND);
            
       // $enterprisip = $_SERVER['HTTP_HOST'];
       // $curl = new Curl();
       // $ictIp = $enterprisip;
       // $url0 = "http://".$ictIp."/elgg/services/api/rest/json/?method=";
       // $url = $url0."lapp.notice";
        // file_put_contents("/usr/local/www/nginx/html/partyqing/wt.txt", date("D M d H:i:s Y") . " ========7878787========" . json_encode($pc). json_encode($data9) ."\n", FILE_APPEND);
       // $groupInfo = json_decode($curl->post($url, $data9),true);
        /************发通知end**************/
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
