<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Asset for AlertifyJS
 *
 * @url http://alertifyjs.com
 *
 * @package common\assets
 */
class AlertifyJsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/alertifyjs/build';

    /**
     * @inheritdoc
     */
    public $js = [
        'alertify.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/alertify.css',
        'css/themes/semantic.css'
    ];
}