<?php

namespace admin\helpers;

use common\components\LanguageComponent;
use mihaildev\elfinder\ElFinder;
use Yii;
use yii\base\Component;
use yii\db\ActiveRecord;
use yii\helpers\Html;
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
     * @return array
     */
    public static function getCKEditorSettings()
    {
        $defaultLang = LanguageComponent::getDefault();

        return ElFinder::ckeditorOptions('admin/file', [
            'rows' => 20,
            'lang' => $defaultLang->url,
        ]);
    }

    /**
     * Submit button
     *
     * @param $model ActiveRecord Main form model
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