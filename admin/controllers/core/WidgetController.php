<?php

namespace admin\controllers\core;

use admin\controllers\BaseController;
use admin\helpers\FileHelper;
use common\helpers\ClassNameHelper;
use common\models\core\ar\Widget;
use Yii;
use yii\base\ErrorException;
use yii\web\NotFoundHttpException;

/**
 * Main widget class for admin panel.
 *
 * @package app\controllers\admin
 */
class WidgetController extends BaseController
{

    /**
     * Route to language actions
     */
    const WIDGET_ROUTE = 'core/widget/<action>';

    /**
     * Route to language actions
     */
    const WIDGET_ITEM_ROUTE = 'core/widgets/<widget_name>/<controller>/<action>';

    /**
     * @inheritdoc
     */
    public function permissions()
    {
        return [
            'index'     => 'widget.seeList',
            'install'   => 'widget.install',
            'uninstall' => 'widget.uninstall',
        ];
    }

    /**
     * Render table of all widgets.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dir = Yii::getAlias('@admin/controllers/widgets');
        $aliases = [];
        $widgetsInfo = [];
        $errors = [];
        if (is_dir($dir)) {
            $widgets = FileHelper::findFiles($dir, [
                'recursive' => true,
                'except'    => [
                    'BaseController.php',
                ],
            ]);
            foreach ($widgets as $widget) {
                /** @var \admin\controllers\widgets\BaseController $fullClass */
                $fullClass = ClassNameHelper::getFullClassFromPath($widget);
                if (!class_exists($fullClass) || !$fullClass::WIDGET) {
                    continue;
                }
                $classInfo = $fullClass::info();
                if (is_array($classInfo)) {
                    $widgetsInfo[] = $classInfo;
                    $aliases[] = $classInfo['alias'];
                }
            }
            if (!count($widgetsInfo)) {
                $errors[] = Yii::t('core/errors', 'widgets_not_found');
            } else {
                ksort($widgetsInfo);
            }
        } else {
            $errors[] = Yii::t('core/errors', 'widgets_directory_not_found');
        }
        $installedWidgets = Widget::find()->where(['alias' => $aliases])->indexBy('alias')->asArray()->all();

        return $this->render('index', [
            'widgets'          => $widgetsInfo,
            'installedWidgets' => $installedWidgets,
            'errors'           => $errors,
        ]);
    }

    /**
     * Install widget.
     *
     * @param \admin\controllers\widgets\BaseController $class Widget class.
     *
     * @return \yii\web\Response
     * @throws \Exception
     * @throws ErrorException
     * @throws NotFoundHttpException
     */
    public function actionInstall($class)
    {
        $model = new Widget([
            'admin_controller' => $class,
        ]);
        $model->install();

        return $this->redirect('index');
    }

    /**
     * Uninstall widget.
     *
     * @param \admin\controllers\widgets\BaseController $class Widget class.
     *
     * @return \yii\web\Response
     * @throws ErrorException
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUninstall($class)
    {
        $model = $this->findByClass($class);
        $model->uninstall();

        return $this->redirect('index');
    }

    /**
     * Find widget model by classname.
     *
     * @param string $class
     *
     * @return Widget
     * @throws NotFoundHttpException
     */
    protected function findByClass($class)
    {
        if (($model = Widget::findOne(['admin_controller' => $class])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }

}
