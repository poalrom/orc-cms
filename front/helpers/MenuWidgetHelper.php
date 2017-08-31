<?php

namespace front\helpers;

/**
 * Helper for MenuWidget for admin panel
 *
 * @package front\helpers
 */
class MenuWidgetHelper
{

    /**
     * @param \common\models\core\ar\MenuLink[] $menuItems
     * @param integer                           $depth
     *
     * @return array
     */
    public static function menuArrayToItems($menuItems, $depth = 0)
    {
        if ($depth === 10 || count($menuItems) === 0) {
            return [];
        }
        $menuTree = [];
        foreach ($menuItems as $menuItem) {
            $childItems = static::menuArrayToItems($menuItem->children, $depth + 1);
            $hasChildren = boolval(count($childItems));
            $isItemActive = '/'.implode('/', \Yii::$app->params['route']) === $menuItem->link;
            array_push($menuTree, [
                'label' => $menuItem->title,
                'url'   => $menuItem->link,
                'items' => $childItems,
                'active' => $isItemActive,
                'template' => $hasChildren ? '<span class="opener">{label}</span>' : '<a href="{url}">{label}</a>'
            ]);
        }

        return $menuTree;
    }
}