<?php

namespace front\controllers\widgets\htmlBlock;

use common\widgets\models\htmlBlock\HtmlBlock as Model;
use front\controllers\widgets\BaseController;

/**
 * HtmlBlock widget front controller
 *
 * @package front\controllers\widgets\htmlBlock
 */
class HtmlBlockController extends BaseController
{
    /**
     * @inheritdoc
     */
    public static function handle($shortcode)
    {
        if (!($alias = static::getAlias($shortcode)[2])) {
            return '';
        }
        /** @var Model $block */
        $block = Model::find()->where([
            'alias'     => $alias,
            'is_active' => true,
        ])->joinWith('currentTranslation')->one();
        if (!is_null($block)) {
            return $block->currentTranslation->content;
        }

        return "";
    }

}