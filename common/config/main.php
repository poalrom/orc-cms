<?php
return [
    'language'   => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
    'container'  => [
        'singletons' => [
            'adminAuthManager' => [
                'class'           => \admin\components\AdminAuthManager::class,
                'itemTable'       => '{{%admin_auth_item}}',
                'itemChildTable'  => '{{%admin_auth_item_child}}',
                'assignmentTable' => '{{%admin_auth_assignment}}',
                'ruleTable'       => '{{%admin_auth_rule}}',
            ],
        ],
    ],
];
