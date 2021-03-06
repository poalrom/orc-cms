<?php

namespace front\themes;

use common\components\LanguageComponent;

/**
 * Helper functions for editorial theme
 *
 * @package front\themes
 */
class EditorialTheme
{

    /**
     * Build sidebar menu
     *
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
            $url = '/' . implode('/', \Yii::$app->params['route']);
            $urlWithLang = '/' . LanguageComponent::getCurrent()->url . $url;
            $isItemActive = $url === $menuItem->link || $urlWithLang === $menuItem->link;
            array_push($menuTree, [
                'label'    => $menuItem->title,
                'url'      => $menuItem->link,
                'items'    => $childItems,
                'active'   => $isItemActive,
                'template' => $hasChildren ?
                    '<span class="opener' . ($isItemActive ? ' active' : '') . '">{label}</span>' :
                    '<a href="{url}" target="' . $menuItem->target . '">{label}</a>',
            ]);
        }

        return $menuTree;
    }
}