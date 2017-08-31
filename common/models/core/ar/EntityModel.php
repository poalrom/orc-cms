<?php

namespace common\models\core\ar;

use common\traits\ModelFindOrFail;
use yii\db\ActiveRecord;
use Yii;

/**
 * Base AR model for any entity
 * @package common\models\core\ar
 */
abstract class EntityModel extends ActiveRecord
{
    use ModelFindOrFail;

    public static function getStatuses()
    {
        return [
            Yii::t('core/statuses', 'hidden'),
            Yii::t('core/statuses', 'active'),
        ];
    }

    /**
     * Finding active entities
     *
     * @return \yii\db\ActiveQuery
     */
    public static function findActive()
    {
        return static::find()->andWhere(['is_active' => true]);
    }

    /**
     * Find hidden entities
     *
     * @return \yii\db\ActiveQuery
     */
    public static function findHidden()
    {
        return static::find()->andWhere(['is_active' => false]);
    }
}