<?php
/**
 * @var \yii\web\View               $this
 * @var MenuLink                    $link
 * @var \common\models\core\ar\Menu $menu
 */

use admin\helpers\FormHelper;
use common\models\core\ar\MenuLink;
use yii\widgets\ActiveForm;

?>
<div class="link-form">

    <?php $form = ActiveForm::begin([
        'id' => 'link-form',
    ]); ?>
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <?= $form->field($link, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12 col-lg-6">
            <?= $form->field($link, 'link')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-3">
            <?= $form->field($link, 'order')->textInput() ?>
        </div>
        <div class="col-sm-12 col-lg-3">
            <?= $form->field($link, 'parent_id')->dropDownList([
                    Yii::t('core/prompts', 'without_parent'),
                ] + $menu->getLinkList($link->lang_id, $link->id)
            ) ?>
        </div>
        <div class="col-sm-12 col-lg-3">
            <?= $form->field($link, 'css_class')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12 col-lg-3">
            <?= $form->field($link, 'target')->dropDownList(MenuLink::getLinkTargets()) ?>
        </div>
    </div>

    <?= $form->field($link, 'menu_id')->hiddenInput()->label(false) ?>
    <?= $form->field($link, 'lang_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= FormHelper::submitButton($link) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
