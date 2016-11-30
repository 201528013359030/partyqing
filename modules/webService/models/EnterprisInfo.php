<?php
namespace app\modules\webService\models;
use app\modules\webService\models\Wechat;
use app\modules\webService\models\WechatToken;
use app\models\Enterpris;

class EnterprisInfo extends \app\modules\webService\models\WebService
{


	public $registerApi = [];
	function __construct(){
        parent::init();
        parent::registerApi("enterprise.set",
                "enterpriseSet",
                [
                "enterprisId"=>['type'=>'string'],
                "eid"=>['type'=>'string'],
                "ip"=>['type'=>'string'],
                "time"=>['type'=>'string','required' => false],
                ]
                );
        parent::registerApi("enterprise.del",
                "enterpriseDel",
                [
                "enterprisId"=>['type'=>'string'],
                ]
                );
	}
    public function enterpriseSet($enterprisId,$eid,$ip,$time){
        $einfo = Enterpris::find()->where(['enterpris_id'=>$enterprisId])->one();
        if(isset($einfo['id'])){
            $enterpris = Enterpris::findOne($einfo['id']);
            $enterpris->eid = $eid;
            $enterpris->ip = $ip;
            $enterpris->time = $time;
            $enterpris->save();
        }else{
            $enterpris = new Enterpris();
            $enterpris->enterpris_id = $enterprisId;
            $enterpris->eid = $eid;
            $enterpris->ip = $ip;
            $enterpris->time = $time;
            $enterpris->save();
        }
		return ["success"=>1];
    }
    public function enterpriseDel($enterprisId){
        $enterpris = new Enterpris();
        $einfo =  $enterpris->find()->where(['enterpris_id'=>$enterprisId])->one();
        $einfo->delete();

        return ["success"=>1];
    }
   
}

?>
