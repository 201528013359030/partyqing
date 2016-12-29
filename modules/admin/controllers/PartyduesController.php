<?php
namespace app\modules\admin\controllers;
use yii;
use yii\web\Controller;
use yii\widgets\Breadcrumbs;

/**
 *
 * @author fang
 * @党费助手
 *
 */
class PartyduesController extends Controller
{
	public $layout  = false;
	public function actionIndex()
	{
		$content=\Yii::$app->request->get('content');
		return $this->render('index',['content'=>$content]);
	}
}
