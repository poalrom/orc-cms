<?php
/**
 * @var \yii\web\View                          $this
 * @var \common\models\pages\Page              $page
 * @var \common\models\core\ar\Lang[]          $languages
 * @var \common\models\pages\PageTranslation[] $translations
 * @var \common\models\core\ar\Route           $route
 */

use admin\helpers\FileHelper;
use admin\helpers\FormHelper;
use common\models\pages\Page;
use mihaildev\elfinder\InputFile;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveForm;

?>
<div class="page-form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'translatable-form',
        ],
    ]) ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" id="translation_tabs" role="tablist">
            <?php foreach ($languages as $language): ?>
                <li role="presentation" <?= $language->is_default ? 'class="active"' : '' ?>>
                    <a href="#<?= $language->url ?>" aria-controls="<?= $language->url ?>" role="tab" data-toggle="tab">
                        <?= $language->title ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
        <div class="tab-content">
            <?php foreach ($languages as $key => $language): ?>
                <div role="tabpanel" class="tab-pane fade clearfix <?= $language->is_default ? 'in active' : '' ?>"
                     id="<?= $language['url'] ?>">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <?= $form->field($translations[$language->id],
                                '[' . $language->id . ']title')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <?= $form->field($translations[$language->id], '[' . $language->id . ']meta_title')
                                ->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <?= $form->field($translations[$language->id],
                                '[' . $language->id . ']meta_keywords')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <?= $form->field($translations[$language->id],
                                '[' . $language->id . ']meta_description')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?= $form->field($translations[$language->id],
                                '[' . $language->id . ']description')->textArea(['rows' => 6]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?= $form->field($translations[$language->id],
                                '[' . $language->id . ']content')->widget(Redactor::class, [
                                'clientOptions' => FormHelper::getRedactorSettings($this),
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <?= $form->field($route, 'alias')->textInput() ?>
            <?= $form->field($page, 'order')->textInput() ?>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <?= $form->field($page, 'template')->dropDownList(FileHelper::getTemplates('pages')) ?>
            <?= $form->field($page, 'items_per_page')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <?= $form->field($page, 'preview')->widget(InputFile::class, [
                'language'      => 'ru',
                'controller'    => 'admin/file',
                'buttonName'    => Yii::t('core/buttons', 'browse'),
                'filter'        => 'image',
                'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                'options'       => ['class' => 'form-control'],
                'buttonOptions' => ['class' => 'btn btn-default'],
                'multiple'      => false,
            ]) ?>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <?= $form->field($page, 'parent_id')->dropDownList(Page::getList(),
                ['prompt' => Yii::t('core/prompts', 'without_parent')]) ?>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <?= $form->field($page, 'is_active')->dropDownList([
                Yii::t('core/statuses', 'hidden'),
                Yii::t('core/statuses', 'active'),
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <?= FormHelper::submitButton($page) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
