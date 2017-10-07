<?php
/**
 * @var \front\views\View $this
 */

use common\models\core\ar\Menu;
use himiklab\thumbnail\EasyThumbnailImage;
use yii\widgets\Menu as MenuWidget;

?>
<div class="inner">
    <!-- Menu -->
    <nav id="menu">
        <header class="major image">
            <a href="/" class="logo-image">
                <?= EasyThumbnailImage::thumbnailImg(
                    '@webroot/uploads/logo.jpg',
                    273,
                    213,
                    EasyThumbnailImage::THUMBNAIL_OUTBOUND
                ) ?>
            </a>
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