<?php

namespace admin\controllers\core;

use admin\controllers\BaseController;
use yii\web\ErrorAction;

/**
 * Index page for admin panel
 *
 * @package admin\controllers\core
 */
class MainController extends BaseController
{

    /**
     * Route to main admin panel page
     */
    const MAIN_PAGE_ROUTE = 'core/main/index';

    /**
     * Route to error admin panel page
     */
    const ERROR_ROUTE = 'core/main/error';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => ErrorAction::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
