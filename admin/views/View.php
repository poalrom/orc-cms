<?php

namespace admin\views;

use yii\web\View as BaseView;

class View extends BaseView
{

    public function init()
    {
        parent::init();
        $this->params['breadcrumbs'] = [];
        $this->params['user'] = \Yii::$app->user->identity;
        $this->params['isSidebarCollapsed'] = isset($_COOKIE['isSidebarCollapsed']) && ($_COOKIE['isSidebarCollapsed'] === 'true');
        $this->params['activeRoute'] = '';
    }
}