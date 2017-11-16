<?php

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

/**
 * Determine application part
 */
if (boolval(preg_match('#/admin/#', $_SERVER['REQUEST_URI']))) {
    $part = 'admin';
} else {
    $part = 'front';
}
defined('ORC_PART') or define('ORC_PART', $part);

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../common/config/bootstrap.php');
require(__DIR__ . '/../' . ORC_PART . '/config/bootstrap.php');

$config = require(__DIR__ . '/../' . ORC_PART . '/config/test-local.php');

(new yii\web\Application($config))->run();
