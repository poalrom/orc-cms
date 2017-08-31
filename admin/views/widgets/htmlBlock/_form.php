<?php

/**
 * @var \yii\web\View                                      $this
 * @var \common\widgets\models\htmlBlock\HtmlBlock         $block
 * @var \common\models\core\ar\Lang[]                      $languages
 * @var \common\widgets\models\htmlBlock\HtmlBlockSearch[] $translations
 */

use admin\helpers\FormHelper;
use yii\widgets\ActiveForm;

?>
    <div class="widget-html-block-form">
        <?php $form = ActiveForm::begin() ?>
        <div>
            <ul class="nav nav-pills" id="translation_tabs" role="tablist">
                <?php foreach ($languages as $language): ?>
                    <li role="presentation" <?= $language->is_default ? 'class="active"' : '' ?>>
                        <a href="#<?= $language->url ?>" aria-controls="<?= $language->url ?>" role="tab"
                           data-toggle="tab">
                            <?= $language->title ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
            <div class="tab-content">
                <?php foreach ($languages as $language): ?>
                    <div role="tabpanel" class="tab-pane fade clearfix<?= $language->is_default ? ' in active' : ''; ?>"
                         id="<?= $language->url ?>">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?= $form->field($translations[$language->id],
                                    '[' . $language->id . ']content')->textArea([
                                    'rows'  => 20,
                                    'class' => 'acejs hidden',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <?= $form->field($block, 'alias')->textInput() ?>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <?= $form->field($block, 'is_active')->dropDownList([
                    Yii::t('core/statuses', 'hidden'),
                    Yii::t('core/statuses', 'active'),
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <?= FormHelper::submitButton($block) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php
$this->registerJsFile('js\acejs\emmet.core.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js\acejs\ace.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js\acejs\ext-emmet.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js\acejs\ext-language_tools.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$script = <<<JS
$('.acejs').each(function (index, el){
    var textarea = $(this);
    var div = document.createElement('div');
    div.id = textarea.context.id+'ace';
    textarea.after(div);
    var editor = ace.edit(div.id);
    editor.setTheme("ace/theme/textmate");
    editor.getSession().setMode("ace/mode/html");
    editor.getSession().setValue(textarea.val());
    editor.getSession().setOptions({
        wrap: true
    });
    editor.setOptions({
        enableBasicAutocompletion: true,
        enableEmmet: true,
        maxLines: 100,
        minLines: 25,
        fontSize: 15,
        behavioursEnabled: true,
        wrapBehavioursEnabled: true,
    });
    editor.getSession().on('change', function(){
        textarea.val(editor.getSession().getValue());
    });
    editor.\$blockScrolling = Infinity;
});
    
JS;
$this->registerJs($script);

?>