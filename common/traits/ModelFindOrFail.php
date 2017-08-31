<?php

namespace common\traits;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * FindOrFail method for AR models
 *
 * @package common\traits
 */
trait ModelFindOrFail
{
    /**
     * Find model by condition
     *
     * @param int|array $condition Condition for search
     *
     * @return static
     * @throws \yii\web\NotFoundHttpException
     */
    public static function findOrFail($condition)
    {
        if (!method_exists(static::class, 'findOne')){
            throw new \DomainException('Method "findOne" not found in ' . static::class);
        }
        if (($model = static::findOne($condition)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}