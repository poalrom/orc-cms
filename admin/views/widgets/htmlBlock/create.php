<?php

/**
 * @var \yii\web\View                                      $this
 * @var \common\widgets\models\htmlBlock\HtmlBlock         $block
 * @var \common\models\core\ar\Lang[]                      $languages
 * @var \common\widgets\models\htmlBlock\HtmlBlockSearch[] $translations
 */

$this->title = Yii::t('widgets/htmlBlock', 'title_create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('widgets/htmlBlock', 'title'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['activeRoute'] = 'core/widget/index';
?>
<div class="widget-html-block-create">

    <?php echo $this->render('_form', [
        'block'        => $block,
        'languages'    => $languages,
        'translations' => $translations,
    ]); ?>

</div>
