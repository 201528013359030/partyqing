<?php

namespace app\modules\admin\controllers;
use yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
    	print_r(Yii::$app->user) ;
            	exit;
    //	print_r(Yii::$app->user->identity->nickname);
    	print_r(Yii::$app->user->identity->user);
    	exit;
        return $this->render('index');
    }
}
