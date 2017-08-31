<?php
/**
 * @var \yii\web\View               $this
 * @var \common\models\core\ar\Menu $menu
 */
use admin\helpers\FormHelper;
use yii\widgets\ActiveForm;

?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <?php echo $form->field($menu, 'alias')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-sm-12 col-lg-6">
            <?php echo $form->field($menu, 'title')->textInput(['maxlength' => true]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <?= FormHelper::submitButton($menu) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
