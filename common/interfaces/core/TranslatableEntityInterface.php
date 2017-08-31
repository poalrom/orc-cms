<?php

namespace common\interfaces\core;

/**
 * Interface for entity with translations
 *
 * @property EntityTranslationInterface   $currentTranslation Translation on current language
 * @property EntityTranslationInterface   $defaultTranslation Translation on default language
 * @property EntityTranslationInterface[] $translations All translations
 *
 * @package common\interfaces\core
 */
interface TranslatableEntityInterface
{

    /**
     * Translation classname
     *
     * @return string
     */
    public static function getTranslationClassname();

    /**
     * Get translation for current language
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrentTranslation();

    /**
     * Get translation for default language
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultTranslation();

    /**
     * Get all translation
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations();
}