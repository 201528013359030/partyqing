<?php
namespace app\modules\admin\models;
use Yii;
use app\modules\admin\models\IctWebService;
use yii\base\Model;
/**
 * 
 */
class AuthToken extends Model
{
    public function authTokenSession(){
        $session = Yii::$app->session;
        $session->open();
        $token = Yii::$app->request->get('auth_token');
        //$apiKey = Yii::$app->request->get('apiKey');
        $apiKey = "36116967d1ab95321b89df8223929b14207b72b1";
        $sender = Yii::$app->request->get('uid');
        $enterprisId = Yii::$app->request->get('eguid');
        //if($token){}else{ $token=\Yii::$app->session['user.uid'];}
        //if($sender){}else{$sender=\Yii::$app->session['user.uid'];}
        if($token && $apiKey && $sender && $enterprisId){
        
            $eid = explode("@",$sender);
            $session['user.token']=$token;
            $session['user.apiKey']=$apiKey;
            $session['user.sender']=$sender;
            $session['user.enterprisId']=$enterprisId;
            $session['user.uid']=$sender;
            $session['user.eid']=$eid[1];
            if($session['user.uid'] == 'buliping@'.$eid[1]){
                Yii::$app->session['user.pname'] = 'admin';
            }
            //print_r($session);exit;
        }elseif((!isset($session['user.token'])) ||  
                (!isset($session['user.apiKey'])) ||  
                (!isset($session['user.sender'])) ||  
                (!isset($session['user.enterprisId']))
               ){  
            throw new \yii\web\HttpException(200,'10001');
            print_r("error!");
        }   
      
        $authToken = new IctWebService();
        if(!$authToken->authToken($session['user.sender'],$session['user.token'])){
            throw new \yii\web\HttpException(200,'10001');
            print_r("error!");
            exit;
        }   
        $session->close();
        return;
    }
    public function authTokenUrl(){
        $session = Yii::$app->session;
        $token = Yii::$app->request->get('auth_token');
        //$apiKey = Yii::$app->request->get('apiKey');
        $apiKey = "36116967d1ab95321b89df8223929b14207b72b1";
        $sender = Yii::$app->request->get('uid');
        $enterprisId = Yii::$app->request->get('eguid');
        if($token && $apiKey && $sender && $enterprisId){
            $eid = explode("@",$sender);
            $session['user.token']=$token;
            $session['user.apiKey']=$apiKey;
            $session['user.sender']=$sender;
            $session['user.enterprisId']=$enterprisId;
            $session['user.uid']=$sender;
            $session['user.eid']=$eid[1];
        }else{ 
            throw new \yii\web\HttpException(200,'10001');
            print_r("error!");
            exit;
        }   
        $authToken = new IctWebService();
        if(!$authToken->authToken($session['user.sender'],$session['user.token'])){
            throw new \yii\web\HttpException(200,'10001');
            print_r("error!");
            exit;
        }   
        return;
    }
}
