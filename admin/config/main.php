<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-admin',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'bootstrap'           => ['log'],
    'modules' => [
        'redactor' => \yii\redactor\RedactorModule::class,
    ],
    'components'          => [
        'authManager'  => 'adminAuthManager',
        'request'      => [
            'csrfParam' => '_csrf-admin',
        ],
        'user'         => [
            'identityClass'   => \admin\models\core\ar\Admin::class,
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-admin', 'httpOnly' => true],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the admin
            'name' => 'advanced-admin',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => \admin\controllers\core\MainController::ERROR_ROUTE,
        ],
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class'    => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@admin/translations',
                ],
            ],
        ],
        'urlManager'   => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'rules'               => require('routes.php'),
        ],
        'view'         => [
            'class' => \admin\views\View::class,
        ],
    ],
    'params'              => $params,
    'container'           => [
        'definitions' => [
            \common\interfaces\core\UserInterface::class => 'user',
        ],
    ],
];
