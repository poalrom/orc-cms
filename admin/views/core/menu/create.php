<?php
/**
 * @var \yii\web\View               $this
 * @var \common\models\core\ar\Menu $menu
 */

$this->title = Yii::t('core/titles', 'create_menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/titles', 'menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['activeRoute'] = 'core/menu/index';
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'menu' => $menu,
    ]) ?>

</div>
