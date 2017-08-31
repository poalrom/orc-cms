<?php

namespace admin\models\core\ar;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin_menu_item".
 *
 * @property integer         $id Item ID
 * @property string          $route Route for [[Url::toRoute]] function
 * @property string          $title_category Translation category for title
 * @property string          $title Translation key for title
 * @property string          $permission Permission for visibility
 * @property string          $fa_icon FontAwesome icon
 * @property integer         $order Order number
 * @property integer         $parent_id Parent ID
 *
 * @property AdminMenuItem   $parent Parent admin menu item
 * @property AdminMenuItem[] $children Array of child menu items
 */
class AdminMenuItem extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route', 'title_category', 'title', 'fa_icon'], 'required'],
            [['parent_id', 'order'], 'integer'],
            [['route', 'title_category', 'title', 'fa_icon', 'permission'], 'string', 'max' => 255],
            [
                ['parent_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => AdminMenuItem::className(),
                'targetAttribute' => ['parent_id' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('core/attributes', 'id'),
            'route'          => Yii::t('core/attributes', 'route'),
            'title_category' => Yii::t('core/attributes', 'title_category'),
            'title'          => Yii::t('core/attributes', 'title'),
            'permission'     => Yii::t('core/attributes', 'permission'),
            'fa_icon'        => Yii::t('core/attributes', 'fa_icon'),
            'order'          => Yii::t('core/attributes', 'order'),
            'parent_id'      => Yii::t('core/attributes', 'parent_id'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(AdminMenuItem::className(), ['id' => 'parent_id'])
            ->inverseOf('children');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AdminMenuItem::className(), ['parent_id' => 'id'])->orderBy('order')
            ->inverseOf('parent');
    }
}
