<?php

namespace front\assets\editorial;

use common\assets\FlagCssAsset;
use common\assets\FontAwesomeAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/front/editorial';
    public $baseUrl = '@web/front/editorial';

    public $css = [
        'css/main.css',
    ];
    public $js = [
        'js/skel.min.js',
        'js/util.js',
        'js/main.js',
    ];

    public $depends = [
        JqueryAsset::class,
        FontAwesomeAsset::class,
        FlagCssAsset::class,
    ];
}
