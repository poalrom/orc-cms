<?php

namespace common\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Asset for AdminLTE
 *
 * @url https://github.com/almasaeed2010/AdminLTE
 * @package common\assets
 */
class AdminLteAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/admin-lte';

    /**
     * @inheritdoc
     */
    public $css = [
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/skin-red.min.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/app.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
        FontAwesomeAsset::class
    ];
}