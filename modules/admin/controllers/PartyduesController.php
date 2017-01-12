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
class PartyduesController extends \yii\rest\Controller
{
	public $layout  = false;
	public $enableCsrfValidation=false;

	/*
	 * 计算并返回当前月份应缴党费
	 */
	public function actionDuescount()
	{
// 		$content=\Yii::$app->request->get('content');

// 		die('3');
		$request = \Yii::$app->request;
		$session = \Yii::$app->session;

		$info = $request->post();

// 		var_dump($info['info']);
		$info =json_decode($info['info'],true);

		$uid = isset($info['uid']) ? $info['uid'] : null;



		$session['user.uid'] = $uid;
		$session['page'] = 0;
		$return['result']['c']=0;
		$return['result']['c'] = 0;
		$return['result']['m'] = "";
		$return['result']['d'] = "";


		if(!$uid){
			$return['result']['c'] = -1;
			$return['result']['m'] = "uid为空";
			return $return ;
		}

		$connection = \Yii::$app->db;
		$connection->open();

		$sql ="select * from djleapartyfee where uid = '".$uid."' order by time desc limit 1" ;
		$result = $connection->createCommand($sql)->queryOne();

// 		var_dump($result);
// 		die('3');

		$return['result']['d'] = $result['prtyFee'];
		if($result['time']==date("Y-m")){
			if(!$return['result']['d']){
				$return['result']['d'] = $this->duescount($result['getMoney'],$result['memberType']);
				$sql1 = "update djleapartyfee set prtyFee = '".$return['result']['d']."' where id= ".$result['result']['id'];
				$result = $connection->createCommand($sql1);
				$result->execute();
			}

		}else{
			$return['result']['d'] = "-1";
		}

// 		die('4');

		return $return;
	}

	/*
	 * 查询党费缴纳历史记录
	 */
	public function actionRecord(){

		$request = \Yii::$app->request;
		$session = \Yii::$app->session;

		$return['c'] = 0;
		$return['m'] = "";
		$return['d'] = "";

		$uid = $session['user.uid'];

		if(!uid){
			$return['c'] = -1;
			$return['m'] = "uid为空";
			return $return ;
		}
		$page = $session['page'];
		$session['page'] = $page +1;

		$limit = 15;

		$offset = $limit * $page;

		$connection = \Yii::$app->db;
		$connection->open();

		$sql = "select * from djleapartyfee where uid = '".$uid."' order by time asc offset '".$offset."' limit '".$limit;

		$result = $connection->createCommand($sql)->queryAll();

		$return['d'] = $result;

		return $return;

	}

	public function duescount($money,$type)
	{
		$fee = 0;
		switch ($type)
		{
			case '01':

					if($money <= 3000){
						$fee = $money * 0.005;
					}elseif ($money <= 5000){
						$fee = $money * 0.01;
					}elseif ($money <= 10000){
						$fee = $money *0.015;
					}else {
						$fee = $money * 0.02;
					}

				 break;

			case '02':

					if($money <= 5000){
						$fee = $money * 0.005;
					}else {
						$fee = $money * 0.01;
					}
					break;


			case '04':
				$fee = "每月交纳党费0.2元-1元"; break;

			case '05':
				$fee = 0.2; break;


		}

		return $fee;
	}


	public function actionIndex()
	{
		$content=\Yii::$app->request->get('content');


		return $this->render('duescount',['content'=>$content]);
	}
}
