<?php

namespace app\modules\help\controllers;

class helpController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
