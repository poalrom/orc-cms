<?php

/**
 * @var yii\web\View              $this
 * @var \common\models\pages\Page $page
 */

use common\components\WidgetParser;
use himiklab\thumbnail\EasyThumbnailImage;
use front\assets\editorial\GalleryAsset;

GalleryAsset::register($this);
?>
<section>
    <header class="main">
        <h1><?= $page->currentTranslation->title ?></h1>
    </header>

    <!-- Content -->
    <div class="row">
        <div class="12u gallery">
            <?= WidgetParser::parse($page->currentTranslation->content) ?>
        </div>
    </div>
    <div class="row">
        <?php foreach ($page->children as $i => $childPage): ?>
            <?php
            $normalSize = (($i + 1) % 4 === 0) ? '3u$' : '3u';
            $smallSize = (($i + 1) % 2 === 0) ? '6u$(small)' : '6u(small)';
            ?>
            <div class="<?= $normalSize ?> <?= $smallSize ?> 12u$(xsmall)">
                <a href="<?= $childPage->getUrl() ?>" class="no-link">
                    <?php if ($childPage->preview): ?>
                        <div class="image">
                            <?= EasyThumbnailImage::thumbnailImg(
                                '@webroot' . $childPage->preview,
                                426,
                                320
                            ) ?>
                        </div>
                    <?php else: ?>
                        <div class="image">
                            <img src="http://via.placeholder.com/426x320?text=Photo">
                        </div>
                    <?php endif ?>

                    <h3 class="align-center"><?= $childPage->currentTranslation->title ?></h3>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</section>