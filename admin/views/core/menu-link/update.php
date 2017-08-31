<?php
/**
 * @var \yii\web\View                   $this
 * @var \common\models\core\ar\MenuLink $link
 */

$this->title = Yii::t('core/titles', 'update_menu_item') . ': ' . $link->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/titles', 'menu'), 'url' => ['core/menu/index']];
$this->params['breadcrumbs'][] = ['label' => $link->menu->title, 'url' => ['index', 'id' => $link->menu->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['activeRoute'] = 'core/menu/index';

?>
<div class="menu-create">

    <?= $this->render('_form', [
        'link' => $link,
    ]) ?>

</div>