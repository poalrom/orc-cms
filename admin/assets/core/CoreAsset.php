<?php

namespace admin\assets\core;

use common\assets\AdminLteAsset;
use common\assets\FlagCssAsset;
use common\assets\JsCookieAsset;
use common\assets\NotifyJsAsset;
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
        'css/core/grid-view/grid.css',
        'css/core/grid-view/action-column.css',
        /*'http://fonts.googleapis.com/css?family=Roboto:400,700,300',
        'css/font-awesome.min.css',
        'css/admin/AdminLTE.min.css',
        'css/admin/skin-green-light.min.css',
        'css/admin/admin.css',
        'js/fancybox/jquery.fancybox.css',*/
    ];

    public $js = [
        'js/core/app.js',
        'js/core/loader.js',
        'js/core/sidebar.js',
        'js/core/notification.js',
        'js/core/translationTabs.js',
        /*'js/cookies.js',
        'js/clipboard.js',
        'js/tinymce/tinymce.min.js',
        'js/fancybox/jquery.fancybox.pack.js',
        'js/admin/app.js',
        'js/admin/bootstrap-notify.min.js',
        'js/admin/admin.js',*/
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        AdminLteAsset::class,
        JsCookieAsset::class,
        NotifyJsAsset::class,
        FlagCssAsset::class,
    ];
}
