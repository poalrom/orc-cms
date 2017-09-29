<?php

namespace admin\controllers\core;

use admin\controllers\BaseController;
use common\models\core\ar\Lang;
use common\models\core\ar\Menu;
use common\models\core\ar\MenuLink;
use common\models\core\ar\MenuLinkSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Admin class for front menu items
 *
 * @package admin\controllers\core
 */
class MenuLinkController extends BaseController
{
    /**
     * Route to menu item actions
     */
    const MENU_ITEM_ROUTE = 'core/menu-link/<action>';

    /**
     * @inheritdoc
     */
    public function permissions()
    {
        return [
            'index' => 'menuItem.seeList',
            'create' => 'menuItem.create',
            'update' => 'menuItem.update',
            'delete' => 'menuItem.delete',
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        $menu = Menu::findOne($id);
        if (Yii::$app->request->isPost) {
            $menuLinks = Yii::$app->request->post('MenuLink', []);
            foreach ($menuLinks as $key => $value) {
                $model = MenuLink::findOrFail($key);
                $model->order = $value['order'];
                $model->save();
            }
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return [
                    'orders' => ArrayHelper::map(
                        MenuLink::find()->where(['id' => array_keys($menuLinks)])->all(),
                        'id',
                        'order'
                    ),
                    'type' => 'success',
                    'message' => Yii::t('core/messages', 'order_save_successfully'),
                ];
            }
        }
        /** @var Lang[] $languages */
        $languages = Lang::find()->orderBy('is_default DESC')->all();
        $links = [];
        foreach ($languages as $language) {
            $searchModel = new MenuLinkSearch();
            $links[$language->id]['searchModel'] = $searchModel;
            $links[$language->id]['dataProvider'] = $searchModel->search(Yii::$app->request->get(), $language->id,
                $menu->id);
        }

        return $this->render('index', [
            'menu' => $menu,
            'links' => $links,
            'languages' => $languages,
        ]);
    }

    /**
     * Create menu item
     *
     * @param int $lang_id Language ID
     * @param int $menu_id Menu ID
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate($lang_id, $menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $link = new MenuLink([
            'lang_id' => $lang_id,
            'menu_id' => $menu_id,
        ]);
        if ($link->load(Yii::$app->request->post()) && $link->save()) {
            return $this->redirect(['index', 'id' => $link->menu_id]);
        } else {
            return $this->render('create', [
                'link' => $link,
                'menu' => $menu,
            ]);
        }
    }

    /**
     * Update menu item
     *
     * @param int $id Menu item ID
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $link = MenuLink::findOrFail($id);
        $menu = $link->menu;
        if ($link->load(Yii::$app->request->post()) && $link->save()) {
            return $this->redirect(['index', 'id' => $link->menu_id]);
        } else {
            return $this->render('update', [
                'link' => $link,
                'menu' => $menu,
            ]);
        }
    }

    /**
     * Delete menu item and redirect to items list
     *
     * @param int $id Menu item ID
     *
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $link = MenuLink::findOrFail($id);
        $link->delete();

        return $this->redirect(['index', 'id' => $link->menu_id]);
    }

}
