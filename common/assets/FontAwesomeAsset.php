<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Asset for FontAwesome
 *
 * @url https://github.com/FortAwesome/Font-Awesome
 * @package common\assets
 */
class FontAwesomeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/font-awesome';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/font-awesome.min.css',
    ];
}