<?php

namespace admin\assets\core;

use yii\web\AssetBundle;

/**
 * Base asset class for admin panel
 *
 * @package admin\assets\core
 */
abstract class BaseAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot/admin';

    /**
     * @inheritdoc
     */
    public $baseUrl = '@web/admin';
}