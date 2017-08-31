<?php
/**
 * @var \front\views\View $this
 */
use yii\widgets\Menu as MenuWidget;
use common\models\core\ar\Menu;

?>
<div class="inner">
    <!-- Menu -->
    <nav id="menu">
        <header class="major">
            <h2>Menu</h2>
        </header>
        <?= MenuWidget::widget([
            'items'           => $this->getMenuItems(Menu::MAIN_MENU_ALIAS),
            'activateParents' => true,
        ]) ?>
    </nav>

    <!-- Footer -->
    <footer id="footer">
        <?= $this->render('_lang_switcher') ?>
        <p class="copyright">&copy; <?= date('Y') ?>.</p>
    </footer>

</div>