<?php

namespace common;

use Yii;
use yii\web\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @inheritdoc
     */
    public function setVendorPath($path)
    {
        parent::setVendorPath($path);
        Yii::setAlias('@npm', dirname(__DIR__) . '/node_modules');
    }
}