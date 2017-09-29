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
        <p class="copyright">
            &copy; Powered by <a href="https://github.com/poalrom/orc-cms">ORC.CMS</a>
            <?= date('Y') ?>
        </p>
    </footer>

</div>