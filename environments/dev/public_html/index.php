<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

/** Set admin url prefix */
defined('ORC_ADMIN_PREFIX') or define('ORC_ADMIN_PREFIX', 'admin');

/**
 * Determine application part
 */
if (boolval(preg_match('#/' . ORC_ADMIN_PREFIX . '(-debug)?/#', $_SERVER['REQUEST_URI']))) {
    $part = 'admin';
} else {
    $part = 'front';
}
defined('ORC_PART') or define('ORC_PART', $part);

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../common/config/bootstrap.php');
require(__DIR__ . '/../' . ORC_PART . '/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../common/config/main.php'),
    require(__DIR__ . '/../common/config/main-local.php'),
    require(__DIR__ . '/../' . ORC_PART . '/config/main.php'),
    require(__DIR__ . '/../' . ORC_PART . '/config/main-local.php')
);

(new yii\web\Application($config))->run();
