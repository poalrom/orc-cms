<?php
/**
 * @var \yii\web\View                   $this
 * @var \common\models\core\ar\MenuLink $link
 * @var \common\models\core\ar\Menu     $menu
 */

$this->title = Yii::t('core/titles', 'create_menu_item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/titles', 'menu'), 'url' => ['core/menu/index']];
$this->params['breadcrumbs'][] = ['label' => $menu->title, 'url' => ['index', 'id' => $menu->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['activeRoute'] = 'core/menu/index';
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'link' => $link,
        'menu' => $menu,
    ]) ?>

</div>
