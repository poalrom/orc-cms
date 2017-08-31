<?php

namespace common\models\core\ar;

use common\validators\RegexpAliasValidator;
use Yii;
use yii\db\ActiveRecord;

/**
 * Route class
 *
 * @property int                                         $id Route ID
 * @property string                                      $alias Route alias
 * @property string                                      $module Entity module name
 * @property string                                      $model Entity AR model
 * @property string                                      $controller Entity front controller
 * @property string                                      $action Entity front controller action
 * @property int                                         $element_id Entity ID
 * @property string                                      $parent_tree Route parent tree
 * @property bool                                        $is_active Is route active
 * @property \front\interfaces\core\FrontEntityInterface $item Route item
 *
 * @property ActiveRecord                                $entity Entity model
 *
 * @package common\models\core\ar
 */
class Route extends EntityModel
{

    /**
     * @var string Full module classname
     */
    protected $moduleClass = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias'], RegexpAliasValidator::class,],
            [['alias'], 'validateAlias', 'skipOnEmpty' => false, 'skipOnError' => false],
            [['element_id'], 'integer'],
            [['alias', 'controller', 'model', 'action', 'module'], 'string', 'max' => 150],
            ['action', 'default', 'value' => 'index'],
            [['is_active'], 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * @return \common\modules\BaseModule
     */
    public function getModuleClass()
    {
        /** @var \common\modules\BaseModule $module */
        $module = "\common\modules\\$this->module";

        return $module;
    }

    /**
     * Alias validator
     *
     * @param string $attribute Attribute
     * @param array  $params Validation params
     */
    public function validateAlias($attribute, $params)
    {
        $moduleClass = $this->getModuleClass();

        if (!$moduleClass::canUrlBeEmpty() && strlen($this->alias) === 0) {
            $this->addError($attribute, Yii::t('core/errors', 'alias_cant_be_empty'));

            return;
        }

        if ($this->parent_tree == 0) {
            $itemsCount = static::find()->where(['parent_tree' => 0])
                ->andWhere('alias = :alias AND is_active = 1', ['alias' => $this->alias]);
        } else {
            $likeExp = "%" . str_repeat('.%', substr_count($this->parent_tree, '.'));
            $notLikeExp = $likeExp . ".%";
            $itemsCount = static::find()->where('parent_tree LIKE "' . $likeExp . '"')
                ->andWhere('parent_tree NOT LIKE "' . $notLikeExp . '"')
                ->andWhere('alias = :alias', ['alias' => $this->alias]);
        }

        if (!$this->isNewRecord) {
            $itemsCount = $itemsCount->andWhere('id != ' . $this->id);
        }
        if ($itemsCount->count() > 0) {
            $this->addError($attribute, Yii::t('core/errors', 'alias_must_be_unique'));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'alias' => Yii::t('core/attributes', 'alias'),
            'module' => Yii::t('core/attributes', 'module'),
            'model' => Yii::t('core/attributes', 'model'),
            'controller' => Yii::t('core/attributes', 'controller'),
            'element_id' => Yii::t('core/attributes', 'element_id'),
            'is_active' => Yii::t('core/attributes', 'is_active'),
        ];
    }

    /**
     * Relation to entity
     *
     * @return null|\yii\db\ActiveQuery
     */
    public function getItem()
    {
        if (!$this->module || !$this->controller) {
            return null;
        }

        return $this->hasOne($this->model, ['id' => 'element_id']);
    }

}
