<?php

namespace common\models\core\ar;

use Yii;

/**
 * Класс для работы с пунктами меню.
 *
 * @property int        $id Menu item ID
 * @property int        $menu_id Menu ID
 * @property int        $lang_id Language ID
 * @property string     $title Menu item title
 * @property string     $link Link
 * @property int        $order Sort order
 * @property int        $parent_id Parent item ID
 * @property string     $css_class CSS class
 * @property string     $target Target link attribute
 * @property int        $is_active Is link active
 * @property Menu       $menu Menu AR model
 * @property MenuLink   $parent Parent item AR model
 * @property MenuLink[] $children Child AR models
 * @property Lang       $lang Lang AR model
 *
 * @package common\models\core\ar
 */
class MenuLink extends EntityModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'lang_id', 'order', 'parent_id'], 'integer'],
            [['title', 'link', 'css_class'], 'string', 'max' => 255],
            ['target', 'in', 'range' => ['_blank', '_self']],
            [
                ['menu_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Menu::className(),
                'targetAttribute' => ['menu_id' => 'id'],
            ],
            [
                ['lang_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Lang::className(),
                'targetAttribute' => ['lang_id' => 'id'],
            ],
            [['is_active'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('core/attributes', 'id'),
            'menu_id'   => Yii::t('core/attributes', 'menu_id'),
            'lang_id'   => Yii::t('core/attributes', 'lang_id'),
            'title'     => Yii::t('core/attributes', 'title'),
            'link'      => Yii::t('core/attributes', 'link'),
            'order'     => Yii::t('core/attributes', 'order'),
            'parent_id' => Yii::t('core/attributes', 'parent_id'),
            'parent'    => Yii::t('core/attributes', 'parent'),
            'css_class' => Yii::t('core/attributes', 'css_class'),
            'target'    => Yii::t('core/attributes', 'target'),
            'is_active' => Yii::t('core/attributes', 'is_active'),
        ];
    }

    /**
     * Get menu
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * Get parent item
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuLink::className(), ['id' => 'parent_id']);
    }

    /**
     * Get child items
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(MenuLink::className(), ['parent_id' => 'id']);
    }

    /**
     * Get item language
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    public static function getLinkTargets()
    {
        return [
            '_self'  => Yii::t('core/attributes', 'current_tab'),
            '_blank' => Yii::t('core/attributes', 'new_tab'),
        ];
    }

    public function getTargetDescription()
    {
        return static::getLinkTargets()[$this->target];
    }
}
