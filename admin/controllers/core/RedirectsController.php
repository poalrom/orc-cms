<?php

namespace admin\controllers\core;

use admin\controllers\BaseController;
use common\models\core\ar\Redirect;
use common\models\core\ar\RedirectSearch;
use Yii;

/**
 * Admin redirect controller
 *
 * @package admin\controllers\core
 */
class RedirectsController extends BaseController
{

    /**
     * Route to language actions
     */
    const REDIRECT_ROUTE = 'core/redirects/<action>';

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel = new RedirectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create redirect action
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $redirect = new Redirect([
            'status' => 302
        ]);

        if ($redirect->load(Yii::$app->request->post()) && $redirect->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'redirect' => $redirect,
            ]);
        }
    }

    /**
     * Update redirect action
     *
     * @param integer $id Redirect ID
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $redirect = Redirect::findOrFail($id);

        if ($redirect->load(Yii::$app->request->post()) && $redirect->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'redirect' => $redirect,
            ]);
        }
    }

    /**
     * Delete redirect action
     *
     * @param integer $id Redirect ID
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        Redirect::findOrFail($id)->delete();

        return $this->redirect(['index']);
    }

}
