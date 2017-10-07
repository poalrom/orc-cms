<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use front\assets\editorial\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">

    <div id="main">
        <div class="inner">
            <?= $this->render('_header') ?>
            <?= $content ?>
        </div>
    </div>

    <div id="sidebar">
        <?= $this->render('_sidebar') ?>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
