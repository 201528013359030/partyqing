<?php
namespace app\modules\admin\models;
use Yii;
use yii\base\Model;
use app\models\Enterpris;
use app\models\Curl;
/**
 * 
 */
class IctWebService extends Model
{
	public $ictIp;
	public $eid;
    public $url;
    public $params = [];
    public $attr = [];
    public $noticeUrl = "/notice/web/index.php?r=admin/noticecontent/index&uid=&eguid=&auth_token=&id=";
    public $allTypeMemberUid;
    public $allTypeMemberName;

	function __construct(){
        $enterprisId = Yii::$app->session['user.enterprisId'];
       
        $einfo = Enterpris::find()->where(['enterpris_id'=>$enterprisId])->one();
        //echo 22;exit;
        //print_r($einfo);
       
        //$this->ictIp = $einfo['ip'];
        //$this->eid = $einfo['eid'];
        $this->ictIp = 'localhost';
//        $this->ictIp = '192.168.139.54';
        $eid = explode('@',Yii::$app->session['user.uid']); 
        if(isset($eid[1])){
            $this->eid = $eid[1];
        }
        $this->url = "http://$this->ictIp/elgg/services/api/rest/json/?method=";
        $this->params['auth_token'] = Yii::$app->session['user.token'];
        $this->params['api_key'] = Yii::$app->session['user.apiKey'];
        //
    }
    public function getAdminToken(){
        $curl = new Curl();
        $url = $this->url . "auth.gettoken";
        $params['name']="buliping";
        $params['password']="123456";
        $params['api_key']="36116967d1ab95321b89df8223929b14207b72b1";
        $elggAdmin = json_decode($curl->post($url, $params), true);
        $this->params = null;
        $this->params['auth_token'] = $elggAdmin['result']['auth_token'];
        $this->params['api_key'] = $params['api_key'];
        return $elggAdmin;
    }
    public function loginElgg($name,$pwd){
        $curl = new Curl();
        $url = $this->url . "auth.gettoken";
        $params['name']=$name;
        $params['password']=$pwd;
        $params['api_key']="36116967d1ab95321b89df8223929b14207b72b1";
        $elggAdmin = json_decode($curl->post($url, $params), true);
        if(isset($elggAdmin['status'])){
            $this->params['auth_token'] = $elggAdmin['result']['auth_token'];
            $this->params['uid'] = $elggAdmin['result']['uid'];
            $this->params['api_key'] = $params['api_key'];
            return 1;
        }else{
            return 0;
        }
    }
	public function createTreeData($oData){
        $temp = $oData;
        unset($temp['member']);
        unset($temp['child']);
        $tData = array();
        if(!isset( $temp['nodename'][0])){
            return;
        }
        $tData['text'] = $temp['nodename'][0];
        $tData['isExpand'] = false;
        $tData['children'] = array();  
        $tData['icon'] = "images/icons/address.png";  
        if(count($oData['member'])>0){
            foreach($oData['member'] as $m){
                if(isset($m['membername'][0])){
                    $tData['children'][] = ["text"=>$m['membername'][0],
                                            "id"=>$m['uid'][0],
                                            "isExpand"=>false,
                                            "photo"=>(isset($m['imgurl'][0])?$m['imgurl'][0]:0),
                                            "icon"=>"images/icons/memeber.gif",
                                            "mobile"=>(isset($m['mobile'][0])?$m['mobile'][0]:null),
                                                ];    
                }
            }     
        }    
        if(count($oData['child'])>0){
            foreach($oData['child'] as $c){ 
                $tData['children'][] = $this->createTreeData($c);   
            }    
        }    
        return $tData;
    }

