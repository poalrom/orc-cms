<?php

namespace front\views;

use common\components\LanguageComponent;
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
        $menuItems = MenuLink::find()->alias('ml')
            ->orderBy('order')
            ->where([
                'ml.parent_id' => 0,
                'ml.lang_id' => LanguageComponent::getCurrent()->id
            ])
            ->joinWith('children c')
            ->joinWith('menu m')
            ->andWhere(['m.alias' => $alias])
            ->all();

        return EditorialTheme::menuArrayToItems($menuItems);
    }
}