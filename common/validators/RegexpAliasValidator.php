<?php
namespace common\validators;

use Yii;
use yii\validators\Validator;

/**
 * Validate alias
 *
 * @package common\validators
 */
class RegexpAliasValidator extends Validator
{
    /**
     * @param \yii\base\Model $model
     * @param string          $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        if (preg_match('#^[a-zA-Z0-9_\-]*$#i', $model->$attribute) === 0) {
            $this->addError(
                $model,
                $attribute,
                Yii::t('core/errors', 'alias_has_incorrect_format')
            );
        }
    }
}