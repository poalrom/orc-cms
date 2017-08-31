<?php

namespace admin\controllers\core;

use admin\controllers\BaseController;
use common\models\core\ar\Menu;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;

/**
 * Admin controller for front menu
 *
 * @package admin\controllers\core
 */
class MenuController extends BaseController
{
    /**
     * Route to menu actions
     */
    const MENU_ROUTE = 'core/menu/<action>';

    /**
     * @inheritdoc
     */
    public function permissions()
    {
        return [
            'index'  => 'menu.seeList',
            'create' => 'menu.create',
            'update' => 'menu.update',
            'delete' => 'menu.delete',
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create menu action
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $menu = new Menu();
        if ($menu->load(Yii::$app->request->post()) && $menu->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'menu' => $menu,
            ]);
        }
    }

    /**
     * Update menu action
     *
     * @param int $id Menu ID
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->alias === Menu::MAIN_MENU_ALIAS) {
            throw new ForbiddenHttpException();
        }
        if ($menu->load(Yii::$app->request->post()) && $menu->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'menu' => $menu,
            ]);
        }
    }

    /**
     * Delete menu and redirect to menu list
     *
     * @param int $id Menu ID.
     *
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->alias === Menu::MAIN_MENU_ALIAS) {
            throw new ForbiddenHttpException();
        }
        $menu->delete();

        return $this->redirect(['index']);
    }
}
