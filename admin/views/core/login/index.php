<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \yii\web\View                      $this
 * @var \admin\models\core\forms\LoginForm $model
 */

$this->title = Yii::t('core/titles', 'login_page');

$fieldTemplate = <<<HTML
<div class="form-group has-feedback">
    {input}
    {error}
</div>
HTML;

$configForm = [
    'id'          => 'login-form',
    'fieldConfig' => [
        'template' => $fieldTemplate,
    ],
];
?>
<div class="login-box">

    <div class="login-logo">
        <a href="/"><b>ORC.</b>CMS</a>
    </div>
    <div class="login-box-body">
        <?php $form = ActiveForm::begin($configForm); ?>

        <?= $form->field($model, 'username')->textInput([
            'placeholder' => $model->getAttributeLabel('username'),
        ]); ?>
        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => $model->getAttributeLabel('password'),
        ]); ?>
        <?= $form->field($model, 'rememberMe')->checkBox(); ?>
        <div class="form-group">
            <div class="col-xs-12">
                <?php echo Html::submitButton(
                    $this->title,
                    [
                        'class' => 'btn btn-primary btn-block btn-flat',
                        'name'  => 'login-button',
                    ]
                ); ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>