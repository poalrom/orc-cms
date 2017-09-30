<?php

namespace admin\assets\core;

use common\assets\AdminLteAsset;
use common\assets\FlagCssAsset;
use common\assets\JsCookieAsset;
use common\assets\AlertifyJsAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\YiiAsset;

/**
 * Asset for admin panel
 *
 * @package admin\assets\core
 */
class CoreAsset extends BaseAsset
{
    public $css = [
        'css/main.css',
    ];

    public $js = [
        'js/core/app.js',
        'js/core/loader.js',
        'js/core/sidebar.js',
        'js/core/notification.js',
        'js/core/translationTabs.js',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        AdminLteAsset::class,
        JsCookieAsset::class,
        AlertifyJsAsset::class,
    ];
}
