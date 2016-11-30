<?php
namespace app\modules\webService\models;
use app\modules\webService\models\Curl;
use app\models\AdminInfo;
class WebService extends \yii\base\Component
{
	public $method;
	public $methodManage;

	function init(){
        $this->registerApi("auth.gettoken",
                "authGettoken",
                [
                "name"=>['type'=>'string'],
                "password"=>['type'=>'string'],
                "apiKey"=>['type'=>'string'],
                ],
                false
                );
    }

    public function run(){
    	if(!isset($this->methodManage[$this->method])){
            throw new \yii\web\HttpException(200,'Invalid method',20100);
    	}
        if(!$this->authAccessToken()){
            throw new \yii\web\HttpException(200,'Method call failed the API Authentication',20101);
        }
    	$parameter = $this->methodManage[$this->method]['parameter'];
    	$post = \Yii::$app->request->post();
 		$parameterStr="";
		while ($key = key($this->methodManage[$this->method]['parameter'])) {
            if(!isset($post[$key])){
                if(isset($this->methodManage[$this->method]['parameter'][$key]['required'])){
                    if($this->methodManage[$this->method]['parameter'][$key]['required'] === false){
                        next($this->methodManage[$this->method]['parameter']);
                        continue;  
                    }else{
                        throw new \yii\web\HttpException(200,"Missing parameter $key in method ".$this->method,20102);
                    }
                }else{
                    throw new \yii\web\HttpException(200,"Missing parameter $key in method ".$this->method,20102);
                }
            }  
		 	$evalStr = "$$key=".'$post[$key];';
		 	eval($evalStr);
		 	$parameterStr = $parameterStr."$$key,";
		 	next($this->methodManage[$this->method]['parameter']);
		}
		$parameterStr = substr($parameterStr,0,-1);
	//	return $parameterStr;
    	$runStr = '$return[\'data\'] = $this->'.$this->methodManage[$this->method]['method']."($parameterStr);";
    	eval($runStr);
        $return['code']=-1;
    	return $return;
    }

    public function setMethod($method){
    	$this->method = $method;
    }
    public function getInput($paramsNmae){
        $post = \Yii::$app->request->post();
//        file_put_contents("/tmp/wx.log", date("D M d H:i:s Y") . " result:" . json_encode($post) ."\n", FILE_APPEND);
        if(isset($post[$paramsNmae])){
            return $post[$paramsNmae];
        }else{
            return false;
        }
    }

    public function registerApi($apiName,$method,$parameter,$auth=true){
    	if(isset($this->methodManage[$apiName])){
    		return 0;
    	}
    	$this->methodManage[$apiName]['method'] = $method;
    	$this->methodManage[$apiName]['parameter'] = $parameter;
    	$this->methodManage[$apiName]['auth'] = $auth;
    }
    public function authAccessToken(){
        if($this->methodManage[$this->method]['auth']){
            $token = \Yii::$app->request->post('authToken');    
            $apiKey = \Yii::$app->request->post('apiKey');    
            $user = AdminInfo::find()->where(['accessToken'=>$token,'authKey'=>$apiKey])->one();
            if($user){
                $return=1;   
            }else{
                $return=0;
            }
        }else{
            $return=1;
        }
        return $return;
    }
    public function authGettoken($name,$password,$apiKey){

         $user = AdminInfo::find()->where(['user'=>$name,'password'=>md5($password),'authKey'=>$apiKey])->one();
         if($user){
            return ['authToken'=>$user['accessToken']];   
         }else{
            throw new \yii\web\HttpException(200,'User could not be authenticated',20102);
         }
        
    }
}

?>
