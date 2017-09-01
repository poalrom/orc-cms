<?php

namespace common\traits;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Trait for ActiveRecord which add method "getList"
 *
 * @package common\traits
 */
trait ModelGetList
{
    /**
     * @var string Value column for model list
     */
    protected static $listTitle = 'currentTranslation.title';

    /**
     * Getting list of models filtered by conditions
     *
     * @param array $conditions Filtering conditions. See [[ActiveRecord::where]] method for condition format
     *
     * @return array
     */
    public static function getList($conditions = [])
    {
        if (!is_a(static::class, ActiveRecord::class, true)) {
            throw new \DomainException(static::class . " must be instance of ActiveRecord");
        }

        if (method_exists(static::class, 'getCurrentTranslation')) {
            $models = static::find()->where($conditions)->joinWith('currentTranslation')->all();
        } else {
            $models = static::findAll($conditions);
        }

        return ArrayHelper::map(
            $models,
            'id',
            static::$listTitle
        );
    }
}