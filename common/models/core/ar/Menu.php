<?php

namespace common\models\core\ar;

use common\components\LanguageComponent;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Front menu AR model
 *
 * @property string     $id Menu ID
 * @property string     $alias Menu alias
 * @property string     $title Menu title
 * @property MenuLink[] $links Menu links array
 *
 * @package common\models\core\ar
 */
class Menu extends EntityModel
{

    const MAIN_MENU_ALIAS = 'main';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('core/attributes', 'id'),
            'alias' => Yii::t('core/attributes', 'alias'),
            'title' => Yii::t('core/attributes', 'title'),
        ];
    }

    /**
     * Get links on current language
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(MenuLink::className(),
            ['menu_id' => 'id'])->where(['lang_id' => LanguageComponent::getCurrent()->id])->orderBy('order');
    }

    /**
     * Get link list for menu
     *
     * @param int $lang_id Language ID
     * @param int $exclude_link_id Item ID for exclude it and it's children
     *
     * @return array
     */
    public function getLinkList($lang_id, $exclude_link_id = 0)
    {
        return ArrayHelper::map(
            $this->hasMany(MenuLink::className(), ['menu_id' => 'id'])
                ->alias('menuLink')
                ->where([
                    'lang_id' => $lang_id,
                ])
                ->andWhere(['!=', 'menuLink.id', $exclude_link_id])
                ->orderBy('order')
                ->all(),
            'id',
            'title'
        );
    }
}
