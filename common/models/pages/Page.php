<?php

namespace common\models\pages;

use admin\interfaces\core\AdminEntityInterface;
use common\components\LanguageComponent;
use common\interfaces\core\TranslatableEntityInterface;
use common\models\core\ar\EntityModel;
use common\models\core\ar\Route;
use common\modules\Pages as MainModule;
use common\traits\EntityBreadcrumbs;
use common\traits\EntityTranslations;
use common\traits\ModelFindOrFail;
use common\traits\ModelGetList;
use front\interfaces\core\FrontEntityInterface;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * Page AR model.
 *
 * @property int               $id Page ID
 * @property int               $parent_id Parent ID. 0 if there is no parent
 * @property string            $preview Page preview URL
 * @property int               $is_active Is page active
 * @property string            $template Template path
 * @property int               $items_per_page Children per page
 * @property int               $created_at Date create
 * @property int               $updated_at Date update
 * @property int               $order Sort order
 *
 * @property Page              $parent Parent page model. NULL if there is no parent
 * @property Page[]            $children Child pages
 * @property PageTranslation   $currentTranslation Page translation for current language
 * @property PageTranslation   $defaultTranslation Page translation for default language
 * @property PageTranslation[] $translations Page translations for all language
 *
 * @package common\models\pages
 */
class Page extends EntityModel implements TranslatableEntityInterface, AdminEntityInterface, FrontEntityInterface
{
    use EntityBreadcrumbs;
    use ModelFindOrFail;
    use EntityTranslations;
    use ModelGetList;

