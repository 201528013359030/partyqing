<?php

// comment out the following two lines when deployed to production

//defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('YII_TEST') or define('YII_TEST', false);
defined('YII_ICT') or define('YII_ICT', true);

//error_reporting(7);
defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'prod');

require(__DIR__ . '/../vendor/autoload.php'); //_DIR_当前文件所在文件夹目录。
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
