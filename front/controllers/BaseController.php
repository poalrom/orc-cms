<?php
namespace front\controllers;

use common\models\core\ar\Lang;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Base controller for all front controllers
 *
 * @package front\controllers
 */
abstract class BaseController extends Controller
{
    const SAVE_PREVIOUS_URL = true;

    /**
     * @var string Common template
     */
    public $layout = '@app/views/layouts/main';

    public function init()
    {
        parent::init();
        if (static::SAVE_PREVIOUS_URL) {
            Url::remember('', 'previous');
        }
    }

    /**
     * Function for SEO tags
     *
     * @param array $params SEO tags array. For example: ["keywords" => "My site"]
     */
    public function setMetaTags(array $params)
    {
        foreach ($params as $name => $content) {
            Yii::$app->view->registerMetaTag([
                'name'    => $name,
                'content' => $content,
            ]);
        };
    }
}
