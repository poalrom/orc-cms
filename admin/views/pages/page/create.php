<?php
/**
 * @var \yii\web\View                          $this
 * @var \common\models\pages\Page              $page
 * @var \common\models\core\ar\Lang[]          $languages
 * @var \common\models\pages\PageTranslation[] $translations
 * @var \common\models\core\ar\Route           $route
 */

$this->title = Yii::t('pages/titles', 'create_page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('pages/titles', 'pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['activeRoute'] = 'pages/page/index';
?>
<div class="page-create">

    <?php echo $this->render('_form', [
        'page'     => $page,
        'languages'    => $languages,
        'translations' => $translations,
        'route'        => $route,
    ]); ?>

</div>
