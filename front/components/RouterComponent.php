<?php

namespace front\components;

use common\models\core\ar\Redirect;
use common\components\LanguageComponent;
use common\models\core\ar\Route;
use Yii;
use yii\helpers\Inflector;
use yii\web\UrlManager;

/**
 * Route for front part of CMS
 *
 * @package app\components
 */
class RouterComponent extends UrlManager
{

    /**
     * @inheritdoc
     */
    public function parseRequest($request)
    {
        /**
         * If user try to migrate DB he see error, because DB does not have any table.
         * So we take to him access to webshell directly.
         */
        if (!$this->enableStrictParsing && preg_match('#^/webshell(.*)$#', $request->url) == 1) {
            return parent::parseRequest($request);
        }
        // If route was exists in redirector, then redirect
        /** @var Redirect $redirect */
        $redirect = Redirect::find()->where(['from' => $request->url])->one();
        if ($redirect) {
            Yii::$app->response->redirect($redirect->to, $redirect->status)->send();
            exit();
        }
        $parts = explode('/', $request->getPathInfo());
        // If first part is default language - throw 404 error
        if ($parts[0] == LanguageComponent::getCurrent()->url) {
            return false;
        }
        // If lang isn't set up, then set up default lang
        $language = LanguageComponent::getLangByUrl($parts[0]);
        if ($language === null) {
            LanguageComponent::setCurrent();
        } else {
            LanguageComponent::setCurrent($language);
            array_shift($parts);
        }

        // Save route parts to params
        Yii::$app->params['route'] = $parts;
        $alias = array_pop($parts);
        if ($alias === null) {
            $alias = '';
        }
        // Get entity object route
        $route = Route::find()->where('alias = :alias AND is_active = 1', ['alias' => $alias]);
        if (count(Yii::$app->params['route']) < 2) {
            $route = $route->andWhere(['parent_tree' => "0"])->one();
        } else {
            $likeExp = "%" . str_repeat('.%', count(Yii::$app->params['route']) - 2);
            $notLikeExp = $likeExp . '.%';
            $route = $route->andWhere('parent_tree LIKE "' . $likeExp . '"')
                ->andWhere('parent_tree NOT LIKE "' . $notLikeExp . '"')
                ->andWhere('parent_tree NOT LIKE "0"')
                ->one();
        }
        /** @var Route $route */
        if (is_null($route)) {
            if (!$this->enableStrictParsing) {
                return parent::parseRequest($request);
            }

            return false;
        }
        if ($route->element_id === null) {
            return [
                Inflector::variablize($route->module) . '/' . Inflector::variablize($route->controller) . '/' . $route->action,
                [],
            ];
        }
        $model = $route->item;
        // Check route using entity model
        if (count(Yii::$app->params['route']) === 0 || Yii::$app->params['route'][0] === '') {
            $isTrueLink = $model->checkUrl('');
        } else {
            $isTrueLink = $model->checkUrl(implode(DIRECTORY_SEPARATOR, Yii::$app->params['route']));
        }
        if ($isTrueLink) {
            return [
                Inflector::variablize($route->module) . '/' . Inflector::variablize($route->controller) . '/' . $route->action,
                ['model' => $model],
            ];
        }

        return false;
    }
}
