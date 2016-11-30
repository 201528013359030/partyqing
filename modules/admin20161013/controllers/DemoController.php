<?php
namespace app\modules\admin\controllers;
use yii;
use yii\web\Controller;

class DemoController extends Controller
{
	public $layout  = false;
	public function actionIndex()
	{
		$content=\Yii::$app->request->get('content');
		return $this->render('index',['content'=>$content]);
		
	}
}
