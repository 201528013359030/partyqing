<?php
namespace app\modules\admin\models;
use Yii;
use yii\base\Model;
use app\models\Noticeinfo;
use app\models\Noticeuser;
use app\models\Noticereader;
use app\models\Enterpris;
use app\modules\admin\models\IctWebService;
/**
 * LoginForm is the model behind the login form.
 */
class AnnounceForm extends Model
{
	public $announceId;
	public $type;
	public $title;
	public $content;
	public $attach;
	public $sender;
	public $commentSwitch;
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
            $ws->getAllTypeMember('老师');     
		    $data['receiverId'] = implode(',',$ws->allTypeMemberUid); 
			$data['receiverName'] = implode(',',$ws->allTypeMemberName);
        }elseif($receiverType == 2){//全部学生
            $ws->getAllTypeMember('学生');     
		    $data['receiverId'] = implode(',',$ws->allTypeMemberUid); 
			$data['receiverName'] = implode(',',$ws->allTypeMemberName);
        }elseif($receiverType == 3){//全部师生
		    $data['receiverId'] = 0; 
        }
		$announce = new Noticeinfo();
		$attach = "";
		$data['type'] = 1;
		for($i=1;$i<4;$i++){
			if(isset($data["attach$i"])){
                if($data["attach$i"]){
				    $attach[] = json_decode($data["attach$i"],true);
                }
			}
		}
		$data['attach'] = json_encode($attach);

        if(!$data['UE']){
            $data['content'] = str_replace(PHP_EOL, "</br>", $data['content']);
            $data['content'] = str_replace(' ', "&nbsp;", $data['content']);
            if($data["contentImg"]){
                if(file_exists("/var/lib/mosquitto/tls")){
                    $tls = "https://";  
                }else{
                    $tls = "http://";
                }   
                $tls = "http://";
                $wip = $ws->getNodeInfo("root",['wip']);
                $photoip = "http://".$wip['result'][0]['data']['wip'][0];
                $offline_ip = $ws->getAdminToken();
                $path = json_decode($data["contentImg"],true);
                $tmpUrl = explode("media_file/",$path['path']);
                //$data['content'] = $data['content'].'<img src="'.$tls.$offline_ip['result']['wip']."/media_file/".$tmpUrl[1].'"/>';
                $data['content'] = $data['content'].'<img src="'.$photoip."/media_file/".$tmpUrl[1].'"/>';
            }
            $data['content'] = '<p>'.$data['content'].'</p>';
        }
        $userinfo = $ws->getNodeInfo(Yii::$app->session['user.sender']);
		$announce->type = $data['type'];
		$announce->title = $data['title'];
		$announce->comment_switch =(isset($data['top']))?1:0;// $data['commentSwitch'];
		$announce->content = ($data['content']);
		$announce->attach = (($data['attach']));
		$announce->sender = Yii::$app->session['user.sender'];
		$announce->sender_name = isset($userinfo['result'][0]['data']['membername'][0])?$userinfo['result'][0]['data']['membername'][0]:'管理员';
		$announce->enterpris_id = Yii::$app->session['user.enterprisId'];
		$announce->time = time();
        if(YII_TEST){
		    $announce->time = 1441441710;
        }
        if($data['topTime'] > 0){
            $announce->top_time = time()+($data['topTime'] * 24 * 60 * 60); 
            $announce->top_day = $data['topTime']; 
        }
		$announce->receiverType = $receiverType;
		$announce->confirm = isset($data['confirm'])?1:0;

        //print_r($announce);
	//	$announce->save();
		file_put_contents("log.log", date("D M d H:i:s Y") . " " . json_encode($announce->save()) ."\n", FILE_APPEND);

		//$enterpris = Enterpris::findOne(['enterpris_id'=>$announce->enterpris_id]);
        $enterprisip = $_SERVER['HTTP_HOST'];
		if($data['receiverId'] == "0"){
	//		$this->enterprisIP = $enterpris->ip;
			$this->enterprisIP = $enterprisip;
			$this->announceId =  $announce->announce_id;
			$this->addUnreadMember($this->memberTree['result']['0']['data']);
		}else{
			$user = explode(",",$data['receiverId']);
			$name = explode(",",$data['receiverName']);
            if($data['group']){
                $photo = $this->getMemberPhoto($user);
                $senderName = $ws->getNodeInfo($announce->sender);
                //$text = "群成员：".$senderName['result'][0]['data']['membername'][0]."，发了一个公告。点击查看"."/notice/web/index.php?r=admin/noticecontent/index&id=$announce->announce_id&uid=&eguid=&gid=&nid&auth_token=";
                $text = "群成员：".$senderName['result'][0]['data']['membername'][0]."，发了一个公告。请点击公告查看。";
         //       file_put_contents("log.log", "ict depData is : " .$text. "\n", FILE_APPEND );
                unset($ws);
                $ws = new IctWebService();
                $ws->lappSendGroupIm($data['group'],$text,1);
            }else{
			    $photo = explode(',',$data['photo']);
            }
            if(\Yii::$app->session['user.uid'] != 'buliping@'.\Yii::$app->session['user.eid']){
                if(!in_array(\Yii::$app->session['user.uid'],$user)){
                    $self= Noticeuser::findOne(['uid'=>\Yii::$app->session['user.uid']]);
                    $user[] = $self->uid;
                    $name[] = $self->name;
                }
                
            }
			foreach ($user as $key=>$value){
                if(!$value || in_array($value,$this->memberList)){
                    continue;
                }
                $this->memberList[] = $value;
				unset($member);
				$member = new Noticereader();
				$member->uid = $value;
				$member->name = $name[$key];
				$member->relation = 'unread';
		        $member->confirm = "no";
				$member->announce_id = $announce->announce_id;
				if(isset($photo[$key])){
					//$member->photo =  ($photo[$key]?'http://'.$enterpris->ip.$photo[$key]:'');
					$member->photo =  ($photo[$key]?$photo[$key]:'');
				}
				$member->time = time();
                if(YII_TEST){
                    $member->time = 1441441710;
                }
			//	$member->save();
				file_put_contents("log.log", date("D M d H:i:s Y") . " " . json_encode($member->save()) ."\n", FILE_APPEND);
			}
		}
        if(count($this->memberList)>0){
            $uids = $this->memberList;
        }else{
            $uids = false;
        }
        $ws->lappNotice(1,$uids,$data['title'],$announce->announce_id);
        //file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======fffff=========" .json_encode($uids), FILE_APPEND);         
        /************发短信begin**************/
        if(isset($data['texting'])){
        require_once(dirname(__FILE__)."/config.php");
        $da=$uids[0];
        $eid=explode('@',$da);
        $data0=array();
        for($i=0;$i<count($uids);$i++){        
           $data0["id_list[$i]"]=$uids[$i];
         }           
        $data0["api_key"]=$api_key;
        $data0["auth_token"]="$token";
        $data0["attr_list[0]"]="true";
        $data0["eid"]="$eid[1]";
        //$data["id_list[0]"]=$uid;
        $pc= $elggclient->post('/rest/json/?method=ldap.web.get.node.info',$data0);
       // file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======22222=========" .json_encode($pc)."\n", FILE_APPEND);        
        //$mobile=$pc['result'][0]['data']['mobile'][0];
       for($i=0;$i<count($uids);$i++){
        	 $mobile=$pc['result'][$i]['data']['mobile'][0];
        	 $data9=array();
        	 $data9["api_key"]=$api_key;
        	 $data9["phone_number"]="$mobile";
        	 $data9["message"]="短信内容";
        	 $data9["auth_token"]="$token";
        	 //$pc= $elggclient->post('/rest/json/?method=send.short.message',$data9);
       // file_put_contents("/usr/local/www/nginx/html/notice/wt.txt", date("D M d H:i:s Y") . " =======123444=========" .json_encode($data9)."\n", FILE_APPEND);        	 
         }        
          /************发短信end**************/    
        }
       	return 1;
	}
	public function attributeLabels()
    {
        return [
            'type' => '公告类型',
            'title' => '标题',
            'receiver' => '接收人',
            'content' => '内容'
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
