<?php

namespace common\models\core\ar;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Widget AR model
 *
 * @property int    $id Widget ID
 * @property string $alias Widget alias
 * @property string $admin_controller Main admin controller classname
 * @property string $front_controller Main front controller classname
 * @package app\models
 */
class Widget extends EntityModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'admin_controller', 'front_controller'], 'string', 'max' => 100],
            [['alias', 'admin_controller', 'front_controller'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('core/attributes', 'id'),
            'title' => Yii::t('core/attributes', 'title'),
            'alias' => Yii::t('core/attributes', 'alias'),
        ];
    }

    /**
     * Install widget
     *
     * @return bool
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function install()
    {
        /** @var \admin\controllers\widgets\BaseController $class */
        $class = $this->admin_controller;
        if (!class_exists($class)) {
            throw new NotFoundHttpException(Yii::t('core/errors', 'class_not_found'));
        }
        $classInfo = $class::info();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($class::install()) {
                $this->alias = $classInfo['alias'];
                $this->front_controller = $classInfo['front_controller'];
                if ($this->validate() && $this->save()) {
                    $permission = Yii::$app->authManager->createPermission('widget.use.' . $this->alias);
                    $permission->description = '[widget]' . $classInfo['title'];
                    Yii::$app->authManager->add($permission);
                    $adminRole = Yii::$app->authManager->getRole('superAdmin');
                    Yii::$app->authManager->addChild($adminRole, $permission);
                    $transaction->commit();

                    return true;
                }
                throw new \DomainException(Yii::t('core/errors', 'cant_install_widget'));
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        throw new \DomainException(Yii::t('core/errors', 'cant_install_widget'));
    }

    /**
     * Uninstall widget
     *
     * @return bool
     * @throws \Exception
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function uninstall()
    {
        /** @var \admin\controllers\widgets\BaseController $class */
        $class = $this->admin_controller;
        if (!class_exists($class)) {
            throw new NotFoundHttpException(Yii::t('core/errors', 'class_not_found'));
        }
        $classInfo = $class::info();
        if (!Yii::$app->user->can('widget.use.' . $classInfo['alias'])) {
            throw new ForbiddenHttpException();
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($class::uninstall() && $this->delete()) {
                $permission = Yii::$app->authManager->getPermission('widget.use.' . $classInfo['alias']);
                $adminRole = Yii::$app->authManager->getRole('superAdmin');
                Yii::$app->authManager->removeChild($adminRole, $permission);
                Yii::$app->authManager->remove($permission);

                $transaction->commit();

                return true;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        throw new \DomainException(Yii::t('core/errors', 'cant_uninstall_widget'));
    }

}