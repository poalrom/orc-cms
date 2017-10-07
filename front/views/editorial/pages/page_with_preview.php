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
        <div class="12u$">
			<?php if($page->preview) : ?>
				<span class="image left">
					<?= EasyThumbnailImage::thumbnailImg(
						'@webroot' . $page->preview,
						426,
						320
					) ?>
				</span>
			<?php endif ?>
            <p>
                <em>
                    <?= $page->currentTranslation->description ?>
                </em>
            </p>
            <?= WidgetParser::parse($page->currentTranslation->content) ?>
        </div>
    </div>
</section>