<?php

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Asset for NotifyJS
 *
 * @url https://notifyjs.com/
 * @package common\assets
 */
class NotifyJsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/notifyjs-browser';

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/notify.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        JqueryAsset::class,
    ];
}