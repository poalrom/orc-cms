<?php

namespace admin\controllers\core;

use admin\controllers\BaseController;
use admin\models\core\ar\LangSearch;
use common\models\core\ar\Lang;
use Yii;
use yii\web\BadRequestHttpException;

/**
 * Admin controller for front languages
 *
 * @package admin\controllers\core
 */
class LangController extends BaseController
{
    /**
     * Route to language actions
     */
    const LANG_ROUTE = 'core/lang/<action>';

    /**
     * @inheritdoc
     */
    public function permissions()
    {
        return [
            'index' => 'languages.seeList',
            'create' => 'languages.create',
            'update' => 'languages.update',
            'delete' => 'languages.delete',
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel = new LangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create language
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $lang = new Lang();

        if ($lang->load(Yii::$app->request->post()) && $lang->fullSave()) {

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'lang' => $lang,
        ]);
    }

    /**
     * Update language
     *
     * @param int $id Language ID
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $lang = Lang::findOrFail($id);

        if ($lang->load(Yii::$app->request->post()) && $lang->fullSave()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'lang' => $lang,
        ]);
    }

    /**
     * Delete language
     *
     * @param int $id Language ID
     *
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        if (Lang::find()->count() == 1) {
            throw new BadRequestHttpException("If you delete last language, you can't use CMS");
        }
        $model = Lang::findOrFail($id);
        $model->fullDelete();

        return $this->redirect(['index']);
    }

}
