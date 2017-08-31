<?php

namespace common\traits;

use common\components\LanguageComponent;
use common\helpers\ClassNameHelper;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * Trait for all methods from [common/interfaces/core/TranslatableEntityInterface], exclude
 * [common/interfaces/core/TranslatableEntityInterface::getTranslationClassname].
 *
 * @package common\traits
 */
trait EntityTranslations
{
    /**
     * @inheritdoc
     */
    public function getCurrentTranslation()
    {
        /** @var $this ActiveRecord */
        return $this->hasOne(
            static::getTranslationClassname(),
            [Inflector::camel2id(ClassNameHelper::getShortName(static::class), '_') . '_id' => 'id']
        )
            ->where('`lang_id` = :lang_id', [':lang_id' => LanguageComponent::getCurrent()->id]);
    }

    /**
     * @inheritdoc
     */
    public function getDefaultTranslation()
    {
        /** @var $this ActiveRecord */
        return $this->hasOne(static::getTranslationClassname(),
            [Inflector::camel2id(ClassNameHelper::getShortName(static::class), '_') . '_id' => 'id'])
            ->where('`lang_id` = :lang_id', [':lang_id' => LanguageComponent::getDefault()]);
    }

    /**
     * @inheritdoc
     */
    public function getTranslations()
    {
        /** @var $this ActiveRecord */
        return $this->hasMany(static::getTranslationClassname(),
            [
                Inflector::camel2id(ClassNameHelper::getShortName(static::class), '_') . '_id' => 'id',
            ])->indexBy('lang_id');
    }
}