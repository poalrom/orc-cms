<?php

namespace front\controllers\core;

use front\controllers\BaseController;
use yii\captcha\CaptchaAction;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class ServiceController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class'           => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

}
