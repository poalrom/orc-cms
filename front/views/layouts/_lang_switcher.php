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
    <ul class="icons lang-switcher">
        <?php foreach ($enabledLanguages as $i => $language): ?>
            <?php if ($language->isCurrent()): ?>
                <li class="lang_selected">
                    <span class="flag-icon flag-icon-<?= $language->icon ?>"></span>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?= $language->is_default ? '' : '/' . $language->url ?>/<?= implode('/',
                        Yii::$app->params['route']) ?>">
                        <span class="flag-icon flag-icon-<?= $language->icon ?>"></span>
                    </a>
                </li>
            <?php endif ?>
        <?php endforeach ?>
    </ul>
<?php endif ?>