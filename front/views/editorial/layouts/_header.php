<?php
/**
 * @var \yii\web\View $this
 */
use yii\widgets\Breadcrumbs;

?>
<header id="header">
    <div class="breadcrumbs">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'],
            'itemTemplate' => "<li class='breadcrumbs__item'>{link}</li>",
            'activeItemTemplate' => '<li class="breadcrumbs__item breadcrumbs__item_active">{link}</li>'
        ]) ?>
    </div>
    <?= $this->render('_lang_switcher') ?>
</header>