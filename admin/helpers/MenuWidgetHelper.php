<?php

namespace admin\helpers;

use Yii;

/**
 * Helper for MenuWidget for admin panel
 *
 * @package admin\helpers
 */
class MenuWidgetHelper
{

    /**
     * @param \admin\models\core\ar\AdminMenuItem[] $menuItems
     * @param integer                               $depth
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
            if (!Yii::$app->user->can($menuItem->permission)) {
                continue;
            }
            $childItems = static::menuArrayToItems($menuItem->children, $depth + 1);
            $hasChild = boolval(count($childItems));
            array_push($menuTree, [
                'label' => "<i class='fa fa-{$menuItem->fa_icon}'></i><span>"
                    . Yii::t($menuItem->title_category, $menuItem->title)
                    . "</span>"
                    . ($hasChild ? "<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>" : ''),
                'url'   => [$menuItem->route],
                'icon'  => $menuItem->fa_icon,
                'items' => $childItems,
            ]);
        }

        return $menuTree;
    }
}