    public function getICTContacts(){
        \Yii::$app->redis->select(11);
        $contacts['result'] = json_decode(\Yii::$app->redis->get("EDATA:".$this->eid),true);
     //   echo json_encode($contacts);
      //  exit;
        if($contacts['result']){
            $contacts['status'] = 0;
            return $contacts;
        }

        $this->getAdminToken();
        $curl = new Curl();
        $url = "http://$this->ictIp/elgg/services/api/rest/json/?method=ldap.web.search";
        $params['eid'] = $this->eid;
        $params['id_list[0]'] =  "null";
        $params['attr_list[0]'] = "true";
        $params['auth_token'] = $this->params['auth_token'];
        $params['api_key'] = $this->params['api_key'];
        $contacts = json_decode($curl->post($url, $params),true);
        return $contacts;

    }
    public function getGroupInfo($group){

        $curl = new Curl();
        $url = "http://$this->ictIp/elgg/services/api/rest/json/?method=group.get.group";
	    $params["guid"]=$group;
	    $params["api_key"]= Yii::$app->session['user.apiKey'];
	    $params["auth_token"]= Yii::$app->session['user.token'];
        $groupInfo = json_decode($curl->post($url, $params),true);
	    $memberCount = $groupInfo["result"]["members_count"];
	    $groupName = $groupInfo["result"]["name"];
	    if(count($groupInfo["result"]["members"])>0){
	        foreach($groupInfo["result"]["members"] as $m){
	        	$uid[] = $m['uid'];
	        	$name[] = $m['member_name'];
	        }
	    }
	    $return['member']['uid']=$uid;
	    $return['member']['name']=$name;
	    $return['name']=$groupName;
	    return $return;
    }
    public function lappNotice($id,$uids,$title,$noticeId){
        $curl = new Curl();
        $url = $this->url."lapp.notice";
        $this->params['id'] = 1;
        $this->params['eid'] = $this->eid;
        $this->params['title'] = $title;
        $this->params['url'] = $this->noticeUrl.$noticeId;
        if($uids){
            $uids = array_filter($uids);
            for($i=0;$i<count($uids);$i++){
                $this->params["uids[$i]"] = $uids[$i];
            }
        }
        $groupInfo = json_decode($curl->post($url, $this->params),true);
        return 1;
    }
    public function lappSendGroupIm($guid,$text,$lappId){
        $curl = new Curl();
        $url = $this->url."lapp.send.group.im";
        $this->params['guid'] = $guid;
        $this->params['text'] = $text;
        $this->params['lapp_id'] = $lappId;
        $groupInfo = json_decode($curl->post($url, $this->params),true);
        return 1;
    }
    public function authToken($uid,$token){
        $curl = new Curl();
        $url = $this->url."check.user.token";
        $uidexp = explode('@',$uid);
        if($uidexp[0] == 'buliping'){
            $uid = $uidexp[0];
        }
        $this->params['uid'] = $uid;
        $this->params['auth_token'] = $token;
        $auth = json_decode($curl->post($url, $this->params),true);
        if(isset($auth['result']['success'])){
            return 1;
        }else{
            //print_r($this->params);
            //print_r(json_encode($auth));
            //exit;
            return 0;
        }
    }
    public function getNodeInfo($uid,$info=false){
        if(!is_array($uid)){
            $this->params['id_list[0]'] = $uid;
        }else{
            for($i=0;$i<count($uid);$i++){
                $this->params["id_list[$i]"] = $uid[$i];
            } 
        }
        if($info){
            for($i=0;$i<count($info);$i++){
                $this->params["attr_list[$i]"] = $info[$i];
            } 
        }else{
            $this->params['attr_list[0]'] = "true";
        }
        $curl = new Curl();
        $url = $this->url."ldap.web.get.node.info";
        if(isset($this->eid)){
            $this->params['eid'] = $this->eid;
        }
        $info = json_decode($curl->post($url, $this->params),true);
        return $info;
    }
    public function getMemberPhoto($uids){
        $return = [];
        $wip = $this->getNodeInfo("root",['wip']);
        $photoip = "http://".$wip['result'][0]['data']['wip'][0];
        $this->getAdminToken();
        $userinfo = $this->getNodeInfo($uids); 
        foreach($userinfo['result'] as $u){
            if(($u['id'])){
                $key = $u['id'];
                $return["$key"] =(isset($u['data']['imgurl'][0])?$photoip.$u['data']['imgurl'][0]:null);
            }   
        }   
        return $return;
    } 
    public function get_mac(){
        @exec("ifconfig -a", $array); 
        $temp_array = array(); 
        $mac_addr = "";
        foreach ( $array as $value ){ 
            if ( 
                preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i",$value, $temp_array ) ){ 
                    $mac_addr = $temp_array[0]; 
                    break; 
                }    
        }    
        unset($temp_array); 
        return $mac_addr; 
    }
    public function groupCheck($uid,$groupId){
        $curl = new Curl();
        $url = $this->url."group.check.owner";
        $this->params['guid'] = $groupId;
        $this->params['uid'] = $uid;
        //print_r($this->params);
        $admin = json_decode($curl->post($url, $this->params),true);
       // print_r($admin);
       // exit;
        if($admin['result']['success'] == 1){
            return 1;
        }else{
            return 0;
        }
    }
    public function getAllTypeMember($type){
        $allMember = $this->getICTContacts(); 
        $this->memberSearch($allMember['result']['0']['data'],$type);
    }
	public function memberSearch($oData,$type=null){
        $temp = $oData;
        unset($temp['member']);
        unset($temp['child']);
        $tData = array();
        $tData['children'] = array();  
        if(count($oData['member'])>0){
            foreach($oData['member'] as $m){
                if(isset($m['employeetype'][0])){
                    if($m['employeetype'][0] == $type){
                        $this->allTypeMemberUid[] = $m['uid'][0];
                        $this->allTypeMemberName[] = $m['membername'][0];
             //           print_r($m['uid'][0]);
              //          print_r($m['membername'][0]);
                    }
                }
            }     
        }    
        if(count($oData['child'])>0){
            foreach($oData['child'] as $c){ 
                $tData['children'][] = $this->memberSearch($c,$type);   
            }    
        }    
        return $tData;
    }
}
	
