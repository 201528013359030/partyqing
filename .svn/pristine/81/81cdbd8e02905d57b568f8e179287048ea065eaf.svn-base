<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ErrorController extends Controller
{
    public $layout  = 'error';
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}
