<?php

namespace admin\helpers;

use admin\assets\core\RedactorAdminAsset;
use common\components\LanguageComponent;
use Yii;
use yii\base\Component;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * FormHelper
 *
 * @package admin\helpers
 */
class FormHelper extends Component
{

    /**
     * Register redactor plugin assets and return settings for redactor
     *
     * @param \yii\web\View $view
     *
     * @return array
     */
    public static function getRedactorSettings($view)
    {
        $defaultLang = LanguageComponent::getDefault();
        RedactorAdminAsset::register($view);

        return [
            'minHeight'        => 600,
            'lang'             => $defaultLang->url,
            'plugins'          => ['elfinderImage'],
            'elfinderImageUrl' => Url::to([
                'admin/file/manager',
                'filter'   => 'image',
                'callback' => 'load-redactor-image',
                'lang'     => $defaultLang->url,
            ]),
            "buttonsHide"      => ['image', 'file'],
        ];
    }

    /**
     * Submit button
     *
     * @param $model Model Main form model
     *
     * @return string
     */
    public static function submitButton($model)
    {
        if ($model->isNewRecord) {
            return Html::submitButton(Yii::t('core/buttons', 'create'), ['class' => 'btn btn-success']);
        }

        return Html::submitButton(Yii::t('core/buttons', 'update'), ['class' => 'btn btn-primary']);
    }

    /**
     * Print stylized checkbox
     *
     * @param ActiveForm   $form Form
     * @param ActiveRecord $model Model
     * @param string       $attrName Attribute name
     *
     * @return mixed
     */
    public static function checkbox($form, $model, $attrName)
    {
        return $form->field($model,
            $attrName)->checkbox(['labelOptions' => ['class' => 'btn btn-success row-aligned btn-block' . ($model->$attrName ? ' active' : '')]]);
    }

}