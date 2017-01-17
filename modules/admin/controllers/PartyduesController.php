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
header("Access-Control-Allow-Origin: *"); # 跨域处理
class PartyduesController extends \yii\rest\Controller
{
	public $layout  = false;
	public $enableCsrfValidation=false;

	/*
	 * 计算并返回当前月份应缴党费
	 */
	public function actionDuescount()
	{
		$request = \Yii::$app->request;
		$session = \Yii::$app->session;

		$info = $request->post();
		$info =json_decode($info['info'],true);

		$uid = isset($info['uid']) ? $info['uid'] : null;
		$auth_token =isset($info['auth_token'])?$info['auth_token']:null;

		$session['user.uid'] = $uid;
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

		if(!$result){
			$return['result']['d'] = "-1";
			return $return;
		}
		$date = date_format(date_create($result['time']),"Y-m"); //返回一个新的 DateTime 对象，然后格式化该日期：

		$return['result']['d'] = $result;
		if($date == date("Y-m")){
			if(!$return['result']['d']['prtyFee']){
				$return['result']['d']['prtyFee'] = $this->duescount($result['getMoney'],$result['memberType']);
// 				die($return['result']['d']['prtyFee']);
				$sql1 = "update djleapartyfee set prtyFee = '".$return['result']['d']['prtyFee']."' where id= ".$result['id'];
				$result = $connection->createCommand($sql1);
				if($result->execute()== 0){
					$return['result']['d']['prtyFee'] = "-2"; //更新当月应缴党费信息失败
				}
			}
		}else{
			$return['result']['d']['prtyFee'] = "-1"; //没有当月应缴党费信息
		}
		return $return;
	}

	/*
	 * 查询党费缴纳历史记录
	 */
	public function actionRecord(){

		$request = \Yii::$app->request;
		$session = \Yii::$app->session;

		$info = $request->post();

// 		var_dump($info['info']);
		$info =json_decode($info['info'],true);

		$uid = isset($info['uid']) ? $info['uid'] : null;
		$auth_token =isset($info['auth_token'])?$info['auth_token']:null;
		$page = isset($info['page'])?$info['page']:"0";

		$return['result']['c'] = 0;
		$return['result']['m'] = "";
		$return['result']['d'] = "";

	if(!$uid){
			$return['result']['c'] = -1;
			$return['result']['m'] = "uid为空";
			return $return ;
		}


		$limit = 15;

		$offset = $limit * $page;

		$connection = \Yii::$app->db;
		$connection->open();

		$sql = "select * from djleapartyfee where uid = '".$uid."' order by time desc limit ".$limit." offset ".$offset; //查询结果按时间倒序
		$result = $connection->createCommand($sql)->queryAll();

		if(!$result){
			$return['result']['d'] = "-1";
			return $return;
		}

		$sql2 = "select name from organization where oid = '".$result[0]['branchId']."'";
		$branch = $connection->createCommand($sql2)->queryAll();

		if($result){
			for( $i=0;$i < count($result);$i++){
				$result[$i]['branch'] = $branch[0]['name'];
			}
		}
// 		$result['branch'] = $branch;

		$return['result']['d']= $result;

		return $return;

	}

	/*
	 * 根据页面输入信息进行党费计算
	 */
	public function duescount($money,$type)
	{
		$fee = 0.0;
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
				$fee = "0.2-1"; break;

			case '05':
			case '06':
			case '07':
			case '08':
				$fee = 0.2; break;
		}

		if(!is_string($fee)){
			$fee = ceil($fee*10);//保留一位小时，向上取整
			$fee = $fee/10;
		}
		return $fee;
	}


	public function actionIndex()
	{
		$content=\Yii::$app->request->get('content');


		return $this->render('duescount',['content'=>$content]);
	}
}
