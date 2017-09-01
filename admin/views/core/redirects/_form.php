<?php
/**
 * @var \yii\web\View                   $this
 * @var \common\models\core\ar\Redirect $redirect
 */
use admin\helpers\FormHelper;
use yii\widgets\ActiveForm;
use common\models\core\ar\Redirect;

?>

<div class="redirect-form">

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-xs-12 col-md-6">
            <?= $form->field($redirect, 'from')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-xs-12 col-md-6">
            <?= $form->field($redirect, 'status')->dropDownList(Redirect::getList()) ?>
        </div>

        <div class="col-xs-12">
            <?= $form->field($redirect, 'to')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <?= FormHelper::submitButton($redirect) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
