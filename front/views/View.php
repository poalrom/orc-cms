<?php

namespace front\views;

use common\components\LanguageComponent;
use common\models\core\ar\Menu;
use common\models\core\ar\MenuLink;
use front\themes\EditorialTheme;
use yii\web\View as BaseView;

/**
 * Base view class for front app
 *
 * @package front\views
 */
class View extends BaseView
{
    /**
     * @var \common\models\core\ar\EntityModel
     */
    public $entity;

    /**
     * Get menu items for MenuWidget
     *
     * @param string $alias Menu alias
     *
     * @return array
     */
    public function getMenuItems($alias)
    {
        $menu = Menu::findOrFail(['alias' => $alias]);
        $menuItems = $menu->getLinks()->alias('ml')->where([
            'ml.parent_id' => 0,
            'ml.lang_id'   => LanguageComponent::getCurrent()->id,
            'ml.is_active' => true,
        ])
            ->joinWith('children c')
            ->all();

        return EditorialTheme::menuArrayToItems($menuItems);
    }
}