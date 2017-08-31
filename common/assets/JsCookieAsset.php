<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Asset for JsCookie
 *
 * @url https://github.com/js-cookie/js-cookie
 * @package common\assets
 */
class JsCookieAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/js-cookie';

    /**
     * @inheritdoc
     */
    public $js = [
        'src/js.cookie.js',
    ];
}