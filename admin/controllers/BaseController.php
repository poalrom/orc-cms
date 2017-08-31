<?php

namespace admin\controllers;

use admin\components\AdminAuthManager;
use admin\controllers\core\LoginController;
use admin\helpers\MenuWidgetHelper;
use admin\models\core\ar\AdminMenuItem;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Base class for admin module controllers
 *
 * @package admin\controllers
 */
abstract class BaseController extends Controller
{
    /**
     * @var string Default template for admin panel
     */
    public $layout = '@admin/views/core/layouts/main';

    /**
     * Permissions for each action. For example:
     * <code>
     *   [
     *     'login' => false,
     *     'logout' => 'useAdminPanel'
     *   ]
     * </code>
     * If action key set to false, all users can go to this action.
     * If action key isn't exist, use default permission 'useAdminPanel'.
     *
     * @return array
     */
    public function permissions()
    {
        return [];
    }

    /**
     *  Redirect to forbidden page, if user isn't allowed to use this page. If user allowed, then save url to history
     *
     * @param \yii\base\Action $action
     *
     * @return bool|\yii\web\Response
     */
    public function beforeAction($action)
    {
        $permissions = $this->permissions();
        if (!isset($permissions[$action->id])) {
            $permission = AdminAuthManager::USE_ADMIN_PANEL_PERMISSION;
        } elseif ($permissions[$action->id] === false) {
            return true;
        } else {
            $permission = $permissions[$action->id];
        }

        if (!Yii::$app->getUser()->can($permission)) {
            Yii::$app->response->redirect(Url::toRoute(LoginController::LOGIN_PAGE_ROUTE))->send();
            return false;
        }

        if (Url::previous('current') !== Url::to()) {
            Url::remember(Url::previous('current'), 'previous');
            Url::remember('', 'current');
        }

        $this->view->params['activeRoute'] = $this->route;

        $this->initMenu();

        return true;
    }

    protected function initMenu()
    {
        $menuItems = AdminMenuItem::find()->alias('mi')
            ->orderBy('order')
            ->where(['mi.parent_id' => null])
            ->joinWith('children c')
            ->all();

        $this->view->params['menuItems'] = MenuWidgetHelper::menuArrayToItems($menuItems);
    }

    /**
     * Action for main module page
     *
     * @return string
     */
    abstract public function actionIndex();

}
