<?php
/**
 * @var \yii\web\View                   $this
 * @var \common\models\core\ar\Redirect $redirect
 */

$this->title = Yii::t('core/titles', 'update_redirect') . ' #' . $redirect->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/titles', 'redirects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['activeRoute'] = 'core/redirects/index';
?>
<div class="redirect-update">

    <?= $this->render('_form', [
        'redirect' => $redirect,
    ]) ?>

</div>
