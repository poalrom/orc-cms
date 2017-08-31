<?php

namespace admin\controllers\widgets;

use admin\controllers\BaseController as AdminBaseController;
use Yii;

/**
 * Abstract class for all admin parts of widgets.
 *
 * @package admin\controllers\widgets
 */
abstract class BaseController extends AdminBaseController
{
    /**
     * Is this a widget controller?
     */
    const WIDGET = true;
    /**
     * Widgets directory
     */
    const WIDGET_DIR = '@admin/widgets';

    /**
     * @inheritdoc
     */
    public static function userCan()
    {
        return Yii::$app->user->can('use-widget-' . static::info()['alias']);
    }

    /**
     * @inheritdoc
     * Add breadcrumb when init.
     */
    public function init()
    {
        parent::init();
        $this->view->params['breadcrumbs'][] = [
            'url'   => '/admin/widgets/widget/index',
            'label' => Yii::t('core/titles', 'widgets'),
        ];
    }

    /**
     * Widget info.
     *
     * @return array Widget info. Contain alias, title, version and classname.
     */
    abstract public static function info();

    /**
     * Install widgets. Method should return bool value.
     *
     * @return bool
     */
    abstract public static function install();

    /**
     * Uninstall widgets. Method should return bool value.
     *
     * @return bool
     */
    abstract public static function uninstall();

    /**
     * Get classname for widget aggregator.
     *
     * @return string
     */
    public static function getClassNameWithModule()
    {
        return str_replace(static::WIDGET_DIR, '', static::className());
    }

}