<?php

namespace app\modules\webService\controllers;
use Yii;
use app\modules\webService\models\Basic;
use app\modules\webService\models\EnterprisInfo;

class MainController extends \yii\rest\Controller
{
	public function actionHehe()
    {
    	$hehe = new Basic;
       // return $this->render('hehe');
    //	$loginInfo = Yii::$app->request->post();
        return $hehe->test();
    }
    public function actionApi($method)
    {
        $webService = new EnterprisInfo;
        $webService->setMethod($method);
        return $webService->run();
    }
    public function actionWechat()
    {
        $es = \Yii::$app->es;
        $cmd = $es->createCommand();
        $data['test']='test';
        $return = $cmd->insert("wechat","im",$data);
       // $es->head("wechat");
        return $return;
    }
    public function actionTest()
    {
        $connection = \Yii::$app->db;                                                  
        $connection->createCommand()->update('bind_info',                              
                ['wid' => 'owxcmswW8i2o1LFk-pDxNAVqhHQA','time' =>  time(),],                                      
                'mobile=\'18900923392\'')->execute(); 
    	$return = Yii::$app->request->post();
        return $return['result']=1;
    }
}
