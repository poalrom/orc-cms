<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Front asset with flag icons
 */
class FlagCssAsset extends AssetBundle
{
    public $sourcePath = '@npm/flag-icon-css';

    public $css = [
        'css/flag-icon.min.css',
    ];
}
