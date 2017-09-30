<?php

namespace common\traits;

use common\interfaces\core\EntityTranslationInterface;

/**
 * Trait for create entity breadcrumbs.
 *
 * @package common\traits
 * @mixin \yii\base\Object
 */
trait EntityBreadcrumbs
{
    /**
     * Collecting breadcrumbs. If there is root entity, then return false. Else get full link and chained parents of
     * entity. Parent's getUrl method isn't used, because there is too many requests to DB.
     *
     * @return array Array of breadcrumbs for standard Yii2 breadcrumbs widget.
     */
    public function getBreadcrumbs()
    {
        if (!method_exists($this, 'getUrl')) {
            return [];
        }
        $link = $this->getUrl();
        if ($link == '' || $link == '/') {
            return [];
        }
        $tree = explode('/', $link);
        $i = 1;
        if (method_exists($this, 'getParentTree')) {
            foreach ($this->getParentTree() as $route) {
                $i++;
                if ($route->is_active) {
                    $urlArray = array_slice($tree, 0, $i);
                    $breadcrumbs[] = [
                        'label' => $this->getItemTitle($route->item),
                        'url' => implode('/', $urlArray),
                    ];
                } else {
                    $breadcrumbs[] = $this->getItemTitle($route->item);
                }
            }
        }
        $breadcrumbs[] = $this->getItemTitle($this);

        return $breadcrumbs;
    }

    /**
     * Get title from object. Item can include translation or title property
     *
     * @param \yii\base\Object $item
     *
     * @return string
     */
    private function getItemTitle($item)
    {
        if (
        (
            method_exists($item, 'getCurrentTranslation') ||
            property_exists($item, 'currentTranslation')
        ) && $item->currentTranslation instanceof EntityTranslationInterface
        ) {
            return $item->currentTranslation->title;
        } elseif (method_exists($item, 'getTitle') || property_exists($item, 'title')) {
            return $item->title;
        }

        return '';
    }
}
