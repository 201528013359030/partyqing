<?php

$params = require(__DIR__ . '/params.php');
$response = require(__DIR__ . '/response.php');
Yii::$classMap['QRcode'] = '@app/libs/phpqrcode/phpqrcode.php';
Yii::$classMap['TCPDF'] = '@app/libs/tcpdf/tcpdf.php';
Yii::$classMap['nusoap_client'] = '@app/libs/nusoap/nusoap.php';
Yii::$classMap['Client'] = '@app/libs/Rest/Client.php';
Yii::$classMap['Response'] = '@app/libs/Rest/Client/Response.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','debug'],
    'modules' => [
        'webService' => [
            'class' => 'app\modules\webService\api',
        ],
        'admin' => [
            'class' => 'app\modules\admin\index',
        ],
        'help' => [
            'class' => 'app\modules\help\index',
        ],
    	'debug' => [
    		'class' => 'yii\debug\Module',
    	],
    ],
    'defaultRoute'=>'admin/index/login',//默认路由，控制器+方法
    'components' => [
        'formatter' => [
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5ZSVNcMs3wP00Ss5zrnK3BsJe6uBXDT7',
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => $response,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',//模型自动登录
            'enableAutoLogin' => true,
            'loginUrl'=>['admin/index/login'],//定义后台默认登录界面[权限不足跳到该页]
        ],

        'errorHandler' => [
    //        'errorAction' => 'site/error',
            'errorAction' => 'error/index',
    //        'errorAction' => 'admin/noticelist/error',
           // 'errorAction' => 'webService/main/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'db2' => require(__DIR__ . '/db2.php'),
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
        //    'port' => 48720,
            'database' => 0,
        ],
        'es' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
            ],
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
            ],
        ],
        'session'=>[
            'class'=>'yii\web\Session',
           // 'savepath'=>'session'
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug']['class'] = 'yii\debug\Module';
    $config['modules']['debug']['allowedIPs'] = ['127.0.0.1', '::1', '192.168.139.*'];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['allowedIPs'] = ['127.0.0.1', '::1', '192.168.139.*'];
}

return $config;
