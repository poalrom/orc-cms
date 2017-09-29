<?php
/**
 * @var \yii\web\View $this
 */
use yii\widgets\Breadcrumbs;

?>
<header id="header">
    <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs']
    ]) ?>
    <?= $this->render('_lang_switcher') ?>
</header>