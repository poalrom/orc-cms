<?php

namespace common\modules;

/**
 * Page module
 *
 * @package common\modules
 */
class Pages extends BaseModule
{

    /**
     * Default value for item_per_page
     */
    const DEFAULT_ITEMS_PER_PAGE = 10;

    /**
     * @inheritdoc
     */
    public static function canUrlBeEmpty()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function getModuleName()
    {
        return 'Pages';
    }

    /**
     * @inheritdoc
     */
    public static function getMainAdminControllerName()
    {
        return 'Page';
    }

    /**
     * @inheritdoc
     */
    public static function getMainFrontControllerName()
    {
        return 'Page';
    }

    /**
     * @inheritdoc
     */
    public static function getModelName()
    {
        return \common\models\pages\Page::class;
    }

}