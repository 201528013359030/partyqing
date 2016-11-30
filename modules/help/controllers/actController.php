<?php

namespace app\modules\help\controllers;

class actController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
