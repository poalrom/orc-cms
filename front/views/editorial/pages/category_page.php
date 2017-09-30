<?php

/**
 * @var yii\web\View              $this
 * @var \common\models\pages\Page $page
 */

use common\components\WidgetParser;
use himiklab\thumbnail\EasyThumbnailImage;

?>
<section>
    <header class="main">
        <h1><?= $page->currentTranslation->title ?></h1>
    </header>

    <!-- Content -->
    <div class="row">
        <div class="12u">
            <?= WidgetParser::parse($page->currentTranslation->content) ?>
        </div>
    </div>
    <div class="row">
        <?php foreach ($page->children as $i => $childPage): ?>
            <?php if ($i % 4 === 0): ?>
                <div class="row">
            <?php endif ?>
            <div class="3u">
                <a href="<?= $childPage->getUrl() ?>" class="no-link">
                    <?php if ($childPage->preview): ?>
                        <div class="image">
                            <?= EasyThumbnailImage::thumbnailImg(
                                '@webroot' . $childPage->preview,
                                280,
                                210
                            ) ?>
                        </div>
                    <?php else: ?>
                        <div class="image">
                            <img src="http://via.placeholder.com/280x210?text=Men">
                        </div>
                    <?php endif ?>

                    <h3 class="align-center"><?= $childPage->currentTranslation->title ?></h3>
                    <p><?= $childPage->currentTranslation->description ?></p>
                </a>
            </div>
            <?php if (($i + 1) % 4 === 0): ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</section>