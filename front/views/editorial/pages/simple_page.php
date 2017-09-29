<?php

/**
 * @var yii\web\View              $this
 * @var \common\models\pages\Page $page
 */

use common\components\WidgetParser;

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
</section>