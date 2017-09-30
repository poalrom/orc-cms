<?php

namespace admin\controllers\core;

use admin\components\AdminAuthManager;
use admin\controllers\BaseController;
use admin\models\core\forms\LoginForm;
use Yii;
use yii\helpers\Url;

/**
 * Login and logout controller
 *
 * @package admin\controllers\corev
 */
class LoginController extends BaseController
{
    /**
     * Route to login page
     */
    const LOGIN_PAGE_ROUTE = 'core/login/index';

    /**
     * Route to logout page
     */
    const LOGOUT_PAGE_ROUTE = 'core/login/logout';

    /**
     * Route to forbidden page
     */
    const FORBIDDEN_PAGE_ROUTE = 'core/login/forbidden';

    /**
     * @inheritdoc
     */
    public $layout = "@admin/views/core/layouts/login";

    /**
     * @inheritdoc
     */
    public function permissions()
    {
        return [
            'index' => false,
            'forbidden' => false,
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can(AdminAuthManager::USE_ADMIN_PANEL_PERMISSION)) {
            return Yii::$app->response->redirect(Url::toRoute(MainController::MAIN_PAGE_ROUTE));
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::toRoute(MainController::MAIN_PAGE_ROUTE));
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Forbidden page. Render if user isn't allowed to use something
     *
     * @return string
     */
    public function actionForbidden()
    {
        return $this->render('forbidden');
    }

    /**
     * Logout page
     *
     * @return void
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->response->redirect(Url::toRoute('/admin/login'));
    }

}
