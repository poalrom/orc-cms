<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-front',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'front\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-front',
        ],
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-front', 'httpOnly' => true],
        ],*/
        'session' => [
            // this is the name of the session cookie used for login on the front
            'name' => 'advanced-front',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'core/service/error',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@front/translations',
                ],
            ],
        ],
        'urlManager' => [
            'class' => \front\components\RouterComponent::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view'         => [
            'class' => \front\views\View::class,
        ],
    ],
    'params' => $params,
];
