<?php
/**
 * @var \yii\web\View               $this
 * @var \common\models\core\ar\Lang $lang
 */

use admin\helpers\FormHelper;
use yii\widgets\ActiveForm;

?>

<div class="lang-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($lang, 'url')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($lang, 'local')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($lang, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 btn-group translatable-field" data-toggle="buttons">
            <?= $form->field($lang, 'is_default')->checkbox([
                'labelOptions' => [
                    'class' => 'btn btn-success row-aligned btn-block' . ($lang->is_default ? ' active' : ''),
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= FormHelper::submitButton($lang) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
