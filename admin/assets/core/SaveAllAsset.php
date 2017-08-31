<?php
namespace admin\assets\core;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * JS for 'saveAll' button in GridView.
 *
 * @package app\assets
 */
class SaveAllAsset extends BaseAsset
{
    public $js = [
        'js/core/saveAll.js',
    ];
    public $depends = [
        JqueryAsset::class,
        CoreAsset::class
    ];
}
