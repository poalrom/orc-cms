<?php

namespace common\traits;

/**
 * Trait for create entity breadcrumbs.
 *
 * @package common\traits
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
            foreach ($this->getParentTree() as $item) {
                $i++;
                if ($item->is_active) {
                    $urlArray = array_slice($tree, 0, $i);
                    $breadcrumbs[] = [
                        'label' => $item->item->translation->title,
                        'url' => implode('/', $urlArray),
                    ];
                } else {
                    $breadcrumbs[] = $item->item->translation->title;
                }
            }
        }
        if (method_exists($this, 'getCurrentTranslation') || property_exists($this, 'currentTranslation')) {
            $breadcrumbs[] = $this->currentTranslation->title;
        } else {
            $breadcrumbs[] = $this->title;
        }

        return $breadcrumbs;
    }
}