    /**
     * @var Route[]|null Cache for parent route tree
     */
    private $_parentTree = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_active', 'items_per_page', 'order'], 'integer'],
            [['preview'], 'string', 'max' => 400],
            [['template'], 'string', 'max' => 100],
            [['created_at', 'updated_at'], 'safe'],
            [['is_active'], 'boolean'],
            ['items_per_page', 'default', 'value' => MainModule::DEFAULT_ITEMS_PER_PAGE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('pages/attributes', 'id'),
            'parent_id'      => Yii::t('pages/attributes', 'parent_id'),
            'preview'        => Yii::t('pages/attributes', 'preview'),
            'alias'          => Yii::t('pages/attributes', 'alias'),
            'title'          => Yii::t('pages/attributes', 'title'),
            'template'       => Yii::t('pages/attributes', 'template'),
            'is_active'      => Yii::t('pages/attributes', 'is_active'),
            'items_per_page' => Yii::t('pages/attributes', 'items_per_page'),
            'created_at'     => Yii::t('pages/attributes', 'created_at'),
            'updated_at'     => Yii::t('pages/attributes', 'updated_at'),
            'order'          => Yii::t('pages/attributes', 'order'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getTranslationClassname()
    {
        return PageTranslation::className();
    }

    /**
     * @inheritdoc
     */
    public function checkUrl($srcLink)
    {
        if (!$this->is_active) {
            return false;
        }
        $fullRoute = $this->getUrl();

        return (($fullRoute === $srcLink) || ($fullRoute === '/' . $srcLink)) && !$this->currentTranslation->isEmpty();
    }

    /**
     * @inheritdoc
     */
    public function getUrl($withLang = false)
    {
        if ($this->route->parent_tree == 0) {
            return '/' . $this->route->alias;
        }
        $tree = explode('.', $this->route->parent_tree);
        $tree_routes = static::getParentTree();
        $link = '';
        foreach ($tree as $item) {
            $link .= $tree_routes[$item]->alias . '/';
        }

        if ($withLang) {
            $link = LanguageComponent::getCurrent()->getUrlPart() . $link;
        }

        return '/' . $link . $this->route->alias;
    }

    /**
     * @inheritdoc
     */
    public function getParentTree()
    {
        if (is_null($this->_parentTree)) {
            $tree = explode('.', $this->route->parent_tree);
            $this->_parentTree = Route::find()->where(['in', 'element_id', $tree])
                ->andWhere([
                    'module'     => MainModule::getModuleName(),
                    'controller' => MainModule::getMainFrontControllerName(),
                ])
                ->orderBy('parent_tree')
                ->indexBy('element_id')
                ->all();
            if (!$this->_parentTree) {
                $this->_parentTree = [];
            }
        }

        return $this->_parentTree;
    }

    /**
     * @inheritdoc
     */
    public function fullSave(&$translations, &$route, &$params = [])
    {
        if ($this->validate() &&
            Model::validateMultiple($translations)
        ) {
            $route->module = MainModule::getModuleName();
            $route->controller = MainModule::getMainFrontControllerName();
            $route->model = MainModule::getModelName();
            if ($this->parent_id == 0) {
                $parentTree = 0;
            } else {
                if ($this->isNewRecord || $this->isAttributeChanged('parent_id')) {
                    $parent = Yii::$app->db
                        ->createCommand(
                            <<<MYSQL
SELECT p.id AS id, r.parent_tree AS tree FROM page AS p
LEFT JOIN route AS r ON p.id = r.element_id WHERE r.module = :module AND r.controller = :controller AND p.id = :parent_id
MYSQL
                        )
                        ->bindValues([
                            ':parent_id'  => $this->parent_id,
                            ':module'     => $route->module,
                            ':controller' => $route->controller,
                        ])
                        ->queryOne();
                    $parentTree = $parent['tree'] ? $parent['tree'] . '.' . $parent['id'] : $parent['id'];
                } else {
                    $parentTree = $route->parent_tree;
                }
            }
            $parentTreeOld = $route->parent_tree;
            $route->parent_tree = $parentTree;
            if (!$route->validate()) {
                return false;
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$this->isNewRecord && $this->isAttributeChanged('parent_id')) {
                    if ($parentTree == 0) {
                        $old_parent_tree = $parentTreeOld . '.' . $this->id;
                        $new_parent_tree = $this->id;
                    } else {
                        $old_parent_tree = $parentTreeOld . '.' . $this->id;
                        $new_parent_tree = $parentTree . '.' . $this->id;
                    }
                    Yii::$app->db
                        ->createCommand(<<<MYSQL
UPDATE route SET parent_tree = REPLACE(parent_tree, :old_parent_tree, :new_parent_tree)  WHERE module = :module AND controller = :controller
MYSQL
                        )
                        ->bindValues([
                            ':old_parent_tree' => $old_parent_tree,
                            ':new_parent_tree' => $new_parent_tree,
                            ':module'          => $route->module,
                            ':controller'      => $route->controller,
                        ])
                        ->execute();
                }
                $this->save(false);
                $route->element_id = $this->id;
                $route->save(false);
                foreach ($translations as $key => $translation) {
                    $translation->page_id = $this->id;
                    $translation->lang_id = $key;
                    $translation->save(false);
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function fullDelete()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->route->parent_tree == 0) {
                $old_parent_tree = $this->id;
            } else {
                $old_parent_tree = $this->route->parent_tree . '.' . $this->id;
            }
            Yii::$app->db
                ->createCommand(<<<MYSQL
UPDATE route SET parent_tree = REPLACE(parent_tree, :old_parent_tree, '0') WHERE module = :module AND controller = :controller
MYSQL
                )
                ->bindValues([
                    ':old_parent_tree' => $old_parent_tree,
                    ':module'          => $this->route->module,
                    ':controller'      => $this->route->controller,
                ])
                ->execute();
            $this->route->delete();
            $this->delete();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * Parent tree query.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(static::className(), ['id' => 'parent_id']);
    }

    /**
     * Child models ordered by 'order'.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(static::className(), ['parent_id' => 'id'])
            ->orderBy(['order' => SORT_ASC, 'id' => SORT_ASC]);
    }

    /**
     * Active child models ordered by 'order'.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActiveChildren()
    {
        return $this->hasMany(static::className(), ['parent_id' => 'id', 'is_active' => true])
            ->orderBy('order DESC');
    }

    /**
     * @inheritdoc
     */
    public function getRoute()
    {
        return $this->hasOne(Route::className(), ['element_id' => 'id'])->where([
            'module'     => MainModule::getModuleName(),
            'controller' => MainModule::getMainFrontControllerName(),
        ]);
    }

}
