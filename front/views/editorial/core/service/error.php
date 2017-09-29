<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Yii::t('core/titles', 'error');
?>

<section>
    <header class="main">
        <h1><?= Html::encode($name) ?></h1>
    </header>

    <!-- Content -->
    <div class="row">
        <div class="12u">
            <?= nl2br(Html::encode($message)) ?>
        </div>
    </div>
</section>