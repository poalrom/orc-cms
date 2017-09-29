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
$languages = LanguageComponent::getAll();
?>
<ul class="icons lang-switcher">
    <?php foreach ($languages as $language): ?>
        <?php if (!$showAllLanguages &&
            (
                $language->isCurrent() ||
                !isset($this->entity->translations[$language->id]) ||
                $this->entity->translations[$language->id]->isEmpty()
            )
        ): ?>
            <li class="<?= $language->isCurrent() ? 'lang_current' : 'lang_inactive' ?>">
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
