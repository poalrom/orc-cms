<?php

namespace admin\assets\core;

use mihaildev\elfinder\Assets;
use mihaildev\elfinder\AssetsCallBack;
use yii\redactor\widgets\RedactorAsset;

/**
 * Asset for imperavi redactor in admin panel
 *
 * @package admin\assets\core
 */
class RedactorAdminAsset extends BaseAsset
{
    public $js = [
        'js/redactor/plugins/elfinderImage.js',
    ];

    public $depends = [
        RedactorAsset::class,
        Assets::class,
        AssetsCallBack::class,
    ];
}
