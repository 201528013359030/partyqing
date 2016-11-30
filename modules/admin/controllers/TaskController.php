<?php
namespace app\modules\admin\controllers;
use Yii;
use app\modules\admin\models\IctWebService;
use app\modules\admin\models\AuthToken;


class TaskController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout  = false;
//    public $layout  = 'announce';
//    public $layout  = 'layout';    
    public function actionIndex()
    {    
    	$auth = new AuthToken();
    	$auth->authTokenSession();
    	$uid=\yii::$app->request->get('uid');  

    	header("Content-type:text/html;charset=utf-8");
    	\Yii::$app->session['user.uid']=$uid;
    	
        return $this->render('index',[
        		'uid' => $uid,        
        		//'pic' => $path,
        ]);
    }

}
