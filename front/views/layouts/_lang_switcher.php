<?php
/**
 * @var \front\views\View $this
 */

use common\components\LanguageComponent;
use common\interfaces\core\TranslatableEntityInterface;

$showAllLanguages = false;
if (!($this->entity instanceof TranslatableEntityInterface)) {
    $showAllLanguages = true;
}
$allLanguages = LanguageComponent::getAll();
$enabledLanguages = [];
foreach ($allLanguages as $language) {
    if (
        $showAllLanguages ||
        (isset($this->entity->translations[$language->id]) && !$this->entity->translations[$language->id]->isEmpty())
    ) {
        array_push($enabledLanguages, $language);
    }
}
?>

<?php if (count($enabledLanguages) > 1): ?>
    <div class="lang-switcher">
        <?php foreach ($enabledLanguages as $i => $language): ?>
            <?php if ($i !== 0): ?>
                &nbsp;/&nbsp;
            <?php endif ?>
            <?php if ($language->isCurrent()): ?>
                <?= $language->title ?>
            <?php else: ?>
                <a href="<?= $language->is_default ? '' : '/' . $language->url ?>/<?= implode('/',
                    Yii::$app->params['route']) ?>">
                    <?= $language->title ?>
                </a>
            <?php endif ?>
        <?php endforeach ?>

    </div>
<?php endif ?>