<?php

/**
 * @var \yii\web\View                                      $this
 * @var \common\widgets\models\htmlBlock\HtmlBlock         $block
 * @var \common\models\core\ar\Lang[]                      $languages
 * @var \common\widgets\models\htmlBlock\HtmlBlockSearch[] $translations
 */

$this->title = Yii::t('widgets/htmlBlock', 'title_update') . ': ' . $block->alias;
$this->params['breadcrumbs'][] = ['label' => Yii::t('widgets/htmlBlock', 'title'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $block->alias;
$this->params['activeRoute'] = 'core/widget/index';
?>
<div class="widget-html-block-update">

    <?php echo $this->render('_form', [
        'block'        => $block,
        'languages'    => $languages,
        'translations' => $translations,
    ]); ?>

</div>
