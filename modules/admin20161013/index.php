<?php

namespace app\modules\admin;
use Yii;
use app\modules\admin\models\IctWebService;
class index extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();
        Yii::$app->params['urlSubflag'] = '&subflag='.Yii::$app->request->get('subflag');
//        ini_set("session.save_path",'session');
        //$this->authUser();
        // custom initialization code goes here
    }
    public function authUser(){
    	$session = Yii::$app->session;
        $token = Yii::$app->request->get('auth_token');
        //$apiKey = Yii::$app->request->get('apiKey');
        $apiKey = "36116967d1ab95321b89df8223929b14207b72b1";
        $sender = Yii::$app->request->get('uid');
        $enterprisId = Yii::$app->request->get('eguid');
        if($token && $apiKey && $sender && $enterprisId){
        	$session['user'] = ['token'=>$token,'apiKey'=>$apiKey,'sender'=>$sender,'enterprisId'=>$enterprisId,'uid'=>$sender];
        }elseif((!isset($session['user']['token'])) || 
        	(!isset($session['user']['apiKey'])) || 
        	(!isset($session['user']['sender'])) || 
        	(!isset($session['user']['enterprisId']))
        	){
        	//throw new \yii\web\HttpException(200,'Invalid method',20100);
        	print_r("error!");
        	exit;
        }
        $authToken = new IctWebService();
        if(!$authToken->authToken($session['user']['sender'],$session['user']['token'])){
        	print_r("error!");
        	exit;
        }
        return;
    }
}
