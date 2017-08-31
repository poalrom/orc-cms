<?php

namespace admin\controllers\pages;

use admin\controllers\BaseController;
use common\models\core\ar\Lang;
use common\models\core\ar\Route;
use common\models\pages\Page;
use common\models\pages\PageSearch;
use common\models\pages\PageTranslation;
use Yii;
use yii\base\Model;
use yii\web\Response;

/**
 * Page admin controller
 *
 * @package admin\controllers\pages
 */
class PageController extends BaseController
{
    /**
     * Route to pages actions
     */
    const PAGE_ROUTE = 'pages/page/<action>';

    /**
     * @inheritdoc
     */
    public function permissions()
    {
        return [
            'index' => 'pages.seeList',
            'create' => 'pages.create',
            'update' => 'pages.update',
            'delete' => 'pages.delete',
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('Page') as $key => $value) {
                $model = Page::findOrFail($key);
                $model->order = $value['order'];
                $model->save();
            }
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return [
                    'type' => 'success',
                    'message' => Yii::t('pages/messages', 'order_save_successfully'),
                ];
            }
        }
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Create page
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $page = new Page([
            'is_active' => true,
        ]);
        /** @var Lang[] $languages */
        $languages = Lang::find()->orderBy('is_default DESC')->all();
        $translations = [];
        foreach ($languages as $language) {
            $translations[$language->id] = new PageTranslation();
        }
        $route = new Route();
        if ($page->load(Yii::$app->request->post()) &&
            Model::loadMultiple($translations, Yii::$app->request->post()) &&
            $route->load(Yii::$app->request->post()) &&
            $page->fullSave($translations, $route)
        ) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'page' => $page,
                'languages' => $languages,
                'translations' => $translations,
                'route' => $route,
            ]);
        }
    }

    /**
     * Update page
     *
     * @param int $id Page ID
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $page = Page::findOrFail($id);
        /** @var Lang[] $languages */
        $languages = Lang::find()->orderBy('is_default DESC')->all();
        $translations = [];
        foreach ($languages as $language) {
            $translation = $page->translations[$language->id];
            if (!is_null($translation)) {
                $translations[$language->id] = $translation;
            } else {
                $translations[$language->id] = new PageTranslation();
            }
        }
        $route = $page->route;
        if (is_null($route)) {
            $route = new Route();
        }
        if ($page->load(Yii::$app->request->post()) &&
            Model::loadMultiple($translations, Yii::$app->request->post()) &&
            $route->load(Yii::$app->request->post()) &&
            $page->fullSave($translations, $route)
        ) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'page' => $page,
                'languages' => $languages,
                'translations' => $translations,
                'route' => $route,
            ]);
        }
    }

    /**
     * Delete page
     *
     * @param int $id Page ID
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        Page::findOrFail($id)->fullDelete();

        return $this->redirect(['index']);
    }

}
