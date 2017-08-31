<?php

namespace front\controllers\pages;

use common\models\pages\Page;
use front\controllers\BaseController;

/**
 * Front class for pages.
 *
 * @property \front\views\View $view
 *
 * @package app\controllers
 */
class PageController extends BaseController
{
    public function init()
    {
        parent::init();
        $this->setViewPath('@app/views/pages');
    }

    /**
     * Render page.
     *
     * @param Page $model Page model.
     *
     * @return string
     */
    public function actionIndex(Page $model)
    {
        $this->view->entity = $model;
        $this->view->title = empty($model->currentTranslation->meta_title) ? $model->currentTranslation->title : $model->currentTranslation->meta_title;
        $this->setMetaTags([
            'title'       => $this->view->title,
            'keywords'    => $model->currentTranslation->meta_keywords,
            'description' => $model->currentTranslation->meta_description,
        ]);
        $this->view->params['breadcrumbs'] = $model->getBreadcrumbs();

        return $this->render($model->template, [
            'page' => $model,
        ]);
    }

}
