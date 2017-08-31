<?php
/**
 * @var \yii\web\View               $this
 * @var \common\models\core\ar\Lang $lang
 */
$this->title = Yii::t('core/titles', 'create_language');

$this->params['breadcrumbs'][] = ['label' => Yii::t('core/titles', 'languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['activeRoute'] = 'core/lang/index';
?>
<div>

    <?= $this->render('_form', [
        'lang' => $lang,
    ]) ?>

</div>
