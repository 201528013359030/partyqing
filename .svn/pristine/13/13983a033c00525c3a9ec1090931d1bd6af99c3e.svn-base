<?php

namespace app\modules\admin\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Noticeuser;
use app\modules\admin\models\IctWebService;

class IndexController extends Controller{
    public $enableCsrfValidation = false;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout  = 'layout';

    /**
     * accesscontrol
     */

    /**
     * @用户授权规则
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * @return string 后台默认页面
     */
    public function actionIndex()
    {
        //echo Yii::$app->user->getId().'<br/>';获取用户id
        //echo Yii::$app->user->identity->getUser();//获取用户名

       // echo Yii::$app->basePath;//获取应用根目录
        print_r(Yii::$app->user);
        exit;
        return $this->render('index');
    }



    /**
     * @return string|\yii\web\Response 用户登录
     */

    public function actionLogin(){
        $admin = Yii::$app->request->post('LoginForm');
        if($admin['username'] == 'admin'){
            Yii::$app->session['user.pname'] = 'admin';
            $login = false;
            if (!Yii::$app->user->isGuest) {
                $login = true;
            }else{
                $model = new LoginForm();
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                    $login = true;
                } else {
                    if(YII_ICT){
                    }else{
                        $model->eid = '97908';
                        // $model->eid = '71422';
                    }
                    return $this->render('login', [
                        'model' => $model,
                        ]);
                }
            }
            if($login){
                $token = new IctWebService();
                $token->getAdminToken();
                $token->getNodeInfo($admin['eid'],['nodename']);    
                //     print_r($token->params['auth_token'] );
                return $this->redirect("index.php?r=admin/main/create&uid=buliping@".$admin['eid']."&eguid=".md5($token->get_mac().$admin['eid'])."&auth_token=".$token->params['auth_token']);
                return $this->redirect(['create'
                    ]);
                return $this->goBack();
            }
        }else{
            $token = new IctWebService();
            $user = Noticeuser::findOne(['mobile'=>$admin['username'],'eid'=>$admin['eid']]);
            if($user && $token->loginElgg($admin['username'],$admin['password'])){
                Yii::$app->session['user.pname'] = $user->name;
                return $this->redirect("index.php?r=admin/main/create&uid=".$token->params['uid']."&eguid=".md5($token->get_mac().$admin['eid'])."&auth_token=".$token->params['auth_token']);
            }else{
                $model = new LoginForm();
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                    $login = true;
                } else {
                    if(YII_ICT){
                    }else{
                        $model->eid = '97908';
                        // $model->eid = '71422';
                    }
                    return $this->render('login', [
                        'model' => $model,
                        ]);
                }
            }
        }
    }



    /**
     * @后台退出页面
     */
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect(['index/login']);

    }
    public function actionRelog(){
        Yii::$app->user->logout();
        return $this->redirect(['index/login']);
    
    }



}
