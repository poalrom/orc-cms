<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/views/editorial',
                'baseUrl' => '@web/front/editorial',
                'pathMap' => [
                    '@app/views' => '@app/views/editorial',
                ],
            ],
        ]
    ],
];
