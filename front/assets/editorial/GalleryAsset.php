<?php

namespace front\assets\editorial;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Asset bundle for slick js gallery.
 */
class GalleryAsset extends AssetBundle
{
    public $basePath = '@webroot/front/editorial';
    public $baseUrl = '@web/front/editorial';

    public $css = [
        '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css',
        '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css',
        'slimbox/slimbox2.css'
    ];
    public $js = [
        '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js',
        'js/gallery.js',
        'slimbox/slimbox2.js'
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
